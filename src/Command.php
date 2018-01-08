<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

use Amp\Promise;

interface Command
{
    /**
     * @return Promise<Result> The payload data to send back to the client
     */
    public function execute(Input $input): Promise;
}
