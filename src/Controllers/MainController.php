<?php 

namespace Jemer\TinyCms\Controllers;

use Jemer\TinyCms\Loaders\PageLoader;
use Jemer\TinyCms\Loaders\PostLoader;
use Jemer\TinyCms\Loaders\TemplateLoader;
use Symfony\Component\VarDumper\VarDumper;

class MainController
{
    private PageLoader $pageLoader;
    private PostLoader $postLoader;
    private TemplateLoader $templateLoader;

    public function __construct()
    {
        $this->pageLoader = new PageLoader();
        $this->postLoader = new PostLoader();
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

    public function post(string $slug)
    {
        $post = $this->postLoader->GetPost($slug);
        $nav = $this->pageLoader->GetNav();

        $template = $post->template ?? 'post';

        $this->templateLoader->Render($template . ".twig", [
            "post" => $post,
            "nav" => $nav
        ]);
    }

    public function category(string $cat)
    {
        $posts = $this->postLoader->GetPostsByCat($cat);
        $nav = $this->pageLoader->GetNav();

        $this->templateLoader->Render('list.twig', [
            "posts" => $posts,
            "nav" => $nav
        ]);
    }

    public function categories() 
    {
        $categories = $this->postLoader->GetAllCategories();
        $nav = $this->pageLoader->GetNav();

        $this->templateLoader->Render('list.twig', [
            "categories" => $categories,
            "nav" => $nav
        ]);
    }
}


?>