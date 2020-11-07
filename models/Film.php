<?php

class Film
{
    const POST_ON_PAGE = 10;

    public static function getNewsList($page = 1)
    {
        $offset = ($page - 1) * self::POST_ON_PAGE;
        $limit = self::POST_ON_PAGE;

        $db = Db::getConnection();
        $result = $db->query("select * from films order by title asc limit $limit offset $offset");

        for ($i = 0; $row = $result->fetch(); $i++) {
            $newsList[$i]['id'] = $row ['id'];
            $newsList[$i]['title'] = $row ['title'];
            $newsList[$i]['release_date'] = $row ['release_date'];
            $newsList[$i]['format'] = $row ['format'];
        }

        return ($newsList) ?? [];
    }

    public static function findById($id)
    {
        return Db::getConnection()->query("select * from films where id = $id")->fetch();
    }

    public static function updateById($id, $fields)
    {
        $db = Db::getConnection();
        $sql = "update films set title = :title, release_date = :release_date, format = :format where id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':title', strip_tags($fields['title']));
        $result->bindParam(':release_date', $fields['release_date']);
        $result->bindParam(':format', $fields['format']);
        $result->bindParam(':id', $id);

        return $result->execute();
    }

    public static function store($fields)
    {
        $db = Db::getConnection();
        $sql = "insert into films (title, release_date, format) values (:title, :release_date, :format)";
        $result = $db->prepare($sql);
        $result->bindParam(':title', strip_tags($fields['title']));
        $result->bindParam(':release_date', $fields['release_date']);
        $result->bindParam(':format', $fields['format']);
        $result->execute();

        return $db->lastInsertId();
    }

    public static function deleteById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM films WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);

        return $result->execute();
    }

    public static function importFilms($filmsArray)
    {
        foreach ($filmsArray as &$film) {
            foreach ($film['stars'] as $actor) {
                $film['actors'][] = Actors::getImportId($actor);
            }
        }
        unset($film);
        foreach ($filmsArray as $film) {
            if (!self::exist($film)) {
                $filmId = self::store($film);
                Actors::addActorsToFilm($filmId, $film['actors']);
            }
        }
    }

    public static function search($title)
    {
        return Db::getConnection()->query("select * from films where title like '%$title%'")->fetchAll();
    }

    public static function getTotalFilms()
    {
        $query = Db::getConnection()->query("select count(id) as total from films")->fetch();
        return $query['total'];
    }

    public static function exist($data)
    {
        $query = Db::getConnection()->query("select actor_id from films inner join actor_film on 
                    films.id = actor_film.film_id where title = '" . strip_tags($data['title']) . "'
                    and release_date = '" . $data['release_date'] . "' and format = '" . $data['format'] . "'");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();


        if (empty($result)) {
            return false;
        }

        $actorsId = array_column($result, 'actor_id');
        if (count($actorsId) != count($data['actors'])) {
            return false;
        }

        $diff = array_diff($actorsId, $data['actors']);

        if (!empty($diff)) {
            return false;
        }
        return true;
    }
}
