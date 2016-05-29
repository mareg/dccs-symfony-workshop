<?php

namespace Mareg\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mareg\Calculator\Calculator;

class CalculatorSubCommand extends Command
{
    private $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('calc:sub')
            ->setDescription('Calculates substruction of two numbers')
            ->addArgument('a', InputArgument::REQUIRED)
            ->addArgument('b', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $a = $input->getArgument('a');
        $b = $input->getArgument('b');

        $output->writeln(sprintf(
            "%d - %d = %d",
            $a,
            $b,
            $this->calculator->sub($a, $b)
        ));
    }
}