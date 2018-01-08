<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

class Success extends Result
{
    public function __construct(array $data)
    {
        parent::__construct(true, $data);
    }
}
