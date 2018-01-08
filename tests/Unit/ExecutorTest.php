<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use Amp\Promise;
use Auryn\Injector;
use PeeHaa\AmpWebsocketCommand\CommandTuple;
use PeeHaa\AmpWebsocketCommand\Executor;
use PeeHaa\AmpWebsocketCommand\Failure;
use PeeHaa\AmpWebsocketCommand\Success;
use PeeHaa\AmpWebsocketCommandTests\Stub\SuccessfulCommand;
use PeeHaa\AmpWebsocketCommandTests\Stub\ThrowingCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExecutorTest extends TestCase
{
    /** @var Injector|MockObject */
    private $aurynMock;

    public function setUp()
    {
        $this->aurynMock = $this->createMock(Injector::class);
    }

    public function testExecuteReturnsFailureOnInvalidJson()
    {
        $result = Promise\wait((new Executor($this->aurynMock))->execute('invalid-json'));

        $this->assertInstanceOf(Failure::class, $result);
    }

    public function testExecuteReturnsCorrectDataOnInvalidJson()
    {
        $result = Promise\wait((new Executor($this->aurynMock))->execute('invalid-json'));

        $expected = json_encode([
            'success' => false,
            'payload' => [
                'message' => 'Invalid message format',
            ],
        ]);

        $this->assertSame($expected, (string) $result);
    }

    public function testExecuteReturnsFailureOnInvalidCommand()
    {
        $result = Promise\wait((new Executor($this->aurynMock))->execute('{"command": "test-command"}'));

        $this->assertInstanceOf(Failure::class, $result);
    }

    public function testExecuteReturnsCorrectDataOnInvalidCommand()
    {
        $result = Promise\wait((new Executor($this->aurynMock))->execute('{"command": "test-command"}'));

        $expected = json_encode([
            'success' => false,
            'payload' => [
                'message' => 'Unknown command: test-command',
            ],
        ]);

        $this->assertSame($expected, (string) $result);
    }

    public function testExecuteBuildsCorrectCommand()
    {
        $this->aurynMock
            ->expects($this->once())
            ->method('make')
            ->willReturn(new ThrowingCommand())
            ->with($this->equalTo('\My\Test\Command'))
        ;

        $executor = new Executor($this->aurynMock);

        $executor->register(new CommandTuple('test-command', '\My\Test\Command'));
        $executor->register(new CommandTuple('test-command2', '\My\Test\Command2'));

        $result = Promise\wait($executor->execute('{"command": "test-command"}'));

        $this->assertInstanceOf(Failure::class, $result);
    }

    public function testExecuteReturnsFailureWhenThrowingFromCommand()
    {
        $this->aurynMock
            ->expects($this->once())
            ->method('make')
            ->willReturn(new ThrowingCommand())
            ->with($this->equalTo('\My\Test\Command'))
        ;

        $executor = new Executor($this->aurynMock);

        $executor->register(new CommandTuple('test-command', '\My\Test\Command'));

        $result = Promise\wait($executor->execute('{"command": "test-command"}'));

        $this->assertInstanceOf(Failure::class, $result);
    }

    public function testExecuteReturnsCorrectDataWhenThrowingFromCommand()
    {
        $this->aurynMock
            ->expects($this->once())
            ->method('make')
            ->willReturn(new ThrowingCommand())
            ->with($this->equalTo('\My\Test\Command'))
        ;

        $executor = new Executor($this->aurynMock);

        $executor->register(new CommandTuple('test-command', '\My\Test\Command'));

        $result = Promise\wait($executor->execute('{"command": "test-command"}'));

        $expected = json_encode([
            'success' => false,
            'payload' => [
                'message' => 'Invalid message format',
            ],
        ]);

        $this->assertSame($expected, (string) $result);
    }

    public function testExecuteReturnsSuccessOnSuccessfulCommand()
    {
        $this->aurynMock
            ->expects($this->once())
            ->method('make')
            ->willReturn(new SuccessfulCommand())
            ->with($this->equalTo('\My\Test\Command'))
        ;

        $executor = new Executor($this->aurynMock);

        $executor->register(new CommandTuple('test-command', '\My\Test\Command'));

        $result = Promise\wait($executor->execute('{"command": "test-command"}'));

        $this->assertInstanceOf(Success::class, $result);
    }

    public function testExecuteReturnsCorrectDataOnSuccessfulCommand()
    {
        $this->aurynMock
            ->expects($this->once())
            ->method('make')
            ->willReturn(new SuccessfulCommand())
            ->with($this->equalTo('\My\Test\Command'))
        ;

        $executor = new Executor($this->aurynMock);

        $executor->register(new CommandTuple('test-command', '\My\Test\Command'));

        $result = Promise\wait($executor->execute('{"command": "test-command"}'));

        $expected = json_encode([
            'success' => true,
            'payload' => [
                'id'   => 1337,
                'name' => 'T. Test',
            ],
        ]);

        $this->assertSame($expected, (string) $result);
    }
}
