<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use PeeHaa\AmpWebsocketCommand\Success;
use PHPUnit\Framework\TestCase;

class SuccessTest extends TestCase
{
    public function testSuccessStatusIsTrue()
    {
        $result = json_decode((string) new Success(['id' => 1337, 'name' => 'T. Test']), true);

        $this->assertTrue($result['success']);
    }

    public function testPayloadIsSetCorrectly()
    {
        $result = json_decode((string) new Success(['id' => 1337, 'name' => 'T. Test']), true);

        $this->assertSame(1337, $result['payload']['id']);
        $this->assertSame('T. Test', $result['payload']['name']);
    }
}
