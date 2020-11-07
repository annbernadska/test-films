<?php include ROOT . '/views/layouts/header.php'; ?>
    <div class="view_film">
        <a class="button" href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
        <table class="film_table">
            <tr>
                <th>#ID</th>
                <th><?= $film["id"] ?></th>
            </tr>
            <tr>
                <th>Название фильма:</th>
                <th><?= $film["title"] ?></th>
            </tr>
            <tr>
                <th>Год выпуска:</th>
                <th><?= $film["release_date"] ?></th>
            </tr>
            <tr>
                <th>Формат:</th>
                <th><?= $film["format"] ?></th>
            </tr>
            <tr>
                <th>Актеры:</th>
                <th>
                    <?if(!empty($actors)):?>
                        <ul>
                            <?foreach ($actors as $actor):?>
                                <li><?=$actor["name"]?></li>
                            <?endforeach;?>
                        </ul>
                    <?else:?>
                        -
                    <?endif?>
                </th>
            </tr>
        </table>
        <a href="/edit/<?= $film["id"]?>">  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> редактировать</a>
        <a href="/delete/<?= $film["id"]?>" onclick="return confirm('Вы уверены что хотите удалить этот фильм?')"> <i class="fa fa-trash" aria-hidden="true"></i> удалить</a>
    </div>
<?php include ROOT . '/views/layouts/footer.php'; ?>