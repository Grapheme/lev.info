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
    @if (isset($new->image) && is_object($new->image))
        <meta property="og:image" content="{{ $new->image->full() }}">
    @endif
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
                        @if (isset($new->gallery) && is_object($new->gallery) && isset($new->gallery->photos) && is_object($new->gallery->photos) && $new->gallery->photos->count())
                            <div class="album-cont album-cont-news">
                                <ul class="album-items">
                                    @foreach ($new->gallery->photos as $photo)
                                        <li class="album-li"><a rel="fancybox-thumb" href="{{ $photo->full() }}" style="background-image: url({{ $photo->full() }})" title="{{ $photo->title }}" class="album-one-photo js-fancybox"><img src="{{ $photo->thumb() }}" alt=""></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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