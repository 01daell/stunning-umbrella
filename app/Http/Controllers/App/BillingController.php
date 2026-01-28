<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use App\Services\WorkspaceContext;
use Illuminate\Http\Request;
use Stripe\BillingPortal\Session as PortalSession;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class BillingController extends Controller
{
    public function __construct(
        protected WorkspaceContext $context,
        protected PlanService $plans,
    ) {
    }

    public function index(Request $request)
    {
        $workspace = $this->context->current($request->user());

        return view('app.billing.index', [
            'workspace' => $workspace->load('subscription'),
            'plan' => $this->plans->getPlan($workspace),
            'status' => $this->plans->subscriptionStatusLabel($workspace->subscription),
        ]);
    }

    public function checkout(Request $request, string $plan)
    {
        $workspace = $this->context->current($request->user());
        $prices = config('services.stripe.prices');

        if (!isset($prices[$plan])) {
            abort(404);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $prices[$plan],
                'quantity' => 1,
            ]],
            'customer' => $workspace->subscription?->stripe_customer_id,
            'subscription_data' => [
                'metadata' => [
                    'workspace_id' => $workspace->id,
                    'plan' => $plan,
                ],
            ],
            'success_url' => route('app.billing').'?success=1',
            'cancel_url' => route('app.billing').'?canceled=1',
            'metadata' => [
                'workspace_id' => $workspace->id,
                'plan' => $plan,
            ],
        ]);

        return redirect($session->url);
    }

    public function portal(Request $request)
    {
        $workspace = $this->context->current($request->user());

        if (!$workspace->subscription?->stripe_customer_id) {
            return redirect()->route('app.billing')->with('status', 'No Stripe customer found.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = PortalSession::create([
            'customer' => $workspace->subscription->stripe_customer_id,
            'return_url' => route('app.billing'),
        ]);

        return redirect($session->url);
    }
}
