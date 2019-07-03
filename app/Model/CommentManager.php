<?php

namespace App\Model;

class CommentManager extends SqlManager
{
    public function getComments(int $id)
    {
        $request = '
            SELECT content, date as date2, pseudo
            FROM comments 
            INNER JOIN users
            ON comments.author_id = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
		';

        return $this->sqlRequest($request, [$id]);
    }

    public function getCommentByImgId(int $id)
    {
        $request = '
            SELECT content, date as date2, pseudo
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
        $this->sqlRequest($request, [$id]);
    }

    public function updateComment($id, $comment)
    {
        $request = '
                UPDATE comments
                SET date = NOW(), content = ?
                WHERE id = ?
            ';
        $this->sqlRequest($request, [$comment, $id]);
    }
}
