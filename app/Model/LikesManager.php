<?php

namespace App\Model;

use Dumb\Response;

class LikesManager extends SqlManager
{
    public function getLike(int $img_id)
    {
        $request = '
            SELECT COUNT(id) as count
            FROM likes
            WHERE img_id = ?
        ';
        return $this->sqlRequestFetch($request, [$img_id]);
    }

    public function addLike(int $img_id)
    {
        $author_id = $_SESSION['id'];
        $request = '
            SELECT id
            FROM likes
            WHERE img_id = ? AND author_id = ?
        ';
        $out = $this->sqlRequestFetch($request, [$img_id, $author_id]);
        if (isset($out['id'])) {
            throw new \Exception('Already liked', Response::BAD_REQUEST);
        }
        $request = '
            INSERT INTO likes
            (img_id, author_id)
            VALUES (?, ?)
        ';
        $this->sqlRequest($request, [$img_id, $author_id], true);
    }

    public function deleteLike(int $img_id)
    {
        $author_id = $_SESSION['id'];
        $request = 'DELETE FROM likes WHERE img_id = ? AND author_id = ?';
        $out = $this->sqlRequest($request, [$img_id, $author_id], true);
        if (0 === $out) {
            throw new \Exception('Delete failed', Response::NOT_FOUND);
        }
    }
}
