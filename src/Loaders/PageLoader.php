<?php 

namespace Jemer\TinyCms\Loaders;

use Jemer\TinyCms\Helpers\PathHelper;
use Mni\FrontYAML\Parser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\VarDumper\VarDumper;

class PageLoader
{
    protected string $pageDir;

    public function __construct()
    {
        $this->pageDir = PathHelper::BuildPath([
            CONTENT_DIR, 
            ConfigLoader::Get("content.pages_dir")
        ]);
    }

    public function GetPage(string $slug) : object
    {
        $path = PathHelper::BuildPath([
            $this->pageDir,
            $slug . ".md"
        ]);

        return $this->LoadFile($path);
    }

    private function LoadFile(string $path) : object
    {
        $fileContent = file_get_contents($path);

        $parser = new Parser();
        $document = $parser->parse($fileContent);
        $yaml = $document->getYAML();
        $html = $document->getContent();

        return (object)array_merge($yaml, ['content' => $html]);
    }

    public function GetNav() : array
    {
        $nav = [];

        $finder = new Finder();
        $finder->files()->in($this->pageDir);

        foreach ($finder as $file) {
           
            $fileNameWithExtension = $file->getRelativePathname();
            
            $path = PathHelper::BuildPath([
                $this->pageDir,
                $fileNameWithExtension
            ]);
            
            $page = $this->LoadFile($path);

            if($page->isnav)
            {
                $nav[] = [
                    "slug" => "page/" . $page->slug,
                    "title" => $page->title
                ];
            }
        }

        $nav[] = [
            "slug" => "categories",
            "title" => "Categories"
        ];

        return $nav;
    }
}

?>