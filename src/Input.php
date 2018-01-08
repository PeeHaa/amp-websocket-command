<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

use ExceptionalJSON\DecodeErrorException;
use PeeHaa\AmpWebsocketCommand\Exception\InvalidJson;
use PeeHaa\AmpWebsocketCommand\Exception\InvalidParameterType;
use PeeHaa\AmpWebsocketCommand\Exception\MissingParameter;

class Input
{
    private $command;

    private $parameters = [];

    public function __construct(string $json)
    {
        try {
            $data = json_try_decode($json, true);
        } catch (DecodeErrorException $e) {
            throw new InvalidJson('Message could not be decoded.', 0, $e);
        }

        if (!array_key_exists('command', $data)) {
            throw new MissingParameter('Missing `command` parameter.');
        }

        if (!is_string($data['command'])) {
            throw new InvalidParameterType(
                sprintf(
                    'Parameter `command` is expected to be of type `string`, but type `%s` is given.',
                    gettype($data['command'])
                )
            );
        }

        $this->command = $data['command'];

        unset($data['command']);

        $this->parameters = $data;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function parameterExists(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    public function getParameter(string $key)
    {
        if (!array_key_exists($key, $this->parameters)) {
            throw new MissingParameter(sprintf('Missing `%s` parameter.', $key));
        }

        return $this->parameters[$key];
    }
}
