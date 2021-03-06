<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use PeeHaa\AmpWebsocketCommand\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testSuccessStatusIsCorrect()
    {
        $result = json_decode((string) new class extends Result {
            public function __construct()
            {
                parent::__construct(true, ['id' => 1337, 'name' => 'T. Test']);
            }
        }, true);

        $this->assertTrue($result['success']);
    }

    public function testPayloadIsSetCorrectly()
    {
        $result = json_decode((string) new class extends Result {
            public function __construct()
            {
                parent::__construct(true, ['id' => 1337, 'name' => 'T. Test']);
            }
        }, true);

        $this->assertSame(1337, $result['payload']['id']);
        $this->assertSame('T. Test', $result['payload']['name']);
    }
}
