<?php 

namespace Jemer\TinyCms;

use Bramus\Router\Router;
use Jemer\TinyCms\Loaders\ConfigLoader;

class App
{
    private Router $router;

    public function __construct()
    {
        ConfigLoader::Load(CONFIG);

        $this->router = new Router();
        $this->LoadRoutes();
    }

    private function LoadRoutes()
    {
        $this->router->setNamespace('Jemer\TinyCms\Controllers');

        $this->router->get('/', "MainController@index");
        $this->router->get('/page/{slug}', "MainController@page");
        $this->router->get('/post/{slug}', "MainController@post");
        $this->router->get('/category/{slug}', "MainController@category");//---gets all posts in a specific category
        $this->router->get('/categories', "MainController@categories");//---gets all of the categories
        $this->router->set404("MainController@notFound");
    }

    public function Run()
    {
        $this->router->run();
    }
}

?>