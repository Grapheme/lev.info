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
                'title' => 'Изображение',
                'type' => 'image',
            ),
            'youtube_link' => array(
                'title' => 'Ссылка на страницу YouTube с видео',
                'type' => 'textarea',
            ),
        );
    },

    'seo' => false,

    'versions' => false,

);