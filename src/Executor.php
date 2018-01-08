<?php declare(strict_types=1);

namespace PeeHaa\AmpWebsocketCommand;

use Amp\Promise;
use Auryn\Injector;

class Executor
{
    private $commands = [];

    private $auryn;

    public function __construct(Injector $auryn)
    {
        $this->auryn = $auryn;
    }

    public function register(CommandTuple $commandTuple): void
    {
        $this->commands[$commandTuple->getCommandName()] = $commandTuple->getCommandClass();
    }

    /**
     * @return Promise<Result>
     */
    public function execute(string $input): Promise
    {
        try {
            $input = new Input($input);
        } catch (\Throwable $e) {
            return new \Amp\Success(new Failure('Invalid message format'));
        }

        if (!array_key_exists($input->getCommand(), $this->commands)) {
            return new \Amp\Success(new Failure('Unknown command: ' . $input->getCommand()));
        }

        /** @var Command $command */
        $command = $this->auryn->make($this->commands[$input->getCommand()]);

        try {
            return $command->execute($input);
        } catch (\Throwable $e) {
            return new \Amp\Success(new Failure('Invalid message format'));
        }
    }
}
