<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use PeeHaa\AmpWebsocketCommand\CommandTuple;
use PHPUnit\Framework\TestCase;

class CommandTupleTest extends TestCase
{
    public function testGetCommandNameReturnCorrectName()
    {
        $this->assertSame('commandName', (new CommandTuple('commandName', '\Command\Class'))->getCommandName());
    }

    public function testGetCommandClassReturnCorrectClass()
    {
        $this->assertSame('\Command\Class', (new CommandTuple('commandName', '\Command\Class'))->getCommandClass());
    }
}
