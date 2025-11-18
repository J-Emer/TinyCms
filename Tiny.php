<?php

use Jemer\TinyCms\Commands\MakePageCommand;
use Jemer\TinyCms\Commands\MakePostCommand;
use Jemer\TinyCms\Commands\PageCommand;
use Jemer\TinyCms\Commands\PostCommand;
use Jemer\TinyCms\Commands\ServeCommand;
use Jemer\TinyCms\Helpers\PathHelper;
use Jemer\TinyCms\Loaders\ConfigLoader;
use Symfony\Component\Console\Application;

require "vendor/autoload.php";
require 'bootstrap.php';



ConfigLoader::Load(PathHelper::BuildPath([
    ROOT,
    "config.yaml"
]));

$app = new Application();

$app->add(new MakePostCommand());
$app->add(new MakePageCommand());
$app->add(new ServeCommand());




$app->run();


?>