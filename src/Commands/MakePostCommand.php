<?php 

namespace Jemer\TinyCms\Commands;

use Jemer\TinyCms\Helpers\PathHelper;
use Jemer\TinyCms\Loaders\ConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakePostCommand extends Command
{
    protected static $defaultName = 'make:post';

    protected function configure(): void
    {
        $this
            ->setName('make:post')
            ->setDescription('Creates a new Markdown post in the posts directory')
            ->addArgument('name', InputArgument::REQUIRED, 'The title of the post');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $slug = $this->slugify($name);

        $filePath = PathHelper::BuildPath([ROOT, "content", "posts", $slug . '.md']);

        // Prevent overwriting existing file
        if (file_exists($filePath)) {
            $output->writeln("<error>Post already exists: {$filePath}</error>");
            return Command::FAILURE;
        }

        $content = $this->buildTemplate($name, $slug);

        file_put_contents($filePath, $content);

        $output->writeln("<info>Post created:</info> {$filePath}");
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
category: ""
template: post
thumbnail: ""
---

Your post content here.
EOT;
    }
}


?>