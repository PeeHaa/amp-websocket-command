<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

class CommandTuple
{
    private $commandName;

    private $commandClass;

    public function __construct(string $commandName, string $commandClass)
    {
        $this->commandName  = $commandName;
        $this->commandClass = $commandClass;
    }

    public function getCommandName(): string
    {
        return $this->commandName;
    }

    public function getCommandClass(): string
    {
        return $this->commandClass;
    }
}
