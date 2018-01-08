<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

class Failure extends Result
{
    public function __construct(string $message)
    {
        parent::__construct(false, ['message' => $message]);
    }
}
