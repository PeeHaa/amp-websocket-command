<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Unit;

use PeeHaa\AmpWebsocketCommand\Exception\InvalidJson;
use PeeHaa\AmpWebsocketCommand\Exception\InvalidParameterType;
use PeeHaa\AmpWebsocketCommand\Exception\MissingParameter;
use PeeHaa\AmpWebsocketCommand\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testThrowsOnInvalidJson()
    {
        $this->expectException(InvalidJson::class);
        $this->expectExceptionMessage('Message could not be decoded.');

        new Input('invalid-json');
    }

    public function testThrowsOnMissingCommandParameter()
    {
        $this->expectException(MissingParameter::class);
        $this->expectExceptionMessage('Missing `command` parameter.');

        new Input('{}');
    }

    public function testThrowsOnIncorrectCommandParameterType()
    {
        $this->expectException(InvalidParameterType::class);
        $this->expectExceptionMessage('Parameter `command` is expected to be of type `string`, but type `integer` is given.');

        new Input('{"command": 1337}');
    }

    public function testBuildsInstanceOnSuccess()
    {
        $this->assertInstanceOf(Input::class, new Input('{"command": "test-command"}'));
    }

    public function testGetCommand()
    {
        $this->assertSame('test-command', (new Input('{"command": "test-command"}'))->getCommand());
    }

    public function testParameterExistsReturnsFalse()
    {
        $this->assertFalse((new Input('{"command": "test-command"}'))->parameterExists('param1'));
    }

    public function testParameterExistsReturnsTrue()
    {
        $this->assertTrue((new Input('{"command": "test-command", "param1": "value1"}'))->parameterExists('param1'));
    }

    public function testGetParameterThrowsOnMissingParameter()
    {
        $this->expectException(MissingParameter::class);
        $this->expectExceptionMessage('Missing `param1` parameter.');

        (new Input('{"command": "test-command"}'))->getParameter('param1');
    }

    public function testGetParameterReturnsCorrectValue()
    {
        $this->assertSame('value1', (new Input('{"command": "test-command", "param1": "value1"}'))->getParameter('param1'));
    }
}
