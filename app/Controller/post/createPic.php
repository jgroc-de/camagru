<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class createPic extends Patronus
{
    public function trap(Dumbee $c)
    {
        $filter = $c->camagru->getFilters();
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
        $c->picture->addPic($name);
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
    public function resampled($src, &$d_size)
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
}
