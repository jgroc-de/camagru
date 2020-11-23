<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Image;
use App\Model\FilterManager;
use App\Model\PicturesManager;
use Dumb\Patronus;
use Dumb\Response;

/**
 * picture.
 */
class picture extends Patronus
{
    /** @var array */
    private $picture;

    /** @var PicturesManager */
    private $pictureManager;
    /** @var FilterManager */
    private $filterManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->pictureManager = $container['picture']($container);
        $this->filterManager = $container['filter']($container);
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
        $filters = $this->filterManager->getFilters();
        $data = [];
        foreach ($filters as $filter) {
            $data[$filter['title']] = $filter['url'];
        }

        return $data;
    }

    private function getUserDefineFilters()
    {
        $filters = $_POST['filters'];
        $i = 0;
        $all = $this->getOriginalFilters();
        while (isset($filters[$i])) {
            $filter = $all[$filters[$i]->title];
            if (!$filter) {
                throw new \Exception('filter', Response::NOT_FOUND);
            }
            $filters[$i]->url = $filter;
            ++$i;
        }

        return $filters;
    }
}
