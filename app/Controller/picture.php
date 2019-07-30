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
        $this->response = $this->picture;
    }

    public function patch()
    {
        $id = $_GET['id'];
        $this->pictureManager->changeTitle($id, $_POST['title']);
        $this->response['title'] = $_POST['title'];
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->response['id'] = $id;
        $this->picture = $this->pictureManager->getPic($id);
        $this->pictureManager->deletePic($id, (int) $_SESSION['id']);
        unlink($this->picture['url']);
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
        $this->code = Response::CREATED;
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
        if (count($titles) != count($urls)) {
            throw new \Exception('filters', Response::NOT_FOUND);
        }

        return $urls;
    }
}
