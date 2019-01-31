<?php

class PicManager extends SqlManager
{
    /**
     * getPic.
     *
     * @param mixed $id
     */
    public function getPic(int $id)
    {
        $request = '
			SELECT img.id, img.title, img.url, img.date as date2, img.nb_like, users.pseudo
			FROM img
            INNER JOIN users
            ON img.id_author = users.id
			WHERE img.id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    /**
     * getPics.
     *
     * @param int $start
     */
    public function getPics(int $start)
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url as path
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			ORDER BY img.id DESC
			LIMIT 4 OFFSET :start
		');
        $request->bindParam(':start', $start, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    }

    /**
     * getPicsByLike.
     *
     * @param int $start
     */
    public function getPicsByLike(int $start)
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url as path
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			ORDER BY img.nb_like DESC
			LIMIT 4 OFFSET :start
		');
        $request->bindParam(':start', $start, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    }

    /**
     * getPicsByLogin.
     *
     * @param mixed $pseudo
     */
    public function getPicsByLogin(string $pseudo)
    {
        $tab = [];

        $request = '
			SELECT url, title
            FROM img
            WHERE id_author = ?
			ORDER BY id DESC
		';
        $value = $this->sqlRequest($request, [$pseudo]);
        while ($elemt = $value->fetch())
        {
            $tab[] = $elemt;
        }

        return $tab;
    }

    /**
     * getPicByUrl.
     *
     * @param mixed $url
     */
    public function getPicByUrl(string $url)
    {
        $request = '
            SELECT id, id_author
            FROM img
            WHERE url = ?
        ';

        return $this->sqlRequestFetch($request, [$url]);
    }

    /**
     * addPic.
     *
     * @param mixed $path
     */
    public function addPic(string $path)
    {
        $request = '
			INSERT INTO img
			(title, id_author, url, date)
			VALUES (?, ?, ?, NOW())
		';
        $this->sqlRequest($request, [$_SESSION['pseudo'].'_'.rand(), $_SESSION['id'], $path], true);
    }

    /**
     * deletePic.
     *
     * @param mixed $img_id
     * @param mixed $author_id
     */
    public function deletePic(int $img_id, int $author_id)
    {
        $request = '
            DELETE FROM img
            WHERE id = ? AND id_author = ?
        ';
        if ($this->sqlRequest($request, [$img_id, $author_id], true))
        {
            $request = '
            DELETE FROM comments
            WHERE img_id = ?
            ';
            $this->sqlRequest($request, [$img_id], true);
        }
    }

    /**
     * countPics.
     */
    public function countPics()
    {
        $request = '
			SELECT count(*)
			FROM img
		';

        return $this->sqlRequestFetch($request);
    }

    /**
     * picInDb.
     *
     * @param mixed $id
     *
     * @return bool
     */
    public function picInDb(int $id)
    {
        $request = '
			SELECT *
			FROM img
			WHERE id = ?
		';
        $value = $this->sqlRequest($request, [$id]);
        if ($value->fetch())
        {
            $value->closecursor();

            return true;
        }

        return false;
    }

    /**
     * addLike.
     *
     * @param mixed $id_img
     */
    public function addLike(int $id_img)
    {
        $id_author = $_SESSION['id'];
        $request = '
            SELECT id
            FROM likes
            WHERE id_img = ? AND id_author = ?
        ';
        $id = $this->sqlRequestFetch($request, [$id_img, $id_author]);
        if (!isset($id['id']))
        {
            $request = '
                UPDATE img 
                SET nb_like = nb_like + 1 
                WHERE id = ?
                ';
            $this->sqlRequest($request, [$id_img], true);
            $request = '
                INSERT INTO likes
                (id_img, id_author)
                VALUES (?, ?)
                ';
            $this->sqlRequest($request, [$id_img, $id_author], true);
        }
        else
        {
            return -1;
        }
        $request = '
			SELECT nb_like 
			FROM img 
			WHERE id = ?
		';
        $count = $this->sqlRequestFetch($request, [$id_img]);

        return $count[0];
    }

    /**
     * changeTitle.
     *
     * @param mixed $id
     * @param mixed $title
     *
     * @return string
     */
    public function changeTitle(int $id, strnig $title)
    {
        $request = '
            UPDATE img
            SET title = ?
            WHERE id = ?
            AND id_author = ?
        ';
        $this->sqlRequest($request, [$title, $id, $_SESSION['id']], true);
        $request = '
			SELECT title 
			FROM img 
			WHERE id = ?
		';
        $title = $this->sqlRequestFetch($request, [$id]);

        return $title['title'];
    }
}
