<?php

namespace Tests\Unit;

use App\Projectors\StoredEventProjector;
use App\StorableEvents\StoredEvent;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class StoredEventProjectorTest extends MockeryTestCase
{
    public function test_stored_event_handle_method_called() {
        $mock = Mockery::spy(StoredEvent::class);

        $mock->shouldReceive("handle")->once();

        $mock->shouldNotReceive("react");

        $this->getProjector()->onStoredEvent($mock);

        $mock->shouldHaveReceived("handle");

        $mock->shouldNotHaveReceived("react");
    }

    private function getProjector() {
        return new StoredEventProjector;
    }
}
