# first-post-slider
wp plugin for change first post on home page into slider


1) скачать как архив
2) в админке wordpress установить из архива(добавить плагины - загрузить плагин)
3) активировать плагин
4) настроить плагин (в левом меню - настройки -> First Post slider Plugin)
5) галочка "активировать плагин" активирует режим в котором первая новость заменяеся слайдером
6) добавление и удаление новостей в слайдере. а так же активация/деактивация слайдера происходят с перезагрузкой страницы
7) для того чтобы плагин заработал необходимо так же модифицировать файл /wp-content/themes/fox/home.php. можно заменить его тем что лежит в архиве, либо изменить в двух местах 
первое место на 13 строке после 
```
$loop = $layout;
if (strpos($loop,'grid')!==false) $loop = 'grid';
if (strpos($loop,'masonry')!==false) $loop = 'masonry';
```
добавить код 
```
if (function_exists("first_news_slider")) {
    $first_news_slider = first_news_slider();
}
```

получится
```
$layout = wi_layout();
// loop
$loop = $layout;
if (strpos($loop,'grid')!==false) $loop = 'grid';
if (strpos($loop,'masonry')!==false) $loop = 'masonry';
if (function_exists("first_news_slider")) {
   $first_news_slider = first_news_slider();
}
// column
$column = 2;
if (strpos($layout,'2')!==false) $column = '2';
if (strpos($layout,'3')!==false) $column = '3';
if (strpos($layout,'4')!==false) $column = '4';
```

второе место - 265 строка после
```
if ( $display_ad ) {

    get_template_part('loop/content', 'ad' );

}
```
добавить код 
```
if (function_exists("echo_first_news_slider")) {
    echo_first_news_slider($first_news_slider);
}
```

в итоге получится

```
if ( $display_ad ) {

    get_template_part('loop/content', 'ad' );

}
                            
if (function_exists("echo_first_news_slider")) {
    echo_first_news_slider($first_news_slider);
}

get_template_part('loop/content', $loop );

endwhile
```
