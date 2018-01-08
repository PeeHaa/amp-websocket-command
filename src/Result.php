<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

abstract class Result
{
    private $success;

    private $data;

    public function __construct(bool $success, array $data)
    {
        $this->success = $success;
        $this->data    = $data;
    }

    public function __toString(): string
    {
        return json_encode([
            'success' => $this->success,
            'payload' => $this->data,
        ]);
    }
}
