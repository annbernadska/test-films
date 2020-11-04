<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="navigation">
    <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
    <div class="search">
        <form action="/search" method="post">
            <input type="text" class="form-control" name="search" value="<?=$query?>" placeholder="Введите название фильма или актёра">
            <input type="submit" class="btn btn-info" value="Поиск">
        </form>
    </div>
</div>
<h3>Результаты поиска:</h3>
<h5><?=(!empty($films))?'По названию фильма:':''?></h5>
<?php foreach ($films as $item): ?>
    <section class="section_films">
        <a href="/view/<?= $item["id"] ?>"><?= $item["title"] ?></a>
        <br>
        <span><?= $item["release_date"] ?></span>
    </section>
<?php endforeach; ?>
<?php foreach ($actors as $name => $films): ?>
<h5>По имени актера <?=$name?>:</h5>
    <?php foreach ($films as $film): ?>
        <section class="section_films">
            <a href="/view/<?= $film['id'] ?>"><?= $film['title'] ?></a>
            <br>
            <span><?= $film["release_date"] ?></span>
        </section>
    <?php endforeach; ?>
<?php endforeach; ?>
<?=(empty($films) && empty($actors))?'Ничего не найдено':''?>

<?php include ROOT . '/views/layouts/footer.php'; ?>







