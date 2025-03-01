<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Models\Incident;
use App\StorableEvents\Incident\AdditionalInformationAdded;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdditionalInformationAddedTest extends TestCase
{
    public function test_first_additional_creates_new_array()
    {
        $incident = Incident::factory()->create();

        $this->assertNull($incident->additional_information);

        $event = new AdditionalInformationAdded("information");
        $event->setAggregateRootUuid($incident->id);

        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->additional_information);
        $this->assertEquals("information", $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );
    }

    public function test_additional_appends_to_current_additional_information()
    {
        $incident = Incident::factory()->create([
            'additional_information' => [
                ['information' => 'information 1', 'created_at' => now()->timestamp],
            ]
        ]);

        $this->assertCount(1, $incident->additional_information);

        $event = new AdditionalInformationAdded("information 2");
        $event->setAggregateRootUuid($incident->id);

        $event->handle();

        $incident->refresh();

        $this->assertCount(2, $incident->additional_information);
        $this->assertEquals("information 1", $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );

        $this->assertEquals("information 2", $incident->additional_information[1]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[1]['created_at'])->timestamp
        );
    }
}
