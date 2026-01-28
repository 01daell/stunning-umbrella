<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Throwable $e) {
            return response('Webhook signature verification failed.', 400);
        }

        $type = $event->type;
        $object = $event->data->object;

        if (in_array($type, ['customer.subscription.created', 'customer.subscription.updated', 'customer.subscription.deleted'], true)) {
            $this->syncSubscription($object);
        }

        if ($type === 'checkout.session.completed') {
            $this->syncCheckout($object);
        }

        return response('ok', 200);
    }

    protected function syncCheckout($session): void
    {
        if ($session->mode !== 'subscription') {
            return;
        }

        $workspaceId = $session->metadata->workspace_id ?? null;
        if (!$workspaceId) {
            return;
        }

        $workspace = Workspace::find($workspaceId);
        if (!$workspace) {
            return;
        }

        $subscription = $workspace->subscription()->firstOrCreate([], [
            'plan' => $session->metadata->plan ?? 'starter',
        ]);

        $subscription->update([
            'stripe_customer_id' => $session->customer,
            'stripe_subscription_id' => $session->subscription,
            'status' => 'active',
            'plan' => $session->metadata->plan ?? 'starter',
        ]);
    }

    protected function syncSubscription($subscription): void
    {
        $workspaceId = $subscription->metadata->workspace_id ?? null;
        if (!$workspaceId) {
            $workspaceId = Workspace::whereHas('subscription', function ($query) use ($subscription) {
                $query->where('stripe_subscription_id', $subscription->id);
            })->value('id');
        }

        if (!$workspaceId) {
            return;
        }

        Subscription::updateOrCreate([
            'workspace_id' => $workspaceId,
        ], [
            'stripe_customer_id' => $subscription->customer,
            'stripe_subscription_id' => $subscription->id,
            'status' => $subscription->status,
            'plan' => $subscription->metadata->plan ?? 'starter',
            'current_period_end' => date('Y-m-d H:i:s', $subscription->current_period_end),
        ]);
    }
}
