<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Image;
use Dumb\Patronus;
use Dumb\Response;

/**
 * picture.
 */
class picture extends Patronus
{
    private $picture;

    private $comments;

    private $pictureManager;

    protected function setup()
    {
        $this->pictureManager = $this->container['picture']($this->container);
    }

    public function get()
    {
        $id = $_GET['id'];
        $this->picture = $this->pictureManager->getPic($id);
        if (empty($this->picture)) {
            throw new \Exception('picture', Response::NOT_FOUND);
        }
        $this->comments = $this->container['comment']($this->container)->getComments($id)->fetchAll();
    }

    public function patch()
    {
        $this->response = $this->pictureManager->changeTitle($_POST['id'], $_POST['title']);
    }

    public function delete()
    {
        $this->response['url'] = $_POST['url'];
        $this->pictureManager->deletePic($_POST['id'], (int) $_SESSION['id']);
        unlink($_POST['url']);
        $this->response['flash'] = 'Picture successfully deleted!';
    }

    public function post()
    {
        $image = new Image();
        $filters = $this->getUserDefineFilters();
        foreach ($filters as $filter) {
            $image->add($filter);
        }
        $image->save();
        $name = $image->getFileName();
        $this->pictureManager->addPic($name);
        $this->response['path'] = $name;
    }

    private function getUserDefineFilters(): array
    {
        $filters = $this->container['filter']($this->container)->getFilters();
        $titles = [];
        $urls = [];
        $i = 0;

        while (isset($_POST['title'.$i])) {
            $titles[] = $_POST['title'.$i++];
        }
        foreach ($filters as $filter) {
            if (in_array($filter['title'], $titles)) {
                $urls[] = $filter;
            }
        }

        return $urls;
    }
}
