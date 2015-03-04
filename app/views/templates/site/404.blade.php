<?
/**
 * TITLE: Страница 404
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$page_title = 'Страница не найдена';
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="error-cont">
        <div class="container_12">
            <div class="grid_12">
                <div class="error-number">404</div>
                <div class="error-text">Страница не найдена</div>
                <div class="error-desc">
                    <p>Если вы уверены, что это какое-то недоразумение, и тут должно быть нечто важное, <a href="{{ URL::route('page', 'contacts') }}">напишите нам</a>.</p>
                    <p>Вернуться на <a href="{{ URL::route('mainpage') }}">главную страницу</a> сайта</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@stop


@section('footer')

    <footer class="main-footer footer-error">
        <div class="container_12">
            <div class="grid_12 footer-bottom">
                <div class="footer-desc">© 2008-2015, Официальный сайт Николая Левичева, депутата Государственной Думы Федерального Собрания РФ VI созыва, Заместителя Председателя Государственной Думы РФ от фракции СПРАВЕДЛИВАЯ РОССИЯ, Председателя Совета Палаты депутатов Партии СПРАВЕДЛИВАЯ РОССИЯ.</div>
            </div>
            <div class="clearfix"></div>
        </div>
    </footer>

@stop


@section('scripts')
@stop
