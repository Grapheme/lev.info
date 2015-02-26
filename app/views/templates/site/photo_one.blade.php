<?
/**
 * TITLE: Страница со списком фотографий
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Фото</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container_12">
        <div class="grid_12">
            <div class="album-cont">

                <div class="album-info">
                    <div class="album-date">{{ Helper::rdate('j M Y', $gallery->created_at) }}</div>
                    <div class="album-title">{{ $gallery->name }}</div>
                    @if($gallery->author)
                        <div class="album-author">Фото: {{ $gallery->author }}</div>
                    @endif
                </div>

                @if (isset($gallery->gallery) && is_object($gallery->gallery) && isset($gallery->gallery->photos) && is_object($gallery->gallery->photos) && $gallery->gallery->photos->count())
                    <ul class="album-items">
                        @foreach ($gallery->gallery->photos as $photo)
                            <li class="album-li"><a rel="fancybox-thumb" href="{{ $photo->full() }}" style="background-image: url({{ $photo->full() }})" title="{{ $photo->title }}" class="album-one-photo js-fancybox"><img src="{{ $photo->thumb() }}" alt=""></a></li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
        <div class="clearfix"></div>
    </div>

@stop


@section('scripts')
@stop