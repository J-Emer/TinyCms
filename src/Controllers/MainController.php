<?php 

namespace Jemer\TinyCms\Controllers;

use Jemer\TinyCms\Loaders\PageLoader;
use Symfony\Component\VarDumper\VarDumper;

class MainController
{
    private PageLoader $pageLoader;

    public function __construct()
    {
        $this->pageLoader = new PageLoader();
    }

    public function page(string $slug)
    {
        VarDumper::dump($this->pageLoader->GetPage($slug));
        VarDumper::dump($this->pageLoader->GetNav());

    }
}


?>