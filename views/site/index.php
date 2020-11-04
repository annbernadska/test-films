<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="navigation">
    <a href="/create" class="btn btn-success">Добавить</a>
    <span href="" class="btn btn-info  js_import_btn">Загрузить</span>
    <div class="import_form">
        <form action="/import" method="post" enctype="multipart/form-data">
            <input id="filename" type="file" name="filename"><br>
            <input type="submit" class="btn btn-info" value="Загрузить">
        </form>
    </div>
    <div class="search">
        <form action="/search" method="post">
            <input type="text" class="form-control" name="search" placeholder="Введите название фильма или актёра">
            <input type="submit" class="btn btn-info" value="Поиск">
        </form>
    </div>
</div>
<h3>Список фильмов:</h3>
<?php foreach ($films as $item): ?>
    <section class="section_films">
        <a href="/view/<?= $item["id"] ?>"><?= $item["title"] ?></a>
        <br>
        <span><?= $item["release_date"] ?></span>
    </section>
<?php endforeach; ?>

<?php include ROOT . '/views/layouts/footer.php'; ?>







