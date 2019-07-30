<?php

namespace App\Model;

use Dumb\Response;

class PicturesManager extends SqlManager
{
    public function getPic(int $id)
    {
        $request = '
			SELECT img.id, img.title, img.url, img.date, img.author_id, users.pseudo
			FROM img
            INNER JOIN users
            ON img.author_id = users.id
			WHERE img.id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function getPicsByDate(int $start)
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url
            FROM img
            INNER JOIN users
            ON img.author_id = users.id
			ORDER BY img.id DESC
			LIMIT 8 OFFSET :start
		');
        $request->bindParam(':start', $start, \PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    }

    public function getPicsByLike(int $start)
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url, (select COUNT(id) from likes where img.id = likes.img_id) AS likes
            FROM img
            INNER JOIN users
            ON img.author_id = users.id
			ORDER BY likes DESC
			LIMIT 8 OFFSET :start
		');
        $request->bindParam(':start', $start, \PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    }

    public function getPicsByUser(string $pseudo)
    {
        $tab = [];

        $request = '
			SELECT url, title
            FROM img
            WHERE author_id = ?
			ORDER BY id DESC
		';
        $value = $this->sqlRequest($request, [$pseudo]);
        while ($elemt = $value->fetch()) {
            $tab[] = $elemt;
        }

        return $tab;
    }

    public function getPicByUrl(string $url)
    {
        $request = '
            SELECT id, author_id
            FROM img
            WHERE url = ?
        ';

        return $this->sqlRequestFetch($request, [$url]);
    }

    public function addPic(string $path)
    {
        $request = '
			INSERT INTO img
			(title, author_id, url, date)
			VALUES (?, ?, ?, NOW())
		';
        $this->sqlRequest($request, [$_SESSION['user']['pseudo'].'_'.rand(), $_SESSION['id'], $path], true);
    }

    public function deletePic(int $img_id, int $author_id)
    {
        $request = '
            DELETE FROM img
            WHERE id = ? AND author_id = ?
        ';
        $out = $this->sqlRequest($request, [$img_id, $author_id], true);
        if (0 === $out) {
            throw new \Exception('Delete failed', Response::NOT_FOUND);
        }
    }

    public function countPics()
    {
        $request = '
			SELECT COUNT(*)
			FROM img
		';

        return $this->sqlRequestFetch($request);
    }

    public function picInDb(int $id)
    {
        $request = '
			SELECT *
			FROM img
			WHERE id = ?
		';
        $value = $this->sqlRequest($request, [$id]);
        if ($value->fetch()) {
            $value->closecursor();

            return true;
        }

        return false;
    }

    public function changeTitle(int $id, string $title)
    {
        $request = '
            UPDATE img
            SET title = ?
            WHERE id = ?
            AND author_id = ?
        ';
        $out = $this->sqlRequest($request, [$title, $id, $_SESSION['id']], true);
        if (0 === $out) {
            throw new \Exception('Update failed', Response::NOT_FOUND);
        }
    }
}
