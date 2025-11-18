<?php 

namespace Jemer\TinyCms\Loaders;

use Jemer\TinyCms\Helpers\PathHelper;
use Mni\FrontYAML\Parser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\VarDumper\VarDumper;

class PostLoader
{
    protected string $postDir;

    public function __construct()
    {
        $this->postDir = PathHelper::BuildPath([
            CONTENT_DIR, 
            ConfigLoader::Get("content.posts_dir")
        ]);
    }

    public function GetPost(string $slug) : object
    {
        $path = PathHelper::BuildPath([
            $this->postDir,
            $slug . ".md"
        ]);

        return $this->LoadFile($path);
    }

    public function GetPostsByCat(string $cat)
    {
        $posts = [];

        $finder = new Finder();
        $finder->files()->in($this->postDir);

        foreach ($finder as $file) {
           
            $fileNameWithExtension = $file->getRelativePathname();
            
            $path = PathHelper::BuildPath([
                $this->postDir,
                $fileNameWithExtension
            ]);
            
            $post = $this->LoadFile($path);

            if(isset($post->category) && $post->category == $cat)
            {
                $posts[] = [
                    "slug" => $post->slug,
                    "title" => $post->title
                ];
            }
        }

        return $posts;
    }

    public function GetAllCategories(): array
    {
        $categories = [];
        $finder = new Finder();
        $finder->files()->in($this->postDir);

        foreach ($finder as $file) {
            $path = PathHelper::BuildPath([$this->postDir, $file->getRelativePathname()]);
            $post = $this->LoadFile($path);

            if (isset($post->category) && !empty($post->category)) {
                $categories[] = $post->category;
            }
        }

        // Return unique categories sorted alphabetically
        return array_unique($categories);
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
}

?>