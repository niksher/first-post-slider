<?php

?>

<div class="fps_slider-config">
    <label>
        <input type="checkbox" name="fps-slider" <?= $active_plugin=="1" ? "checked": "" ?>>
        Активировать слайдер
    </label>    
</div>
<div class="fps_slider">
    <h2>
        Статьи в слайдере
    </h2>
    <?php 
    if ($plugin_posts) :
        while ( $plugin_posts->have_posts() ) :
            $plugin_posts->the_post(); 
    ?>
    <div class="fps-slide">
        <p>
            <?= the_ID() ?>
        </p>
        <h3 class="fps-slide__title">
            <?= the_title() ?>
        </h3>
        <input type="button" class="fps__button fps-slide__button" data-id="<?= the_ID() ?>" value="Удалить">
    </div>
        <?php endwhile ?>
    <?php endif ?>
</div>

<div class="fps_posts">
    <h2>
        Статьи на сайте
    </h2>
    <?php while ( $posts->have_posts() ) { $posts->the_post(); ?>
    <div class="fps-slide">
        <p>
            <?= the_ID() ?>
        </p>
        <h3 class="fps-slide__title">
            <?= the_title() ?>
        </h3>
        <input type="button" class="fps__button fps-post__button" data-id="<?= the_ID() ?>" value="Добавить" >
    </div>
    <?php } ?>
    <?= $postPaginator ?>
</div>

<?php
/*
?>

<a 
    class="koran-banners__link koran-banners__add-banner" 
    href="<?= $_SERVER["REQUEST_URI"] . "&status=add" ?>"
>
    Добавить баннер
</a>
<div class="koran-banners-list">
    <div class="koran-banners-list__item">
        <div class="koran-banners-list__col koran-banners-list__item-id">
            ID
        </div>
        <div class="koran-banners-list__col koran-banners-list__item-name">
            Title
        </div>
        <div 
            class="koran-banners-list__col koran-banners-list__item-edit" 
            
        >
            
        </div>
    </div>
    <?PHP FOREACH ($banners as $banner) : ?>
        <div class="koran-banners-list__item">
            <div class="koran-banners-list__col koran-banners-list__item-id">
                <?= $banner->id ?>
            </div>
            <div class="koran-banners-list__col koran-banners-list__item-name">
                <?= $banner->title ?>
            </div>
            <a 
                class="koran-banners-list__col koran-banners-list__item-edit" 
                href="<?= $_SERVER["REQUEST_URI"] . "&status=edit&id=" . $banner->id ?>"
            >
                Редактировать
            </a>
        </div>
    <?PHP ENDFOREACH ?>
</div>

<?PHP IF (count($banners) > 0) : ?>
<a 
    class="koran-banners__link koran-banners__generate-json"
    href="<?= $_SERVER["REQUEST_URI"] . "&status=generate" ?>"
>
    Создать JSON
</a>
<?PHP ENDIF ?>

<?PHP IF ($json) : ?>
<br>
<a 
    class="koran-banners__link koran-banners__generate-json"
    href="/wp-content/plugins/koranBanners/out.json"
    target="_blank"
>
    Посмотреть JSON
</a>
<?PHP ENDIF ?>

*/
