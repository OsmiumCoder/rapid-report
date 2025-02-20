<?php

namespace Tests\Unit\Reactors;

use App\Reactors\StoredEventReactor;
use App\StorableEvents\StoredEvent;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class StoredEventReactorTest extends MockeryTestCase
{
    public function test_stored_event_react_method_called()
    {
        $mock = Mockery::spy(StoredEvent::class);

        $mock->shouldReceive("react")->once();

        $mock->shouldNotReceive("handle");

        $this->getProjector()->onStoredEvent($mock);

        $mock->shouldHaveReceived("react");

        $mock->shouldNotHaveReceived("handle");
    }

    private function getProjector()
    {
        return new StoredEventReactor;
    }
}
