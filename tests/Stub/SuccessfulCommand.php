<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommandTests\Stub;

use Amp\Promise;
use PeeHaa\AmpWebsocketCommand\Command;
use PeeHaa\AmpWebsocketCommand\Input;
use PeeHaa\AmpWebsocketCommand\Success;

class SuccessfulCommand implements Command
{
    /**
     * @return Promise<Result> The payload data to send back to the client
     */
    public function execute(Input $input): Promise
    {
        return new \Amp\Success(new Success(['id' => 1337, 'name' => 'T. Test']));
    }
}
