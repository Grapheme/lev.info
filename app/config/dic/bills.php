<?php

return array(

    'fields' => function() {

        return array(
            'short' => array(
                'title' => 'Краткое описание',
                'type' => 'textarea',
            ),
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
            'meta_info' => array(
                'title' => 'Служебнаяи информация - авторы, дата внесения в ГД, Рег.№ и т.д.',
                'type' => 'textarea_redactor',
            ),
            'note' => array(
                'title' => 'Пояснительная записка',
                'type' => 'textarea_redactor',
            ),
            'fulltext' => array(
                'title' => 'Текст законопроекта',
                'type' => 'textarea_redactor',
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
        );
    },

    'seo' => false,

    'versions' => false,

);