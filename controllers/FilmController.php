<?php


class FilmController
{

    public function actionIndex()
    {
        $films = Film::getNewsList();

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    public function actionView(int $id)
    {
        $film = Film::findById($id);
        $actors = Actors::getActorsByFilm($id);

        require_once(ROOT . '/views/site/view.php');
        return true;
    }

    public function actionCreate()
    {
        $actors = Actors::getAllActors();

        require_once(ROOT . '/views/site/create.php');
        return true;
    }

    public function actionStore()
    {
        $filmId = Film::store($_POST);
        if (!empty($_POST['actors'])) {
            Actors::addActorsToFilm($filmId, $_POST['actors']);
        }
        header("Location: /");
    }

    public function actionEdit(int $id)
    {
        $film = Film::findById($id);
        $filmActors = array_column(Actors::getActorsByFilm($id), 'id');
        $allActors = Actors::getAllActors();

        require_once(ROOT . '/views/site/edit.php');
        return true;
    }

    public function actionUpdate(int $id)
    {
        Film::updateById($id, $_POST);
        if (!empty($_POST['actors'])) {
            Actors::updateActorsFilm($id, $_POST['actors']);
        }
        header("Location: /");
    }

    public function actionDelete(int $id)
    {
        Film::deleteById($id);
        header("Location: /");
    }

    public function actionImport()
    {
        $docObj = new DocParser($_FILES['filename']['tmp_name']);
        $filmsArray = $docObj->getFilms();

        Film::importFilms($filmsArray);
        header("Location: /");
    }

    public function actionSearch()
    {
        $query = $_POST['search'];
        $films = Film::search($query);
        $actors = Actors::search($query);

        require_once(ROOT . '/views/site/search.php');
        return true;
    }

}