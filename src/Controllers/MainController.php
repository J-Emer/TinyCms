<?php 

namespace Jemer\TinyCms\Controllers;

use Jemer\TinyCms\Loaders\PageLoader;
use Jemer\TinyCms\Loaders\TemplateLoader;
use Symfony\Component\VarDumper\VarDumper;

class MainController
{
    private PageLoader $pageLoader;
    private TemplateLoader $templateLoader;

    public function __construct()
    {
        $this->pageLoader = new PageLoader();
        $this->templateLoader = new TemplateLoader();
    }

    public function page(string $slug)
    {
        $page = $this->pageLoader->GetPage($slug);
        $nav = $this->pageLoader->GetNav();

        $this->templateLoader->Render($page->template . ".twig", [
            "page" => $page,
            "nav" => $nav
        ]);
    }
}


?>