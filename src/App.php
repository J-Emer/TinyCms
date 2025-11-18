<?php 

namespace Jemer\TinyCms;

use Bramus\Router\Router;
use Jemer\TinyCms\Loaders\ConfigLoader;

class App
{
    private Router $router;

    public function __construct()
    {
        ConfigLoader::Load(ROOT . DIRECTORY_SEPARATOR . "config.yaml");

        $this->router = new Router();
        $this->LoadRoutes();
    }

    private function LoadRoutes()
    {
        $this->router->setNamespace('Jemer\TinyCms\Controllers');

        // $this->router->get('/', "MainController@index");
        $this->router->get('/page/{slug}', "MainController@page");
        $this->router->get('/post/{slug}', "MainController@post");
        $this->router->get('/category/{slug}', "MainController@category");//---gets all posts in a specific category
        $this->router->get('/categories', "MainController@categories");//---gets all of the categories

        // //---todo password protect the admin section

        // // Admin section
        // $this->router->get('/admin', "AdminController@login");
        // $this->router->post('/admin', "AdminController@login"); // handle POST login
        // $this->router->get('/admin/dashboard', "AdminController@dashboard");
        // $this->router->get('/admin/logout', "AdminController@logout");
        // $this->router->get('/admin/users', "AdminController@users"); // list users
        
        
        // $this->router->get('/admin/posts', "AdminController@posts"); // list posts
        // $this->router->get('/admin/posts/add', 'AdminController@addPost');
        // $this->router->post('/admin/posts/add', 'AdminController@addPost');






        // $this->router->get('/admin/pages', "AdminController@pages"); // list pages



    }

    public function Run()
    {
        $this->router->run();
    }
}

?>