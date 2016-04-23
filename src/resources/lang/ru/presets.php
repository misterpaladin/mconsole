<?php

return [
    'menu' => [
        'list' => [
            'name' => 'Шаблоны загрузки',
            'description' => 'Вывод списка шаблонов',
        ],
        'create' => [
            'name' => 'Добавить шаблон',
            'description' => 'Добавить новый шаблон для загрузки файлов',
        ],
        'update' => [
            'name' => 'Редактировать шаблон',
            'description' => 'Измение требования к загружаемым файлам, а так же добавить/удалить операции обработки изображений',
        ],
        'delete' => [
            'name' => 'Удалить шаблон',
            'description' => '',
        ],
    ],
    'types' => [
        'image' => 'Изображения',
        'document' => 'Документы',
        'audio' => 'Аудио файлы',
        'video' => 'Видео файлы',
    ],
    'table' => [
        'id' => '#',
        'name' => 'Название',
        'type' => 'Применение',
        'operations' => 'Количество правил',
    ],
    'form' => [
        'type' => 'Применение',
        'width' => 'Ширина',
        'height' => 'Высота',
        'main' => 'Основные',
        'operations' => [
            'title' => 'Правила обработки изображения',
            'add' => 'Добавить правило',
            'type' => 'Тип правила',
            'remove' => 'Удалить',
            'resize' => [
                'name' => 'Способ изменения размера',
                'ratio' => 'Сохранить пропорции',
                'center' => 'От центра',
                'fixed' => 'Фиксированный размер',
            ],
            'save' => [
                'path' => 'Поддиректория',
                'quality' => 'Качество',
                'pathhelp' => 'Директория будет дописана к директории пресета. При использовании директории из другого правила файл будет перезаписан!',
            ],
            'watermark' => [
                'top' => 'Сверху',
                'center' => 'От центра',
                'bottom' => 'Снизу',
                'left' => 'Слева',
                'right' => 'Справа',
            ],
            'types' => [
                'groups' => [
                    'file' => 'Файл',
                    'actions' => 'Операции',
                    'filters' => 'Фильтры',
                ],
                'notselected' => 'Не выбрано',
                'loadoriginal' => 'Взять оригинал',
                'resize' => 'Изменить размер',
                'save' => 'Сохранить копию',
                'watermark' => 'Наложить водяной знак',
                'greyscale' => 'Обесцветить',
            ],
        ],
        'sequence' => 'Все операции выполняются последовательно',
        'name' => 'Название шаблона',
        'extensions' => 'Допустимые расширения файлов (без точки, через запятую)',
        'minwidth' => 'Минимальная ширина',
        'minheight' => 'Минимальная высота',
        'path' => 'Директория для сохранения',
        'imageonly' => 'Правила обработки доступны только для изображений',
    ],
];
