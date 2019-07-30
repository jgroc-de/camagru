<?php

namespace App\Model;

use Dumb\Response;

class CommentManager extends SqlManager
{
    public function getComments(int $id)
    {
        $request = '
            SELECT comments.id, comments.content, comments.date, users.pseudo
            FROM comments 
            INNER JOIN users
            ON comments.author_id = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
            LIMIT 50
		';

        return $this->sqlRequest($request, [$id]);
    }

    public function getComment(int $id)
    {
        $request = '
            SELECT *
            FROM comments
			WHERE id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function getCommentByImgId(int $id)
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

    public function addComment()
    {
        $request = '
                INSERT INTO comments (img_id, author_id, date, content)
                Values (?, ?, NOW(), ?)
            ';
        $this->sqlRequest($request, [$_POST['id'], $_SESSION['id'], $_POST['comment']], true);
    }

    public function deleteComment($id)
    {
        $request = 'DELETE FROM comments WHERE id = ?';
        $out = $this->sqlRequest($request, [$id], true);
        if (0 === $out) {
            throw new \Exception('Delete failed', Response::NOT_FOUND);
        }
    }

    public function updateComment($id, $comment)
    {
        $request = '
                UPDATE comments
                SET date = NOW(), content = ?
                WHERE id = ?
            ';
        $out = $this->sqlRequest($request, [$comment, $id], true);
        if (0 === $out) {
            throw new \Exception('Update failed ', Response::NOT_FOUND);
        }
    }
}
