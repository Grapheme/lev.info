<?php

return array(

    'fields' => function() {

        return array(
            'published_at' => array(
                'title' => 'Дата публикации',
                'type' => 'date',
                'others' => array(
                    'class' => 'text-center',
                    'style' => 'width: 221px',
                    'placeholder' => 'Нажмите для выбора'
                ),
                'handler' => function($value) {
                    return $value ? @date('Y-m-d', strtotime($value)) : $value;
                },
                'value_modifier' => function($value) {
                    return $value ? date('d.m.Y', strtotime($value)) : date('d.m.Y');
                },
            ),
            'image' => array(
                'title' => 'Основное изображение',
                'type' => 'image',
            ),
            'gallery' => array(
                'title' => 'Галерея',
                'type' => 'gallery',
                'params' => array(
                    'maxfilesize' => 4, // MB
                    #'acceptedfiles' => 'image/*',
                ),
                'handler' => function($array, $element) {
                    return ExtForm::process('gallery', array(
                        'module'  => 'DicValMeta',
                        'unit_id' => $element->id,
                        'gallery' => $array,
                        'single'  => true,
                    ));
                }
            ),
            'author' => array(
                'title' => 'Автор фото',
                'type' => 'text',
            ),
        );
    },

    'seo' => false,

    'versions' => false,

);