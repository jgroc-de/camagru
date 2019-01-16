<?php

class PicManager extends SqlManager
{
	public function getPic($id)
	{
		$request = '
			SELECT img.id, img.title, img.url, img.date as date2, img.nb_like, users.pseudo
			FROM img
            INNER JOIN users
            ON img.id_author = users.id
			WHERE img.id = ?
		';
		return $this->sqlRequestFetch($request, array($id));
	}

	public function getPics($start)
	{
		$request = $this->db->prepare('
			SELECT img.id, img.title, img.url, img.date AS date2, users.pseudo
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			ORDER BY img.id DESC
			LIMIT 6 OFFSET :start
		');
		$request->bindParam(':start', $start, PDO::PARAM_INT);
		$request->execute();
		return $request;
	}
	
	public function getPicsByLike($start)
	{
		$request = $this->db->prepare('
			SELECT img.id, img.title, img.url, img.date AS date2, users.pseudo
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			ORDER BY img.nb_like DESC
			LIMIT 6 OFFSET :start
		');
		$request->bindParam(':start', $start, PDO::PARAM_INT);
		$request->execute();	
		return $request;
	}
	
	public function getPicsByLogin($pseudo)
	{
		$tab = array();

		$request = '
			SELECT url, title
            FROM img
            WHERE id_author = ?
			ORDER BY id
		';
		$value = $this->sqlRequest($request, array($pseudo));
		while ($elemt = $value->fetch()) {
			$tab[] = $elemt;
		}
		return $tab;
    }

    public function getPicByUrl($url)
    {
        $request = '
            SELECT id, id_author
            FROM img
            WHERE url = ?
        ';
        return $this->sqlRequestFetch($request, array($url));
    }

	public function addPic($path)
	{
		$request = '
			INSERT INTO img
			(title, id_author, url, date)
			VALUES (?, ?, ?, NOW())
		';
		$this->sqlRequest($request, array($_SESSION['pseudo'] . '_' . rand(), $_SESSION['id'], $path), True);
    }

    public function deletePic($img_id, $author_id)
    {
        $request = '
            DELETE FROM img
            WHERE id = ? AND id_author = ?
        ';
        if ($this->sqlRequest($request, array($img_id, $author_id), True))
        {
            $request = '
            DELETE FROM comments
            WHERE img_id = ?
            ';
            $this->sqlRequest($request, array($id), True);
        }
    }
	
	public function countPics()
	{
		$request = '
			SELECT count(*)
			FROM img
		';
		return $this->sqlRequestFetch($request);
	}
	
	public function picInDb($id)
	{
		$request = '
			SELECT *
			FROM img
			WHERE id = ?
		';
		$value = $this->sqlRequest($request, array($id));
		if ($value->fetch()) {
			$value->closecursor();
			return true;
		}
		return false;
	}

	public function addLike($id_img)
    {
        $id_author = $_SESSION['id'];
        $request = '
            SELECT id
            FROM likes
            WHERE id_img = ? AND id_author = ?
        ';
        $id = $this->sqlRequestFetch($request, array($id_img, $id_author));
        if (!isset($id['id']))
        {
            $request = '
                UPDATE img 
                SET nb_like = nb_like + 1 
                WHERE id = ?
                ';
            $this->sqlRequest($request, array($id_img), True);
            $request = '
                INSERT INTO likes
                (id_img, id_author)
                VALUES (?, ?)
                ';
            $this->sqlRequest($request, array($id_img, $id_author), True);
        }
		$request = '
			SELECT nb_like 
			FROM img 
			WHERE id = ?
		';
		$count = $this->sqlRequestFetch($request, array($id_img));
		return($count[0]);
    }

    public function changeTitle($id, $title)
    {
        $request = '
            UPDATE img
            SET title = ?
            WHERE id = ?
            AND id_author = ?
        ';
        $this->sqlRequest($request, array($title, $id, $_SESSION['id']), True);
		$request = '
			SELECT title 
			FROM img 
			WHERE id = ?
		';
		$title = $this->sqlRequestFetch($request, array($id));
        return($title['title']);
    }
}
