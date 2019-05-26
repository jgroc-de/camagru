<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * picture.
 * provide view to comments and pictures
 */
class picture extends Patronus
{
    private $elem;

    private $comments;

    public function get()
    {
        $id = $_GET['id'];

        $this->elem = $this->container['picture']($this->container)->getPic($id);
        if (empty($this->elem))
        {
            $this->code = 404;
        }
        else
        {
            $this->comments = $this->container['comment']($this->container)->getComments($id)->fetchAll();
        }
    }

    public function patch()
    {
        $this->response = $this->container['picture']($this->container)->changeTitle($_POST['id'], $_POST['title']);
    }

    public function delete()
    {
        $this->response['url'] = $_POST['url'];
        $this->container['picture']($this->container)->deletePic($_POST['id'], (int)$_SESSION['id']);
        unlink($_POST['url']);
        $this->response['flash'] = 'Picture successfully deleted!';
    }

    public function bomb_a_sup(array $options)
    {
        $id = $_GET['id'];
        $elem = $this->elem;
        $this->containeromments = $this->comments;
        array_shift($options['header']);
        $options['title2'] = htmlspecialchars($elem['title']);
        $view = 'Picture';
        $main = '/picView.html';
        $options['components'] = [];

        require __DIR__.'/../../View/template.html';
    }

    public function post()
    {
        $filter = $this->container['camagru']($this->container)->getFilters();
        $url = $this->parsePost($_POST, $filter);
        $name = 'img/pics/'.$_SESSION['pseudo'].'_'.rand().'.png';

        $d_size = getimagesizefromstring($_POST['data']);
        $dest = imagecreatefromstring($_POST['data']);
        if (!$dest)
        {
            $this->code = 500;

            return;
        }
        if (640 != $d_size[0] || 480 != $d_size[1])
        {
            if (!($dest = $this->resampled($dest, $d_size)))
            {
                return;
            }
        }
        foreach ($url as $value)
        {
            $src = $value['url'];
            $s_size = getimagesize($src);
            if (!($src = imagecreatefrompng($src)))
            {
                $this->code = 500;

                return;
            }
            imagealphablending($dest, true);
            imagesavealpha($dest, true);
            imagecopyresized(
                $dest,
                $src,
                $value['x'],
                $value['y'],
                0,
                0,
                $d_size[0],
                $d_size[0] * $s_size[1] / $s_size[0],
                $s_size[0],
                $s_size[1]
            );
            imagedestroy($src);
        }
        imagealphablending($dest, true);
        imagesavealpha($dest, true);
        imagepng($dest, $name);
        imagedestroy($dest);
        $this->container['picture']($this->container)->addPic($name);
        $this->response['path'] = $name;
        if (isset($_SESSION['flash']))
        {
            $this->response['flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
    }

    /**
     * resampled.
     *
     * @param mixed $src
     * @param mixed $d_size
     */
    private function resampled($src, &$d_size)
    {
        $dest = imagecreatetruecolor(640, 480);
        if (!$dest)
        {
            $this->code = 500;

            return false;
        }
        if ($d_size[0] > $d_size[1])
        {
            $width = 640;
            $height = (int) (640 * $d_size[1] / $d_size[0]);
        }
        else
        {
            $width = (int) (480 * $d_size[0] / $d_size[1]);
            $height = 480;
        }
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, (int) $d_size[0], (int) $d_size[1]);
        $d_size[0] = 640;
        $d_size[1] = 480;

        return $dest;
    }

    /**
     * parsePost.
     *
     * @param mixed $post
     * @param mixed $filter
     */
    private function parsePost($post, $filter)
    {
        $title = [];
        $url = [];
        $i = 0;

        while (isset($post['title'.$i]))
        {
            $title[] = $post['title'.$i++];
        }
        foreach ($filter as $elemt)
        {
            if (in_array($elemt['title'], $title))
            {
                $url[] = $elemt;
            }
        }

        return $url;
    }
}
