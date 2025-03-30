<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:stats',
    description: 'Affiche les statistiques du site',
    aliases: ['app:show-stats']
)]
class StatsCommand extends Command
{
    public function __construct(

        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        private UserRepository $userRepository,


    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }
        $nbUsers = $this->userRepository->count();
        $nbGames = $this->productRepository->count();
        $allCategories = $this->categoryRepository->findAll();
        $products = $this->productRepository->findAll();

        $sum = 0;

        foreach ($products as $product) {

            $sum = $sum + $product->getPrice();
        }

        $avgPrice = $sum / $nbGames;


        $io->listing([
            'Number of users : ' . $nbUsers,
            'Number of games : ' . $nbGames,
        ]);

        $io->section('List of categories : ');


        foreach ($allCategories as $category) {

            $io->writeln(

                $category->getLabel()

            );
        }

        $io->writeln(' ');

        $io->writeln('<fg=green>Average Price : </>' . round($avgPrice));












        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
