<?php

return [
    'menu' => [
        'name' => 'Модули',
        'description' => 'Список доступных модулей',
    ],
    'table' => [
        'title' => 'Список модулей',
        'info' => 'Информация',
        'authors' => 'Авторы',
        'uninstall' => [
            'process' => 'Идет удаление..',
            'info' => 'Удалить модуль, включая все его данные',
            'modal' => [
                'title' => 'Удалить модуль?',
                'content' => 'Внимание! Удаление модуля подразумевает удаление всех файлов модуля, а так же всей информации в базе данных. Вы уверены что хотите продолжить?',
                'cancel' => 'Отменить',
                'uninstall' => 'Удалить',
            ],
        ],
        'install' => [
            'process' => 'Идет установка..',
            'info' => 'Установить модуль',
            'package' => 'Установка',
        ],
        'extend' => [
            'process' => 'Идет расширение..',
            'custom' => '',
            'extended' => '',
            'base' => '',
        ],
        'buttons' => [
            'uninstall' => 'Удалить',
            'install' => 'Установить',
            'extend' => 'Расширить',
        ],
        'installed' => 'Установлен',
        'available' => 'Доступен',
        'notavailable' => 'Недоступен',
        'depends' => 'Зависимости модуля',
        'components' => 'Компоненты модуля',
        'extended' => 'Расширенные компоненты',
        'base' => 'Базовые компоненты',
        'models' => 'Модели',
        'controllers' => 'Контроллеры',
        'requests' => 'Запросы',
        'migrations' => 'Миграции',
        'views' => 'Представления',
        'translations' => 'Языковые файлы',
        'unabletoinstall' => 'Установка не возможна, отсутствуют зависимости для модуля',
    ],
    'acl' => [
        'index' => 'Модули: просмотр списка',
        'extend' => 'Модули: расширение',
        'install' => 'Модули: установка',
        'uninstall' => 'Модули: удаление',
    ],
];
