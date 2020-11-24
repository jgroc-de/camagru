<?php

declare(strict_types=1);

namespace App\Library;

use App\Model\PicturesManager;
use Cloudinary\Uploader;
use Dumb\Response;

class Image
{
    const WIDTH = 400;
    const HEIGHT = 300;

    /** @var array|false */
    private $imageSize;

    /** @var false|resource */
    private $image;

    /** @var string */
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

    public function add(object $filter): void
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

    public function save(PicturesManager $picturesManager): ?array
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
        if (!empty($_ENV['CLOUDINARY_URL'])) {
            \Cloudinary::config_from_url($_ENV['CLOUDINARY_URL']);
            $response = Uploader::upload($this->fileName);
            $this->fileName = $response['secure_url'];
        }

        return $picturesManager->addPic($this->fileName);
    }

    private function setFileName(): void
    {
        $user = $_SESSION['user'];
        $this->fileName = 'public/img/pics/'.$user['pseudo'].'_'.rand().'.'.$_POST['type'];
    }

    private function createPicsDir(): void
    {
        $path = __DIR__.'/../../public/img/pics';
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    private function resize(): void
    {
        if (self::WIDTH != $this->imageSize[0] || self::HEIGHT != $this->imageSize[1]) {
            $this->image = $this->resampled();
            if (empty($this->image)) {
                throw new \Exception('cant resize image', Response::INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @throws \Exception
     *
     * @return resource
     */
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
