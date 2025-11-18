<?php 

namespace Jemer\TinyCms\Commands;

use Jemer\TinyCms\Helpers\PathHelper;
use Jemer\TinyCms\Loaders\ConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakePageCommand extends Command
{
    protected static $defaultName = 'make:page';

    protected function configure(): void
    {
        $this
            ->setName('make:page')
            ->setDescription('Creates a new Markdown page in the pages directory')
            ->addArgument('name', InputArgument::REQUIRED, 'The title of the page');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $slug = $this->slugify($name);

        $filePath = PathHelper::BuildPath([ROOT, "content", "pages", $slug . '.md']);

        // Prevent overwriting existing file
        if (file_exists($filePath)) {
            $output->writeln("<error>Page already exists: {$filePath}</error>");
            return Command::FAILURE;
        }

        $content = $this->buildTemplate($name, $slug);

        file_put_contents($filePath, $content);

        $output->writeln("<info>Page created:</info> {$filePath}");
        return Command::SUCCESS;
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }

    private function buildTemplate(string $title, string $slug): string
    {
        $date = date('Y-m-d');

        return <<<EOT
---
title: "{$title}"
slug: "{$slug}"
date: {$date}
template: page
isnav: false
---

Your page content here.
EOT;
    }
}


?>