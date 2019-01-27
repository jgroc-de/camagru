<?php

function createPic($c)
{
    if (isset($_POST['data']) && isPng($_POST['data'])) {
        $dest = decodeUrl($_POST['data']);
        $filter = $c->camagru->getFilters();
        $url = parsePost($_POST, $filter);

        $name = createName($_SESSION['id']);
        $d_size = getimagesizefromstring(base64_decode($dest));
        $dest = imagecreatefromstring(base64_decode($dest));
        if (640 != $d_size[0] || 480 != $d_size[1]) {
            $dest = resampled($dest, $d_size);
            $d_size[0] = 640;
            $d_size[1] = 480;
        }
        foreach ($url as $value) {
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
        $response['code'] = 200;
        $response['path'] = $name;
    } else {
        $response['code'] = 500;
        $_SESSION['flash'] = 'plus de place';
    }
    if (isset($_SESSION['flash'])) {
        $response['flash'] = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    return $response;
}

function resampled($src, $size)
{
    $dest = imagecreatetruecolor(640, 480);
    if ($size[0] > $size[1]) {
        $width = 640;
        $height = 640 * $size[1] / $size[0];
    } else {
        $width = 480 * $size[0] / $size[1];
        $height = 480;
    }
    imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

    return $dest;
}

function isPng($data)
{
    if (0 === strpos($data, 'data:image/png;base64,')) {
        return true;
    }

    return false;
}

function decodeUrl($imgEncode)
{
    $remove = array(' ', 'data:image/png;base64,');
    $replace = array('+', '');

    return str_replace($remove, $replace, $imgEncode);
}

function parsePost($post, $filter)
{
    $title = array();
    $url = array();
    $i = 0;

    while (isset($post['title'.$i])) {
        $title[] = $post['title'.$i++];
    }
    foreach ($filter as $elemt) {
        if (in_array($elemt['title'], $title)) {
            $url[] = $elemt;
        }
    }

    return $url;
}

function createName($author)
{
    return 'img/pics/'.$author.'_'.rand().'.png';
}
