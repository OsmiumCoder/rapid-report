<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_incident_index_passes_current_filters_and_sort_props()
    {
        $email = 'a@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['descriptor' => 'a', 'reporters_email' => $email]);
        Incident::factory()->create(['descriptor' => 'b', 'reporters_email' => $email]);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route(
            'incidents.owned',
            ['filters' => urlencode(json_encode(
                [
                    ['column' => 'descriptor', 'value' => 'a', 'comparator' => '=']
                ]
            )),
                'sort_by' => 'descriptor',
                'sort_direction' => 'asc'
            ]
        ));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page->component('Incident/Index')
            ->has('currentSortBy')
            ->where('currentSortBy', 'descriptor')
            ->has('currentSortDirection')
            ->where('currentSortDirection', 'asc')
            ->has('currentFilters', 1)
            ->where('currentFilters.0.column', 'descriptor')
            ->where('currentFilters.0.value', 'a')
            ->where('currentFilters.0.comparator', '=')
        );
    }
    public function test_owned_route_filters_incidents()
    {
        $email = 'a@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['descriptor' => 'a', 'reporters_email' => $email]);
        Incident::factory()->create(['descriptor' => 'b', 'reporters_email' => $email]);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route(
            'incidents.owned',
            ['filters' => urlencode(json_encode(
                [
                    ['column' => 'descriptor', 'value' => 'a', 'comparator' => '=']
                ]
            ))
            ]
        ));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->whereNot('descriptor', 'b')
                                ->etc()
                        )->etc()
                )
        );
    }

    public function test_assigned_route_filters_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory()->create(['descriptor' => 'a', 'supervisor_id' => $supervisor->id]);
        Incident::factory()->create(['descriptor' => 'b', 'supervisor_id' => $supervisor->id]);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route(
            'incidents.assigned',
            ['filters' => urlencode(json_encode(
                [
                    ['column' => 'descriptor', 'value' => 'a', 'comparator' => '=']
                ]
            ))
            ]
        ));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->whereNot('descriptor', 'b')
                                ->etc()
                        )->etc()
                )
        );
    }

    public function test_index_route_filters_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory()->create(['descriptor' => 'a']);
        Incident::factory()->create(['descriptor' => 'b']);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route(
            'incidents.index',
            ['filters' => urlencode(json_encode(
                [
                    ['column' => 'descriptor', 'value' => 'a', 'comparator' => '=']
                ]
            ))
            ]
        ));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->whereNot('descriptor', 'b')
                                ->etc()
                        )->etc()
                )
        );
    }

    public function test_assigned_route_sorts_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory()->create(['descriptor' => 'a', 'supervisor_id' => $supervisor->id]);
        Incident::factory()->create(['descriptor' => 'b', 'supervisor_id' => $supervisor->id]);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route('incidents.assigned', ['sortBy' => 'descriptor', 'sort_direction' => 'asc']));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->etc()
                        )->etc()
                )
        );
    }

    public function test_owned_route_sorts_incidents()
    {
        $email = 'a@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['descriptor' => 'a', 'reporters_email' => $email]);
        Incident::factory()->create(['descriptor' => 'b', 'reporters_email' => $email]);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route('incidents.owned', ['sortBy' => 'descriptor', 'sort_direction' => 'asc']));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->etc()
                        )->etc()
                )
        );
    }

    public function test_index_route_sorts_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory()->create(['descriptor' => 'a']);
        Incident::factory()->create(['descriptor' => 'b']);

        $this->assertDatabaseCount('incidents', 2);

        $response = $this->get(route('incidents.index', ['sortBy' => 'descriptor', 'sort_direction' => 'asc']));

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('descriptor', 'a')
                                ->etc()
                        )->etc()
                )
        );

    }

    public function test_assigned_incidents_is_paginated()
    {
        $email = 'email@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('supervisor');
        $this->actingAs($user);

        Incident::factory()->create(['supervisor_id' => $user->id]);

        $response = $this->get(route('incidents.assigned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
                ->where('indexType', 'assigned')
        );
    }

    public function test_owned_incidents_is_paginated()
    {
        $email = 'email@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['reporters_email' => $email]);

        $response = $this->get(route('incidents.owned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
                ->where('indexType', 'owned')
        );
    }

    public function test_forbidden_if_basic_user_access_assigned_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.assigned'));

        $response->assertForbidden();
    }

    public function test_show_owned_incidents_returns_correct_incidents(): void
    {
        $email = 'email@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['reporters_email' => $email]);

        $response = $this->get(route('incidents.owned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->count('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('reporters_email', $email)
                                ->etc()
                        )
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
                ->where('indexType', 'owned')
        );
    }

    public function test_show_assigned_incidents_returns_correct_incidents(): void
    {
        $user = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($user);

        Incident::factory()->create(['supervisor_id' => $user->id]);

        $response = $this->get(route('incidents.assigned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->count('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('supervisor_id', $user->id)
                                ->etc()
                        )
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
                ->where('indexType', 'assigned')
        );
    }

    public function test_must_be_auth(): void
    {
        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertFound();
        $response->assertRedirect(route('login'));
    }

    public function test_forbidden_if_supervisor(): void
    {
        $user = User::factory()->create([
            'name' => 'supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertForbidden();
    }

    public function test_forbidden_if_basic_user_access_all_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertForbidden();
    }

    public function test_shows_index_page_with_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $this->actingAs($user);

        Incident::factory()->count(20)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $page) => $page
                        ->where('current_page', 1)
                        ->count('data', 10)
                        ->where('from', 1)
                        ->where('to', 10)
                        ->where('last_page', 2)
                        ->count('links', 4)
                        ->etc()
                )
                ->where('indexType', 'all');
        });
    }
}
