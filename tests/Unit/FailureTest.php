<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use PeeHaa\AmpWebsocketCommand\Failure;
use PHPUnit\Framework\TestCase;

class FailureTest extends TestCase
{
    public function testSuccessStatusIsFalse()
    {
        $result = json_decode((string) new Failure('Something is broken'), true);

        $this->assertFalse($result['success']);
    }

    public function testMessageIsCorrect()
    {
        $result = json_decode((string) new Failure('Something is broken'), true);

        $this->assertSame('Something is broken', $result['payload']['message']);
    }
}
