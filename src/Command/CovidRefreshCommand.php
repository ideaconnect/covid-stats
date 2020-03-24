<?php

namespace App\Command;

use App\Entity\StatsSource;
use App\Factory\HandlerFactory;
use App\Repository\StatsSourceRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CovidRefreshCommand extends Command
{
    protected static $defaultName = 'covid:refresh';

    /** @var StatsSourceRepository */
    protected $statsSources;

    /** @var HandlerFactory */
    protected $handlerFactory;

    public function __construct(StatsSourceRepository $statsSources, HandlerFactory $handlerFactory)
    {
        $this->statsSources = $statsSources;
        $this->handlerFactory = $handlerFactory;
        parent::__construct($this->getDefaultName());
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var StatsSource */
        foreach($this->statsSources->findAll() as $source) {
            $handler = $this->handlerFactory->createHandler($source);
            $changes = $handler->handle();
            $io->writeln($source->getName() . ': ' . $changes . ' changes.');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return 0;
    }
}
