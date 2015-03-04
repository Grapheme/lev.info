<?
/**
 * TITLE: Страница со списком новостей
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$year = (int)Input::get('year');
$mon = Input::get('mon');

#if (!$year || !$mon || $year > date('Y') || $year < 2000 || (int)$mon < 1 || (int)$mon > 12)
#    Redirect(URL::route('page', ['news', 'year' => date('Y'), 'mon' => date('m')]));

$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);

$news = Dic::valuesBySlug('news', function($query) use ($year, $mon) {

    $query->filter_by_field(DB::raw("'published_at'"), '<=', date('Y-m-d'));
    $query->order_by_field('published_at', 'DESC');

    if ($year && $mon) {
        $query->filter_by_field(DB::raw("'published_at'"), '<=', $year . '-' . $mon . '-31');
        $query->filter_by_field(DB::raw("'published_at'"), '>', $year . '-' . $mon . '-01');
    }

}, ['fields', 'textfields'], true, true, false, 10);
$news = DicLib::loadImages($news, 'image');
#Helper::smartQueries(1);
#Helper::tad($news);

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
                <h1>Новости</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="main-content">
        <div class="container_12">
            <div class="grid_8">
                @if (0)
                <div class="min-title">{{ Helper::rdate('M Y', $year . '-' . $mon . '-' . date('d'), false, true) }}</div>
                @endif

                <div class="min-title">
                    @if ($year && $mon)
                        {{ Helper::rdate('M Y', $year . '-' . $mon . '-' . date('d'), false, true) }}
                    @elseif (!Input::get('page') || Input::get('page') == 1)
                        Последние новости
                    @else
                        &nbsp;
                    @endif
                </div>

                @if (isset($news) && is_object($news) && $news->count())
                    <ul class="main-feed">
                        @foreach ($news as $new)
                        <li class="feed-item"><a href="{{ URL::route('app.new', $new->slug) }}" class="feed-title">{{ $new->name }}</a>
                            <div class="feed-date">{{ Helper::rdate('j M Y', $new->published_at) }}</div>
                            <div class="feed-desc"><img src="{{ is_object($new->image) ? $new->image->full() : '' }}"><span>{{ $new->preview }}</span>
                                <div class="clearfix"></div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    {{ $news->appends(Input::all())->links() }}
                @else
                    <div>
                        <br/>
                        Нет записей.
                    </div>
                @endif

                {{--
                <div class="pagination-block">
                    <a href="#" class="pag-arrow left"></a>
                    <a href="#" class="pag-arrow right"></a>
                    <ul class="pag-numbers">
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                    </ul>
                </div>
                --}}

            </div>
            <div class="grid_4">

                <div class="min-title">Архив новостей</div>

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