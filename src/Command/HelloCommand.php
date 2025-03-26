<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:hello',
    description: 'Commande de test pour dire bonjour',
)]
class HelloCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fname', InputArgument::REQUIRED, 'Le prénom de la personne à qui on dit bonjour')
            ->addArgument('lname', InputArgument::OPTIONAL, 'Le nom de famille de la personne à qui on dit bonjour');
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fname = $input->getArgument('fname');
        $lname = $input->getArgument('lname');

        if ($fname && $lname) {

            $io->writeln('Bonjour ' . $fname . " " . $lname . " !");
        }

        // if ($lname) {
        //     $io->note(sprintf('You passed an argument: %s', $lname));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        // $io->success('You succesfully got greeted :) CONGRATS !!');

        return Command::SUCCESS;
    }
}
