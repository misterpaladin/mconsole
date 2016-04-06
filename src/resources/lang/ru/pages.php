<?php 

return [
    'module' => [
        'description' => 'Управление текстовыми страницами',
    ],
    'menu' => [
        'list' => [
            'name' => 'Список страниц',
            'description' => 'Вывод списка страниц'
        ],
        'form' => [
            'name' => 'Добавить страницу',
        ],
    ],
    'table' => [
        'updated' => 'Обновлено',
        'slug' => 'Адрес',
        'heading' => 'Заголовок',
    ],
    'form' => [
        'main' => 'Данные страницы',
        'content' => 'Контент',
        'gallery' => 'Изображения',
        'additional' => 'Доп. параметры',
        'options' => 'Настройки',
        'links' => 'Ссылки',
        'slug' => 'Адрес страницы',
        'heading' => 'Заголовок',
        'preview' => 'Превью',
        'text' => 'HTML',
        'seo' => 'Настройки SEO',
        'title' => 'Заголовок в поисковике',
        'description' => 'Описание страницы',
        'hide_heading' => [
            'name' => 'Скрыть заголовок',
            'false' => 'нет',
            'true' => 'да',
        ],
        'fullwidth' => [
            'name' => 'Контент на ширину сайта',
            'false' => 'нет',
            'true' => 'да',
        ],
        'enabled' => [
            'name' => 'Опубликовано',
            'true' => 'да',
            'false' => 'нет',
        ],
        'links' => [
            'title' => 'Текст',
            'url' => 'Адрес',
            'enabled' => 'Опубликовать',
        ],
    ],
];