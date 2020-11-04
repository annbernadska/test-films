<?php

class Actors
{
    public static function getActorsByFilm($filmId)
    {
        $result = Db::getConnection()->query("select * from `actors` inner join actor_film on actors.id=actor_film.actor_id where film_id = $filmId");
        for ($i = 0; $row = $result->fetch(); $i++) {
            $actorsList[$i]['id'] = $row ['id'];
            $actorsList[$i]['name'] = $row ['name'];
        }

        return ($actorsList) ?? [];
    }

    public static function getAllActors()
    {
        $result = Db::getConnection()->query("select * from `actors` order by name");
        for ($i = 0; $row = $result->fetch(); $i++) {
            $actorsList[$i]['id'] = $row ['id'];
            $actorsList[$i]['name'] = $row ['name'];
        }

        return ($actorsList) ?? [];
    }

    public static function addActorsToFilm($filmId, $actorsIds)
    {
        $value = "";
        $actorsIds = self::syncActors($actorsIds);

        foreach ($actorsIds as $id) {
            $value .= "($id, $filmId),";
        }
        $value = substr($value, 0, -1);

        Db::getConnection()->query("insert into actor_film (actor_id, film_id) values $value");
    }

    public static function updateActorsFilm($filmId, $actorsIds)
    {
        $value = "";
        $actorsIds = self::syncActors($actorsIds);

        foreach ($actorsIds as $id) {
            $value .= "($id, $filmId),";
        }
        $value = substr($value, 0, -1);

        $query = Db::getConnection()->prepare("delete from actor_film where film_id = :filmId");
        $query->bindParam(':filmId', $filmId);
        $query->execute();

        Db::getConnection()->prepare("insert into actor_film (actor_id, film_id) values $value")->execute();
    }

    private static function syncActors($actorsIds)
    {
        $prepareStr = "'" . implode("','", $actorsIds) . "'";

        $query = Db::getConnection()->query("select id from `actors` where id in (" . $prepareStr . ")");
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $existActorsIds = array_column($query->fetchAll(), 'id');
        $newActors = array_diff($actorsIds, $existActorsIds);
        $newActorsIds = [];

        foreach ($newActors as $newActor) {
            $db = Db::getConnection();
            $db->query("insert into actors (name) values ('$newActor')");
            $newActorsIds[] = $db->lastInsertId();
        }
        return array_merge($existActorsIds, $newActorsIds);
    }

    public static function getImportId($name)
    {
        $actorId = Db::getConnection()->query("select id from `actors` where name like ('" . trim($name) . "')")->fetchColumn(0);
        if ($actorId) {
            return $actorId;
        }
        $db = Db::getConnection();
        $db->query("insert into actors (name) values ('" . trim($name) . "')");
        return $db->lastInsertId();
    }

    public static function search($name)
    {
        $results = Db::getConnection()->query("select actors.name, films.* from actors 
            inner join actor_film on actors.id = actor_film.actor_id
            inner join films on films.id = actor_film.film_id
            where actors.name like '%$name%'")->fetchAll();
        $actors = [];

        foreach ($results as $item) {
            $actors[$item['name']][] = $item;
        }

        return $actors;
    }

}
