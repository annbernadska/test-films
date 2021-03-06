<?php


class FilmController
{

    public function actionIndex($page = 1)
    {
        $films = Film::getNewsList($page);
        $total = Film::getTotalFilms();
        $paginator = new Pagination($total, $page, Film::POST_ON_PAGE, 'page-');

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
        if (!Film::exist($_POST)) {
            $filmId = Film::store($_POST);
            if (!empty($_POST['actors'])) {
                Actors::addActorsToFilm($filmId, $_POST['actors']);
            }
            header("Location: /");
        } else {
            $exist = true;
            $actors = Actors::getAllActors();

            require_once(ROOT . '/views/site/create.php');
            return true;
        }

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
        $file = $_FILES['filename'];

        if ($file['size'] != 0) {
            $parserObj = ParserFactory::getParserObj($file);
            $content = $parserObj->getContent();

            Film::importFilms($content);
        }
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