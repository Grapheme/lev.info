<?php

return array(

    'fields' => function() {

        return array(
            'image' => array(
                'title' => 'Изображение',
                'type' => 'image',
            ),
            'description' => array(
                'title' => 'Описание',
                'type' => 'textarea',
            ),
            'file' => array(
                'title' => 'Файл PDF',
                'type' => 'upload',
                'accept' => '*', # .exe,image/*,video/*,audio/*
                'label_class' => 'input-file',
                'handler' => function($value, $element = false) {
                    if (@is_object($element) && @is_array($value)) {
                        $value['module'] = 'DicVal';
                        $value['unit_id'] = $element->id;
                    }
                    return ExtForm::process('upload', $value);
                },
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