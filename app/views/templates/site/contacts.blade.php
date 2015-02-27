<?
/**
 * TITLE: Контакты
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Контакты</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="main-content">
        <div class="container_12">
            <div class="grid_8">
                <div class="min-title">Обратная связь</div>
                <div class="in-content">

                    {{ $page->block('description') }}

                    <div class="contact-form">
                        <form>
                            <textarea placeholder="Ваше сообщение" class="us-input js-autosize"></textarea>
                            <table class="form-table">
                                <tr>
                                    <td class="table-text">Представьтесь</td>
                                    <td>
                                        <input class="us-input">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-text">Электронная почта</td>
                                    <td>
                                        <input class="us-input">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-text">Ваш телефон</td>
                                    <td>
                                        <input class="us-input">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-text">Прикрепить файлы</td>
                                    <td class="table-file">
                                        <input type="file">
                                        <div class="form-file-desc">Допустимы форматы rtf, doc, docx, pdf, jpg</div>
                                    </td>
                                </tr>
                                <tr class="form-btn-cont">
                                    <td>&nbsp;</td>
                                    <td>
                                        <button class="us-btn">Отправить форму</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="grid_4 contacts-right">
                <div class="min-title">Приемная</div>

                {{ $page->block('reception') }}

                <div class="press-block">

                    <div class="min-title">Контакты для прессы</div>

                    {{ $page->block('press-contact') }}

                </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@stop


@section('scripts')
@stop