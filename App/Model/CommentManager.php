<?php

namespace App\Model;

use Dumb\Response;

class CommentManager extends SqlManager
{
    /**
     * @return bool|int|\PDOStatement
     */
    public function getComments(int $id)
    {
        $request = '
            SELECT comments.*, users.pseudo
            FROM comments 
            INNER JOIN users
            ON comments.author_id = users.id
			WHERE img_id = ?
		';

        return $this->sqlRequest($request, [$id]);
    }

    /**
     * @return bool|int|\PDOStatement
     */
    public function getLastComments(int $id)
    {
        $date = date('Y-m-d H:i:s', time() - 20);
        $request = '
            SELECT comments.*, users.pseudo
            FROM comments 
            INNER JOIN users
                ON comments.author_id = users.id
			WHERE img_id = ?
			    AND comments.date > ?
		';

        return $this->sqlRequest($request, [$id, $date]);
    }

    /**
     * @return mixed
     */
    public function getComment(int $id)
    {
        $request = '
            SELECT comments.*, users.pseudo
            FROM comments
            INNER JOIN users
            ON comments.author_id = users.id
			WHERE comments.id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function getCommentByImgId(int $id): ?array
    {
        $request = '
            SELECT comments.id, comments.content, comments.date, users.pseudo
            FROM comments
            INNER JOIN users
            ON comments.author_id = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
			LIMIT 1
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function addComment(int $id): ?array
    {
        $request = '
                INSERT INTO comments (img_id, author_id, date, content)
                Values (?, ?, NOW(), ?)
            ';
        $out = $this->sqlRequest($request, [$id, $_SESSION['id'], $_POST['comment']], true);
        $id = (int) $this->db->lastInsertId();
        if (0 === $out) {
            throw new \Exception('Addition failed', Response::NOT_FOUND);
        }

        return $this->getComment($id);
    }

    public function deleteComment(int $id): void
    {
        $request = 'DELETE FROM comments WHERE id = ?';
        $this->sqlRequest($request, [$id], true);
    }

    public function updateComment(int $id, string $comment): void
    {
        $request = '
                UPDATE comments
                SET content = ?, date = NOW()
                WHERE id = ?
            ';
        $out = $this->sqlRequest($request, [$comment, $id], true);
        if (0 === $out) {
            throw new \Exception('Update failed ', Response::NOT_FOUND);
        }
    }
}
