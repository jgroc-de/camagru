<?php

class CommentManager extends SqlManager
{
    /**
     * getComments.
     *
     * @param mixed $id
     */
    public function getComments(int $id)
    {
        $request = '
            SELECT content, date as date2, pseudo
            FROM comments 
            INNER JOIN users
            ON comments.id_author = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
		';

        return $this->sqlRequest($request, [$id]);
    }

    /**
     * getCommentByImgId.
     *
     * @param int $id
     */
    public function getCommentByImgId(int $id)
    {
        $request = '
            SELECT content, date as date2, pseudo
            FROM comments
            INNER JOIN users
            ON comments.id_author = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
			LIMIT 1
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    /**
     * addComment.
     */
    public function addComment()
    {
        $request = '
                INSERT INTO comments (img_id, id_author, date, content)
                Values (?, ?, NOW(), ?)
            ';
        $this->sqlRequest($request, [$_POST['id'], $_SESSION['id'], $_POST['comment']], true);
    }
}
