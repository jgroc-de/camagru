<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class createPic extends Patronus
{
    public function trap(Dumbee $c)
    {
        if (isset($_POST['data']) && $this->isPng($_POST['data']))
        {
        }
        $dest = $this->decodeUrl($_POST['data']);
        $filter = $c->camagru->getFilters();
        $url = $this->parsePost($_POST, $filter);

        $name = $this->createName($_SESSION['id']);
        $d_size = getimagesizefromstring(base64_decode($dest));
        $dest = imagecreatefromstring(base64_decode($dest));
        if (640 != $d_size[0] || 480 != $d_size[1])
        {
            $dest = $this->resampled($dest, $d_size);
            $d_size[0] = 640;
            $d_size[1] = 480;
        }
        foreach ($url as $value)
        {
            $src = $value['url'];
            $s_size = getimagesize($src);
            $src = imagecreatefrompng($src);
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
        $c->picture->addPic($name);
        $this->response['path'] = $name;
        if (1)
        {
        }
        else
        {
            $this->response['code'] = 500;
            $_SESSION['flash'] = 'plus de place';
        }
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
     * @param mixed $size
     */
    public function resampled($src, $size)
    {
        $dest = imagecreatetruecolor(640, 480);
        if ($size[0] > $size[1])
        {
            $width = 640;
            $height = 640 * $size[1] / $size[0];
        }
        else
        {
            $width = 480 * $size[0] / $size[1];
            $height = 480;
        }
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

        return $dest;
    }

    /**
     * isPng.
     *
     * @param mixed $data
     */
    public function isPng($data)
    {
        if (0 === strpos($data, 'data:image/png;base64,'))
        {
            return true;
        }

        return false;
    }

    /**
     * decodeUrl.
     *
     * @param mixed $imgEncode
     */
    public function decodeUrl($imgEncode)
    {
        $remove = [' ', 'data:image/png;base64,'];
        $replace = ['+', ''];

        return str_replace($remove, $replace, $imgEncode);
    }

    /**
     * parsePost.
     *
     * @param mixed $post
     * @param mixed $filter
     */
    public function parsePost($post, $filter)
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

    /**
     * createName.
     *
     * @param mixed $author
     */
    public function createName(string $author)
    {
        return 'img/pics/'.$author.'_'.rand().'.png';
    }
}
