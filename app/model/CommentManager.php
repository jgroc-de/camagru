<?php

class CommentManager extends SqlManager
{
    public function getComments($id)
    {
		$request = '
            SELECT content, date as date2, pseudo
            FROM comments 
            INNER JOIN users
            ON comments.id_author = users.id
			WHERE img_id = ?
			ORDER BY comments.id DESC
		';
		return ($this->sqlRequest($request, array($id)));
	}
	
    public function getCommentByImgId($id)
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
		return $this->sqlRequestFetch($request, array($id));
	}

    public function addComment()
    {
        $request = '
                INSERT INTO comments (img_id, id_author, date, content)
                Values (?, ?, NOW(), ?)
            ';
        $this->sqlRequest($request, array($_POST['id'], $_SESSION['id'], $_POST['text']), True);
    }
}
