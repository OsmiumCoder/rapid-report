<?php

namespace Policies;

use App\Policies\InvestigationPolicy;
use Tests\TestCase;

class InvestigationPolicyTest extends TestCase
{
    public function test_admin_can_not_create_investigation()
    {
    }

    public function test_supervisor_can_create_investigation()
    {
    }

    public function test_user_can_not_create_investigation()
    {
    }

    protected function getPolicy()
    {
        return app(InvestigationPolicy::class);
    }
}
