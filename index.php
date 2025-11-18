<?php

use Jemer\TinyCms\App;
use Jemer\TinyCms\Helpers\PathHelper;
use Jemer\TinyCms\Loaders\ConfigLoader;
use Jemer\TinyCms\Loaders\PageLoader;
use Jemer\TinyCms\Loaders\PostLoader;
use Jemer\TinyCms\Loaders\PostLoader_2;
use Symfony\Component\VarDumper\VarDumper;

require "vendor/autoload.php";
require "bootstrap.php";



$app = new App();
$app->Run();




?>