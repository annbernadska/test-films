<?php include ROOT . '/views/layouts/header.php'; ?>
    <div class="view_film">
        <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
        <form action="/store" method="POST">
            <label style="margin-top: 20px;">Название</label>
            <input type="text" class="form-control" value="" name="title" required>

            <label style="margin-top: 20px;">Дата выхода</label>
            <input  type="number" class="form-control" value="" name="release_date" required>

            <label style="margin-top: 20px;">Формат</label>
            <input type="text" class="form-control" value="" name="format" required>

            <label style="margin-top: 20px;">Список актёров:</label>
            <select class="js-select" size="10" multiple name="actors[]">
                    <?foreach ($actors as $actor):?>
                        <option value="<?=$actor['id']?>"><?=$actor['name']?></option>
                    <?endforeach?>
            </select>
            <br>
            <input type="submit" class="btn btn-success" value="Сохранить">
        </form>
    </div>
<?php include ROOT . '/views/layouts/footer.php'; ?>