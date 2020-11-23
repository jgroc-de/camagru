<?php

namespace App\Model;

use Dumb\Response;
use Exception;
use PDO;

class PicturesManager extends SqlManager
{
    public function getPic(int $id): ?array
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

    public function getPicsByDate(int $start): ?array
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url
            FROM img
            INNER JOIN users
            ON img.author_id = users.id
			ORDER BY img.id DESC
			LIMIT 8 OFFSET :start
		');
        $request->bindParam(':start', $start, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPicsByLike(int $start): ?array
    {
        $request = $this->db->prepare('
			SELECT img.id, img.title, img.url, (select COUNT(id) from likes where img.id = likes.img_id) AS likes
            FROM img
            INNER JOIN users
            ON img.author_id = users.id
			ORDER BY likes DESC
			LIMIT 8 OFFSET :start
		');
        $request->bindParam(':start', $start, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPicsByUser(string $pseudo): ?array
    {
        $request = '
			SELECT *
            FROM img
            WHERE author_id = ?
		';
        $request = $this->sqlRequest($request, [$pseudo]);

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPicByUrl(string $url): ?array
    {
        $request = '
            SELECT id, author_id
            FROM img
            WHERE url = ?
        ';

        return $this->sqlRequestFetch($request, [$url]);
    }

    public function addPic(string $path): ?array
    {
        $request = '
			INSERT INTO img
			(title, author_id, url, date)
			VALUES (?, ?, ?, NOW())
		';
        $out = $this->sqlRequest($request, [$_SESSION['user']['pseudo'].'_'.rand(), $_SESSION['id'], $path], true);
        $id = (int) $this->db->lastInsertId();
        if (0 === $out) {
            throw new Exception('Addition failed', Response::NOT_FOUND);
        }

        return $this->getPic($id);
    }

    public function deletePic(int $img_id, int $author_id): void
    {
        $request = '
            DELETE FROM img
            WHERE id = ? AND author_id = ?
        ';
        $out = $this->sqlRequest($request, [$img_id, $author_id], true);
        if (0 === $out) {
            throw new Exception('Delete failed', Response::NOT_FOUND);
        }
    }

    public function countPics(): int
    {
        $request = '
			SELECT COUNT(*) as count
			FROM img
		';

        $count = $this->sqlRequestFetch($request);

        return $count['count'] ?? 0;
    }

    public function picInDb(int $id): bool
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

    public function changeTitle(int $id, string $title): void
    {
        $request = '
            UPDATE img
            SET title = ?
            WHERE id = ?
            AND author_id = ?
        ';
        $out = $this->sqlRequest($request, [$title, $id, $_SESSION['id']], true);
        if (0 === $out) {
            throw new Exception('Update failed', Response::NOT_FOUND);
        }
    }
}
