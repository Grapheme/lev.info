<?php

return array(

    'fields' => function() {

        return array(
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