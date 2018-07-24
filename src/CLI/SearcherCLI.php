<?php

namespace App\CLI;

use App\Command\SearchCommand;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SearcherCLI extends Command
{
    private const ARG_FILENAME = 'filename';
    private const ARG_DAY = 'day';
    private const ARG_TIME = 'time';
    private const ARG_LOCATION = 'location';
    private const ARG_COVER = 'cover';
    private const ARGS = [
        self::ARG_FILENAME => 'Input file with the data',
        self::ARG_DAY => 'Delivery day (dd/mm/yy)',
        self::ARG_TIME => 'Delivery time in 24h format (hh:mm)',
        self::ARG_LOCATION => 'Delivery location (postcode without spaces, e.g. NW43QB)',
        self::ARG_COVER => 'Number of people to feed',
    ];
    /** @var CommandBus */
    private $commandBus;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(?string $name = null, CommandBus $commandBus, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($name);
        $this->commandBus = $commandBus;
        $this->dispatcher = $dispatcher;
    }

    protected function configure(): void
    {
        $this->setName('app:find-meal')
            ->setDescription('Find meal with specific requirements')
            ->setHelp('This command allows you to find a proper meal according to your needs')
            ->setDefinition(new InputDefinition($this->configureArguments()));
    }

    /** @throws \Throwable */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln(['<info>Meal Finder Started</info>', '<comment>==============</comment>']);
        try {
            $this->commandBus->handle(
                new SearchCommand(
                    $input->getArgument(self::ARG_FILENAME),
                    $input->getArgument(self::ARG_DAY),
                    $input->getArgument(self::ARG_TIME),
                    $input->getArgument(self::ARG_LOCATION),
                    $input->getArgument(self::ARG_COVER)
                )
            );

        } catch (\Throwable $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
        }
    }

    private function configureArguments(): array
    {
        $arguments = [];
        foreach (self::ARGS as $name => $description) {
            $arguments[] = new InputArgument($name, InputArgument::REQUIRED, $description);
        }

        return $arguments;
    }
}
