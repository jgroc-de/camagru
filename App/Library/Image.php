<?php

declare(strict_types=1);

namespace App\Library;

use Cloudinary\Uploader;
use Dumb\Response;

class Image
{
    const WIDTH = 400;
    const HEIGHT = 300;

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

    public function add($filter)
    {
        $tmp = $filter->url;
        $s_size = getimagesize($tmp);
        if (!($src = imagecreatefrompng($tmp))) {
            throw new \Exception('filter loading error', Response::INTERNAL_SERVER_ERROR);
        }
        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);
        if (!imagecopyresized(
            $this->image,
            $src,
            (int) $filter->x,
            (int) $filter->y,
            0,
            0,
            (int) $filter->width,
            (int) floor((int) $filter->width * $s_size[1] / $s_size[0]),
            $s_size[0],
            $s_size[1]
        )) {
            throw new \Exception('filter addition error', Response::INTERNAL_SERVER_ERROR);
        }
        imagedestroy($src);
    }

    public function save($pictureManager)
    {
        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);
        switch ($_POST['type']) {
                    case 'png':
                imagepng($this->image, $this->fileName);

                        break;
                    case 'gif':
                imagegif($this->image, $this->fileName);

                        break;
                    case 'jpeg':
                imagejpeg($this->image, $this->fileName);

                        break;
                    case 'bmp':
                imagebmp($this->image, $this->fileName);

                        break;
                }
        imagedestroy($this->image);
        if ($_ENV['CLOUDINARY_URL']) {
             $response = Uploader::upload($this->fileName);
             var_dump($response);
             $this->fileName = $response['secure_url'];
        }

        return $pictureManager->addPic($this->fileName);
    }

    private function setFileName()
    {
        $user = $_SESSION['user'];
        $this->fileName = 'public/img/pics/'.$user['pseudo'].'_'.rand().'.'.$_POST['type'];
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
        if (self::WIDTH - $this->imageSize[0] < self::HEIGHT - $this->imageSize[1]) {
            $width = self::WIDTH;
            $height = (int) (self::WIDTH * $this->imageSize[1] / $this->imageSize[0]);
        } else {
            $width = (int) (self::HEIGHT * $this->imageSize[0] / $this->imageSize[1]);
            $height = self::HEIGHT;
        }
        imagecopyresampled($image, $this->image, (int) ((self::WIDTH - $width) / 2), (int) ((self::HEIGHT - $height) / 2), 0, 0, $width, $height, (int) $this->imageSize[0], (int) $this->imageSize[1]);
        $this->imageSize[0] = self::WIDTH;
        $this->imageSize[1] = self::HEIGHT;

        return $image;
    }
}
