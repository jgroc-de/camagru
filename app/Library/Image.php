<?php

declare(strict_types=1);

namespace App\Library;

use Dumb\Response;

class Image
{
    const WIDTH = 640;
    const HEIGHT = 480;

    private $imageSize;

    private $image;

    private $fileName;

    public function __construct()
    {
        $this->createPicsDir();
        $this->imageSize = getimagesizefromstring($_POST['picture']);
        $this->image = imagecreatefromstring($_POST['picture']);
        if (!$this->image) {
            throw new \Exception('cant create image', Response::INTERNAL_SERVER_ERROR);
        }
        $this->resize();
        $this->setFileName();
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function add($filter)
    {
        $tmp = $filter['url'];
        $s_size = getimagesize($tmp);
        if (!($src = imagecreatefrompng($tmp))) {
            throw new \Exception('filter loading error', Response::INTERNAL_SERVER_ERROR);
        }
        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);
        if (!imagecopyresized(
            $this->image,
            $src,
            (int) $filter['x'],
            (int) $filter['y'],
            0,
            0,
            $this->imageSize[0],
            (int) floor($this->imageSize[0] * $s_size[1] / $s_size[0]),
            $s_size[0],
            $s_size[1]
        )) {
            throw new \Exception('filter addition error', Response::INTERNAL_SERVER_ERROR);
        }
        imagedestroy($src);
    }

    public function save()
    {
        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);
        imagepng($this->image, $this->fileName);
        imagedestroy($this->image);
    }

    private function setFileName()
    {
        $user = $_SESSION['user'];
        $this->fileName = 'img/pics/'.$user['pseudo'].'_'.rand().'.png';
    }

    private function createPicsDir()
    {
        $path = __DIR__.'/../../public/img/pics';
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    private function resize()
    {
        if (self::WIDTH != $this->imageSize[0] || self::HEIGHT != $this->imageSize[1]) {
            $this->image = $this->resampled();
            if (!$this->image) {
                throw new \Exception('cant resize image', Response::INTERNAL_SERVER_ERROR);
            }
        }
    }

    private function resampled()
    {
        $image = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        if (!$image) {
            throw new \Exception('cant create image layer', Response::INTERNAL_SERVER_ERROR);
        }
        if ($this->imageSize[0] > $this->imageSize[1]) {
            $width = 640;
            $height = (int) (640 * $this->imageSize[1] / $this->imageSize[0]);
        } else {
            $width = (int) (480 * $this->imageSize[0] / $this->imageSize[1]);
            $height = 480;
        }
        imagecopyresampled($image, $this->image, 0, 0, 0, 0, $width, $height, (int) $this->imageSize[0], (int) $this->imageSize[1]);
        $this->imageSize[0] = self::WIDTH;
        $this->imageSize[1] = self::HEIGHT;

        return $image;
    }
}
