<?
/**
 * TITLE: Главная страница
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
#$facebook_widget = Dic::valueBySlugs('options', 'facebook_widget', ['textfields']);
#$twitter_widget = Dic::valueBySlugs('options', 'twitter_widget', ['textfields']);
$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);

$slides = Dic::valuesBySlug('slider', function($query) {
    $query->orderBy('lft', 'ASC');
});
$slides = DicLib::loadImages($slides, 'image');
#Helper::tad($slides);

$news = Dic::valuesBySlug('news', function($query) {
    $query->filter_by_field('published_at', '<=', date('Y-m-d H:i:s'));
    $query->order_by_field('published_at', 'DESC');
    $query->take(2);
}, ['fields', 'textfields']);
$news = DicLib::loadImages($news, 'image');
#Helper::tad($news);

$bill = NULL;
$bills = Dic::valuesBySlug('bills', function($query) {
    $query->orderBy('created_at', 'DESC');
    $query->take(1);
}, ['fields', 'textfields']);
#Helper::tad($bills);
if (isset($bills) && is_object($bills) && $bills->count() == 1) {
    $bill = $bills[0];
    $bill = DicLib::loadFiles($bill, 'file');
}
#Helper::tad($bill);

$photos = Dic::valuesBySlug('photo', function($query) {
    #$query->orderBy('created_at', 'DESC');
    $query->filter_by_field('published_at', '<=', date('Y-m-d H:i:s'));
    $query->order_by_field('published_at', 'DESC');
    $query->take(2);
}, ['fields']);
$photos = DicLib::loadImages($photos, 'image');
$photos = DicLib::loadGallery($photos, 'gallery');
#Helper::tad($photos);

$audios = Dic::valuesBySlug('audio', function($query) {
    #$query->orderBy('created_at', 'DESC');
    $query->filter_by_field('published_at', '<=', date('Y-m-d H:i:s'));
    $query->order_by_field('published_at', 'DESC');
    $query->take(1);
}, ['fields', 'textfields']);
#Helper::tad($audios);

$videos = Dic::valuesBySlug('video', function($query) {
    #$query->orderBy('created_at', 'DESC');
    $query->filter_by_field('published_at', '<=', date('Y-m-d H:i:s'));
    $query->order_by_field('published_at', 'DESC');
    $query->take(1);
}, ['fields', 'textfields']);
$videos = DicLib::loadImages($videos, 'image');
#Helper::tad($videos);
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    {{--СЛАЙДЕР--}}
    @if (isset($slides) && is_object($slides) && $slides->count())
        <div class="index-block">
            <div class="container_12">
                <div class="grid_12">
                    <div class="index-slider js-slider"><a href="#" class="index-arrow a-left js-prev"></a><a href="#" class="index-arrow a-right js-next"></a>
                        <div class="js-fotorama" data-autoplay="5000">
                            @foreach ($slides as $slide)
                                <div style="background-image: url({{ is_object($slide->image) ? $slide->image->full() : '' }})" data-caption="{{{ $slide->name }}}" class="fororama-slide">&nbsp;<a href="{{ $slide->link ?: '#' }}"></a></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @endif

    <div class="main-content index-content">
        <div class="container_12">
            <div class="grid_8">

                {{--НОВОСТИ--}}
                @if (isset($news) && is_object($news) && $news->count())
                    <div class="min-title"><a href="{{ URL::route('page', 'news') }}">Новости</a></div>
                    <ul class="main-feed">
                        @foreach ($news as $new)
                            <li class="feed-item">
                                <div class="feed-date">{{ Helper::rdate('j M Y', $new->published_at) }}</div>
                                <a href="{{ URL::route('app.new', $new->slug) }}" class="feed-title">{{ $new->name }}</a>
                                <div class="feed-desc">
                                    @if (isset($new->image) && is_object($new->image))
                                        <img src="{{ is_object($new->image) ? $new->image->full() : '' }}">
                                    @endif
                                    <span>{{ $new->preview }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{--ЗАКОНОПРОЕКТЫ--}}
                @if (isset($bill) && is_object($bill))
                    <div data-law-id="{{ $bill->id }}" class="law-block js-law-item"><a href="{{ URL::route('page', 'bills') }}" class="section-title">Законопроекты</a><a href="#" class="feed-title js-open-law">{{ $bill->name }}</a>
                        <div class="law-desc">{{ $bill->short }}</div>
                    </div>
                @endif

                {{--ФОТО--}}
                @if (isset($photos) && is_object($photos) && $photos->count())
                    <div class="min-title"><a href="{{ URL::route('page', 'photos') }}">Фото</a></div>
                    <div class="in-content">
                        <ul class="album-list">
                            @foreach ($photos as $photo)
                            <li class="album-item photo-item"><a href="{{ URL::route('app.gallery', $photo->id) }}" style="background-image: url({{ is_object($photo->image) ? $photo->image->full() : '' }})" class="album-photo"></a>
                                <div class="album-info">
                                    <div class="info-date">{{ Helper::rdate('j M Y', $photo->created_at) }}</div>
                                    <div class="info-title"><a href="{{ URL::route('app.gallery', $photo->id) }}" class="title-link">{{ $photo->name }}</a></div>
                                    @if (isset($photo->gallery) && is_object($photo->gallery) && isset($photo->gallery->photos) && is_object($photo->gallery->photos))
                                        <div class="info-amount">{{ count($photo->gallery->photos) }} фото</div>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{--АУДИО--}}
                @if (isset($audios) && is_object($audios) && $audios->count())
                    <div class="min-title"><a href="{{ URL::route('page', 'audio') }}">Аудио</a></div>
                    <ul class="main-feed">
                        @foreach ($audios as $audio)
                            <li class="feed-item js-audio-cont js-audio-opened">
                                <div class="feed-date">{{ Helper::rdate('j M Y', $audio->published_at) }}</div>
                                <div class="feed-title js-audio-open">{{ $audio->name }}</div>
                                <div class="audio-cont js-audio">{{ $audio->embed }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
            <div class="grid_4">

                {{--ВИДЕО--}}
                @if (isset($videos) && is_object($videos) && $videos->count())
                    <div class="min-title"><a href="{{ URL::route('page', 'video') }}">Видео</a></div>
                    <ul class="album-list search-albums">
                        @foreach($videos as $video)
                            <?
                            $embed_link = str_replace('/watch?v=', '/embed/', $video->youtube_link);
                            ?>
                            <li class="album-item video-item"><a href="{{ $embed_link }}" style="background-image: url({{ is_object($video->image) ? $video->image->full() : '' }})" class="js-fancybox album-photo fancybox.iframe"></a>
                                <div class="album-info">
                                    <div class="info-date"><span>{{ Helper::rdate('j M Y', $video->created_at) }}</span></div>
                                    <div class="info-title"><a href="{{ $embed_link }}" class="js-fancybox title-link fancybox.iframe">{{ $video->name }}</a></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

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

    <div class="law-overlay js-law-overlay">
        <div class="law-close js-law-close"></div>
        <div class="law-arrow a-left js-law-prev"></div>
        <div class="law-arrow a-right js-law-next"></div>
        @if (isset($bill) && is_object($bill))
            <div data-law-id="{{ $bill->id }}" class="law-popup js-law-popup">
                <div class="law-title">{{ $bill->name }}</div>
                <div class="law-date">{{ Helper::rdate('j M Y', $bill->created_at) }}</div>
                @if ($bill->meta_info)
                    <div class="law-info">
                        {{ $bill->meta_info }}
                    </div>
                @endif
                <div class="law-text">
                    @if (isset($bill->file) && is_object($bill->file) && $bill->file->id)
                        <div class="info-block">
                            <div class="upper-title">Законопроект</div><a href="{{ $bill->file->path }}" class="info-file"><span>PDF, {{ ceil(($bill->file->filesize)/1024) }} kB</span></a>
                        </div>
                    @endif
                    {{ $bill->fulltext }}
                </div>
            </div>
        @endif
    </div>

@stop


@section('scripts')
@stop