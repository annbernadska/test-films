<?php

class Film
{
    public static function getNewsList()
    {
        $db = Db::getConnection();
        $result = $db->query("select * from films order by title asc");

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
        $result->bindParam(':title', $fields['title']);
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
        $result->bindParam(':title', $fields['title']);
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
                $film['acrotsId'][] = Actors::getImportId($actor);
            }
        }
        unset($film);
        foreach ($filmsArray as $film) {
            $filmId = self::store($film);
            Actors::addActorsToFilm($filmId, $film['acrotsId']);
        }
    }

    public static function search($title)
    {
        return Db::getConnection()->query("select * from films where title like '%$title%'")->fetchAll();
    }
}
