<?
/**
 * TITLE: Страница со списком фотографий
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$year = (int)Input::get('year');
$mon = Input::get('mon');

$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);

$photos = Dic::valuesBySlug('photo', function($query) use ($year, $mon) {

    #$query->filter_by_field(DB::raw("'created_at'"), '<=', date('Y-m-d'));
    #$query->order_by_field('created_at', 'DESC');

    $query->where('created_at', '<=', date('Y-m-d'));
    $query->orderBy('created_at', 'DESC');

    if ($year && $mon) {
        $query->filter_by_field(DB::raw("'published_at'"), '<=', $year . '-' . $mon . '-31');
        $query->filter_by_field(DB::raw("'published_at'"), '>', $year . '-' . $mon . '-01');
    }

}, ['fields', 'textfields'], true, true, false, 2);
$photos = DicLib::loadImages($photos, 'image');
$photos = DicLib::loadGallery($photos, 'gallery');
#Helper::smartQueries(1);
#Helper::tad($photos);

$current_time =
        ($year && $mon && $year <= date('Y') && $year >= 2000 && (int)$mon >= 1 && (int)$mon <= 12)
        ? (new Carbon\Carbon())->createFromFormat('Y-m', $year . '-' . $mon)
        : (new Carbon\Carbon())->createFromFormat('Y-m', date('Y-m'))
        ;
#Helper::dd($current_time);

$prev_link_time = clone $current_time;
$prev_link_time->subMonth();

$next_link_time = clone $current_time;
$next_link_time->addMonth();
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
    <div class="main-content">
        <div class="container_12">
            <div class="grid_8">


                <div class="min-title">
                    @if ($year && $mon)
                        {{ Helper::rdate('M Y', $year . '-' . $mon . '-' . date('d'), false, true) }}
                    @elseif (!Input::get('page') || Input::get('page') == 1)
                        Последние фотографии
                    @else
                        &nbsp;
                    @endif
                </div>


                <div class="in-content">
                    @if (isset($photos) && is_object($photos) && $photos->count())
                        <ul class="album-list">
                            @foreach ($photos as $photo)
                                <li class="album-item photo-item"><a href="{{ URL::route('app.gallery', $photo->id) }}" style="background-image: url({{ is_object($photo->image) ? $photo->image->full() : '' }})" class="album-photo"></a>
                                    <div class="album-info">
                                        <div class="info-date">{{ Helper::rdate('j M Y', $photo->created_at) }}</div>
                                        <div class="info-title"><a href="{{ URL::route('app.gallery', $photo->id) }}" class="title-link">{{ $photo->name }}</a></div>
                                        @if (isset($photo->gallery) && is_object($photo->gallery) && isset($photo->gallery->photos) && is_object($photo->gallery->photos) && $photo->gallery->photos->count())
                                            <div class="info-amount">{{ $photo->gallery->photos->count() }} фото</div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        {{ $photos->appends(Input::all())->links() }}
                    @else
                        <div>
                            <br/>
                            Нет записей.
                        </div>
                    @endif
                </div>

            </div>
            <div class="grid_4">

                <div class="min-title">Фотоархив</div>

                <div class="in-content album-filter">
                    <div class="filter-cont">
                        <div class="filter-inside">
                            <form action="?" method="GET">
                                <select name="mon" class="us-select">
                                    @foreach (Config::get('site.monthes') as $key => $value)
                                        <option value="{{ $key }}"{{ $current_time->format('m') == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <select name="year" class="us-select">
                                    @for ($i = date('Y'); $i >= Config::get('site.start_year'); --$i)
                                        <option value="{{ $i }}"{{ $current_time->format('Y') == $i ? ' selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select><br>
                                <button class="filter-btn">Перейти</button>
                            </form>
                        </div>
                    </div>
                    <div class="filter-status">
                        <a href="?mon={{ $prev_link_time->format('m') }}&year={{ $prev_link_time->format('Y') }}" class="title-link"><i class="fi icon-keyboard-arrow-left"></i><span>{{ @Config::get('site.monthes')[$prev_link_time->format('m')] }} {{ $prev_link_time->format('Y') }}</span></a>
                        @if ($next_link_time->format('Y-m') <= date('Y-m'))
                            <a href="?mon={{ $next_link_time->format('m') }}&year={{ $next_link_time->format('Y') }}" class="title-link fl-r"><span>{{ @Config::get('site.monthes')[$next_link_time->format('m')] }} {{ $next_link_time->format('Y') }}</span><i class="fi icon-keyboard-arrow-right"></i></a>
                        @endif
                    </div>
                </div>

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