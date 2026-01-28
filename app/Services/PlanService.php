<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Workspace;

class PlanService
{
    public const PLAN_FREE = 'free';
    public const PLAN_STARTER = 'starter';
    public const PLAN_PRO = 'pro';
    public const PLAN_AGENCY = 'agency';
    public const PLAN_ENTERPRISE = 'enterprise';

    public function getPlan(Workspace $workspace): string
    {
        $subscription = $workspace->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            return self::PLAN_FREE;
        }

        return $subscription->plan ?? self::PLAN_FREE;
    }

    public function kitLimit(string $plan): ?int
    {
        return match ($plan) {
            self::PLAN_FREE => 1,
            self::PLAN_STARTER => 3,
            self::PLAN_PRO, self::PLAN_AGENCY, self::PLAN_ENTERPRISE => null,
            default => 1,
        };
    }

    public function canCreateKit(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);
        $limit = $this->kitLimit($plan);

        if ($limit === null) {
            return true;
        }

        return $workspace->kits()->count() < $limit;
    }

    public function canShareLinks(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);

        return in_array($plan, [self::PLAN_PRO, self::PLAN_AGENCY, self::PLAN_ENTERPRISE], true);
    }

    public function canZipExport(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);

        return in_array($plan, [self::PLAN_PRO, self::PLAN_AGENCY, self::PLAN_ENTERPRISE], true);
    }

    public function canInviteClients(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);

        return in_array($plan, [self::PLAN_AGENCY, self::PLAN_ENTERPRISE], true);
    }

    public function canWhiteLabel(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);

        return in_array($plan, [self::PLAN_AGENCY, self::PLAN_ENTERPRISE], true);
    }

    public function requiresWatermark(Workspace $workspace): bool
    {
        return $this->getPlan($workspace) === self::PLAN_FREE;
    }

    public function allowsTemplates(Workspace $workspace): array
    {
        $plan = $this->getPlan($workspace);

        return match ($plan) {
            self::PLAN_FREE => ['SOCIAL_PROFILE'],
            self::PLAN_STARTER => ['SOCIAL_PROFILE', 'SOCIAL_BANNER', 'FAVICON', 'EMAIL_SIGNATURE'],
            default => ['SOCIAL_PROFILE', 'SOCIAL_BANNER', 'FAVICON', 'EMAIL_SIGNATURE'],
        };
    }

    public function allowsPresets(Workspace $workspace): bool
    {
        $plan = $this->getPlan($workspace);

        return in_array($plan, [self::PLAN_PRO, self::PLAN_AGENCY, self::PLAN_ENTERPRISE], true);
    }

    public function subscriptionStatusLabel(?Subscription $subscription): string
    {
        if (!$subscription) {
            return 'Free';
        }

        return match ($subscription->status) {
            'active' => ucfirst($subscription->plan ?? 'free'),
            'past_due' => 'Past due',
            'canceled' => 'Canceled',
            default => ucfirst($subscription->status ?? 'free'),
        };
    }
}
