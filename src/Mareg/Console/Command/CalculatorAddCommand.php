<?php

namespace Mareg\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mareg\Calculator\Calculator;

class CalculatorAddCommand extends Command
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
            ->setName('calc:add')
            ->setDescription('Adds two numbers')
            ->addArgument('a', InputArgument::REQUIRED)
            ->addArgument('b', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $a = $input->getArgument('a');
        $b = $input->getArgument('b');

        $output->writeln(sprintf(
            "%d + %d = %d",
            $a,
            $b,
            $this->calculator->add($a, $b)
        ));
    }
}