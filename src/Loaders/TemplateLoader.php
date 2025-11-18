<?php 

namespace Jemer\TinyCms\Loaders;

use Jemer\TinyCms\Helpers\PathHelper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateLoader
{
    private $loader;
    private $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(PathHelper::BuildPath([
            ROOT,
            ConfigLoader::Get('theme.path')
        ]));

        $this->twig = new Environment($this->loader, [
            'cache' => false,       // disables caching
            'debug' => true,        // optional: enables debug functions like dump()
            'auto_reload' => true,  // optional: auto reload templates when modified
        ]);
    }

    public function Render(string $template, array $data)
    {
        echo $this->twig->Render($template, $data);
    }
}

?>