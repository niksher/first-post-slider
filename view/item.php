<?php

?>
<a href="/wp-admin/options-general.php?page=koranBanners%2FkoranBanners.php">
    Список баннеров
</a>
<form 
    class="koran-banners-form"
    method="POST" 
    action="<?= $formUrl ?>"
>
    <label class="form__label">
        <input type="hidden" class="form__input" name="id" value="<?= $banner->id ?>">
    </label>
    <select name="type" class="form__select">
        <option value="0" <?= (int)$banner->type == 0 ? "selected" : ""?>>
            баннер отображаемый в списке баннеров
        </option>
        <option value="1" <?= (int)$banner->type == 1 ? "selected" : ""?>>
            баннер отображаемый отдельной картинкой
        </option>
    </select>
    <label class="form__label">
        <input 
            type="text"
            class="form__input" 
            name="validFrom" 
            value="<?= $banner->validFrom ?>" 
            placeholder="yyyy-MM-dd'T'HH:mm"
        >
        <span class="label__text">
            Дата с которой можно показывать баннер. Дата в формате yyyy-MM-dd'T'HH:mm:ssZZZ
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text"
            class="form__input" 
            name="validFromTimeZone" 
            value="<?= $banner->validFromTimeZone ?>" 
            placeholder="0300"
        >
        <span class="label__text">
            Часовая зона для даты с который можно показывать баннер(если пусто - 0300)
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="validUntil" 
            value="<?= $banner->validUntil ?>" 
            placeholder="yyyy-MM-dd'T'HH:mm"
        >
        <span class="label__text">
            Дата до которой можно показывать баннер. Дата в формате yyyy-MM-dd'T'HH:mm:ssZZZ
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text"
            class="form__input" 
            name="validUntilTimeZone"
            value="<?= $banner->validUntilTimeZone ?>" 
            placeholder="0300"
        >
        <span class="label__text">
            Часовая зона для даты до который можно показывать баннер(если пусто - 0300)
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="title" 
            value="<?= $banner->title ?>"
        >
        <span class="label__text">
            Заголовок баннера
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="image" 
            value="<?= $banner->image ?>"
        >
        <span class="label__text">
            url картинки баннера
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="details" 
            value="<?= $banner->details ?>"
        >
        <span class="label__text">
            Целевой url баннера
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="detailsTitle" 
            value="<?= $banner->detailsTitle ?>"
        >
        <span class="label__text">
            Заголовок на странице деталей
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="width" 
            value="<?= $banner->width ?>"
        >
        <span class="label__text">
            Ширина баннера. Для баннера type=1 возможно указание ширины 0. В таком случае баннер будет отображаться по ширине экрана и пропорционально менять свою высоту
        </span>
    </label>
    <label class="form__label">
        <input 
            type="text" 
            class="form__input" 
            name="height" 
            value="<?= $banner->height ?>"
        >
        <span class="label__text">
            Высота баннера.
        </span>
    </label>
    <input type="submit" class="form__submit" value="<?= $banner->id ? "Сохранить" : "Создать" ?>">
      
</form>

