<?php include ROOT . '/views/layouts/header.php'; ?>
    <div class="view_film">
        <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
        <form action="/update/<?= $film["id"] ?>" method="POST">
            <label style="margin-top: 20px;">Название</label>
            <input type="text" class="form-control" value="<?= $film["title"] ?>" name="title" required>

            <label style="margin-top: 20px;">Дата выхода</label>
            <input  type="number" class="form-control" value="<?= $film["release_date"] ?>" name="release_date" required  required min="1850" max="2020">

            <label style="margin-top: 20px;">Формат</label>
            <select class="js-select-format form-control" size="10" name="format" required>
                <option <?=($film['format'] == 'DVD')?'selected':''?> value="DVD">DVD</option>
                <option <?=($film['format'] == 'VHS')?'selected':''?> value="VHS">VHS</option>
                <option <?=($film['format'] == 'Blu-Ray')?'selected':''?> value="Blu-Ray">Blu-Ray</option>
            </select>

            <label style="margin-top: 20px;">Список актёров:</label><br>
            <select class="js-select" size="10" multiple name="actors[]">
                    <?foreach ($allActors as $actor):?>
                        <option <?=(in_array($actor['id'], $filmActors))?'selected':''?>  value="<?=$actor['id']?>"><?=$actor['name']?></option>
                    <?endforeach?>
            </select>
            <br>
            <input type="submit" class="btn btn-success" value="Сохранить">

        </form>
    </div>
<?php include ROOT . '/views/layouts/footer.php'; ?>