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
        $this->response['status'] = 'deleted';
    }

    public function post()
    {
        $this->response = $this->createPicture();
        $this->code = Response::CREATED;
    }

    private function createPicture()
    {
        $image = new Image();
        $filters = $this->getUserDefineFilters();
        foreach ($filters as $filter) {
            $image->add($filter);
        }

        return $image->save($this->pictureManager);
    }

    private function getOriginalFilters(): array
    {
        $filters = $this->container['filter']($this->container)->getFilters();
        $data = [];
        foreach ($filters as $filter) {
            $data[$filter['title']] = $filter['url'];
        }

        return $data;
    }

    private function getUserDefineFilters(): array
    {
        $filters = $_POST['filters'];
        $i = 0;
        $all = $this->getOriginalFilters();
        while ($filters[$i]) {
            if (!($filter = $all[$filters[$i]->title])) {
                throw new \Exception('filter', Response::NOT_FOUND);
            }
            $filters[$i]->url = $filter;
            ++$i;
        }

        return $filters;
    }
}
