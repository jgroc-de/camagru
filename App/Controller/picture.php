<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Image;
use App\Model\FilterManager;
use App\Model\PicturesManager;
use Dumb\Dumb;
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

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->pictureManager = Dumb::$container['picture'](Dumb::$container);
        $this->filterManager = Dumb::$container['filter'](Dumb::$container);
    }

    public function get(): void
    {
        $id = $_GET['id'];
        $this->picture = $this->pictureManager->getPic($id);
        if (empty($this->picture)) {
            throw new \Exception('picture', Response::NOT_FOUND);
        }
        $this->response = $this->picture;
    }

    public function patch(): void
    {
        $id = $_GET['id'];
        $this->pictureManager->changeTitle($id, $_POST['title']);
        $this->response['title'] = $_POST['title'];
    }

    public function delete(): void
    {
        $id = $_GET['id'];
        $this->response['id'] = $id;
        $this->picture = $this->pictureManager->getPic($id);
        $this->pictureManager->deletePic($id, (int) $_SESSION['id']);
        unlink($this->picture['url']);
        $this->response['flash'] = 'Picture successfully deleted!';
        $this->response['status'] = 'deleted';
    }

    public function post(): void
    {
        $this->response = $this->createPicture();
        $this->code = Response::CREATED;
    }

    private function createPicture(): ?array
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

    private function getUserDefineFilters(): ?array
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
