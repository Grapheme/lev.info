<?php

return array(

    'fields' => function() {

        return array(
            'image' => array(
                'title' => 'Фоновое изображение',
                'type' => 'image',
            ),
            'link' => array(
                'title' => 'Ссылка',
                'type' => 'text',
                'others' => [
                    'placeholder' => 'http://'
                ]
            ),
        );
    },

    'seo' => false,

    'versions' => false,

);