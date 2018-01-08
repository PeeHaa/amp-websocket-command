<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Stub;

use Amp\Promise;
use PeeHaa\AmpWebsocketCommand\Command;
use PeeHaa\AmpWebsocketCommand\Exception\MissingParameter;
use PeeHaa\AmpWebsocketCommand\Input;

class ThrowingCommand implements Command
{
    /**
     * @return Promise<Result> The payload data to send back to the client
     */
    public function execute(Input $input): Promise
    {
        throw new MissingParameter('Missing `foobar` parameter.');
    }
}
