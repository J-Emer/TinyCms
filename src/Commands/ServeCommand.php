<?php

namespace Jemer\TinyCms\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    protected static $defaultName = 'serve';

    protected function configure(): void
    {
        $this
            ->setName('serve')
            ->setDescription('Start the built-in PHP development server')
            ->addArgument('host', InputArgument::OPTIONAL, 'Host and port to serve', '127.0.0.1:8000');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host = $input->getArgument('host');

        $output->writeln("<info>Starting server at http://{$host}</info>");
        $output->writeln("Press Ctrl+C to stop the server");

        // Build the PHP built-in server command
        $docRoot = escapeshellarg(ROOT); // change if your doc root is different
        $cmd = sprintf('php -S %s -t %s', $host, $docRoot);

        // Run the command interactively
        passthru($cmd);

        return Command::SUCCESS;
    }
}
