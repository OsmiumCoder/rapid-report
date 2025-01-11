<?php

namespace Tests\Feature\Incident;

use App\Data\IncidentData;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_shows_create_page_and_has_empty_form(): void
    {
        $response = $this->get(route('incidents.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Incident/Create')
                ->where('form', IncidentData::empty());
        });
    }
}
