<?
/**
 * TITLE: Страница одной новости
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?
$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);

$page_title = $new->name;
$seo = $new->seo;
?>
@extends(Helper::layout())


@section('style')
    <meta property="og:title" content="{{ $new->name }}">
    <meta property="og:description" content="{{ $new->preview }}">
    <meta property="og:image" content="{{ $new->image->full() }}">
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Новости</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="main-content">
        <div class="container_12">
            <div class="grid_8">
                <div class="min-title"><a href="{{ URL::route('page', 'news') }}" class="back-link"><i class="fi icon-keyboard-arrow-left"></i><span>Вернуться к списку новостей</span></a>&nbsp;</div>
                <div class="main-feed">
                    <div class="feed-item">
                        <div class="feed-date">{{ Helper::rdate('j M Y', $new->published_at) }}</div>
                        <div class="feed-title">{{ $new->name }}</div>
                        <div class="news-desc">{{ $new->preview }}</div>
                        <div class="news-text js-news-text">
                            {{ $new->content }}
                        </div>
                    </div>
                    <div class="share-block">
                        <span>Поделиться</span>
                        <a href="http://twitter.com/share?url={{ Request::url() }}&text={{ urlencode($new->name) }}" class="js-share soc-twitter"></a>
                        <a href="http://www.facebook.com/sharer.php?u={{ Request::url() }}&t={{ urlencode($new->name) }}" class="js-share soc-facebook"></a>
                    </div>
                </div>
            </div>

            <div class="grid_4">

                @if (isset($options['facebook_widget']) && is_object($options['facebook_widget']) && $options['facebook_widget']->value)
                    <div class="min-title">Facebook</div>
                    <div class="soc-block">
                        {{ $options['facebook_widget']->value }}
                    </div>
                @endif

                @if (isset($options['twitter_widget']) && is_object($options['twitter_widget']) && $options['twitter_widget']->value)
                    <div class="min-title">Twitter</div>
                    <div class="soc-block">
                        {{ $options['twitter_widget']->value }}
                    </div>
                @endif

            </div>

            <div class="clearfix"></div>
        </div>
    </div>

@stop


@section('scripts')
@stop