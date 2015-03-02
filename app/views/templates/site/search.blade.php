<?
/**
 * TITLE: Контакты
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$q = Input::get('q');

$sphinx_match_mode = \Sphinx\SphinxClient::SPH_MATCH_ANY;

/**
 * news
 */
$results['news'] = SphinxSearch::search($q, 'levichev_news_index')->setMatchMode($sphinx_match_mode)->query();
$results_counts['news'] = count($results['news']['matches']);
$results['photo'] = SphinxSearch::search($q, 'levichev_photo_index')->setMatchMode($sphinx_match_mode)->query();
$results_counts['photo'] = isset($results['photo']['matches']) ? count($results['photo']['matches']) : 0;
$results['video'] = SphinxSearch::search($q, 'levichev_video_index')->setMatchMode($sphinx_match_mode)->query();
$results_counts['video'] = isset($results['video']['matches']) ? count($results['video']['matches']) : 0;

#Helper::ta($results);
#Helper::tad($results_counts);

/**
* Собираем dicval_id для получения одним запросом
*/
$dicvals_ids = array_unique(array_merge( @(array)array_keys($results['news']['matches']), @(array)array_keys($results['photo']['matches']), @(array)array_keys($results['video']['matches']) ));
#Helper::d($dicvals_ids);


/**
* Получаем все найденные значения DicVal одним запросом
*/
$dicvals = NULL;
if (count($dicvals_ids)) {
    $dicvals = DicVal::whereIn('id', $dicvals_ids)->get();
    $dicvals->load('dic', 'meta', 'fields', 'textfields');
    $dicvals = DicVal::extracts($dicvals, null, 1, 1);
    $dicvals = DicLib::loadImages($dicvals, ['image']);
    $dicvals = DicLib::loadGallery($dicvals, ['gallery']);
} else {
#    $dicvals = array();
}
#$dicvals = DicLib::extracts($dicvals, null, 1, 1);
#Helper::tad($dicvals);

$excerpts = array();

/**
 * Поисковые подсказки - projects
 */
if (count(array_keys($results['news']['matches']))) {
    $docs = array();
    foreach (array_keys($results['news']['matches']) as $dicval_id) {
        $dicval = $dicvals[$dicval_id];
        $line = Helper::multiSpace(strip_tags($dicval->name)) . "\n" . Helper::multiSpace(strip_tags($dicval->content)) . "\n" . Helper::multiSpace(strip_tags($dicval->preview));
        $docs[$dicval_id] = trim($line);
    }
    #Helper::d($docs);
    $excerpts['news'] = Helper::buildExcerpts($docs, 'levichev_news_index', $q, array('before_match' => '<mark>', 'after_match' => '</mark>'));
} else {
    $excerpts['news'] = array();
}
#Helper::dd($excerpts);

?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Поиск</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="main-content">
        <div class="container_12">
            <div class="search-block">
                <div class="grid_12">
                    <div class="search-input-cont">
                        <form action="{{ URL::route('page', 'search') }}" method="GET">
                            <input class="us-input" name="q" value="{{ Input::get('q') }}">
                            <button class="search-btn"></button>
                        </form>
                    </div>
                    <div class="search-stat">Вы искали «<b>{{ Input::get('q') }}</b>». Найдено документов: <b>{{ array_sum($results_counts) }}</b></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="search-results">
                <div class="grid_8">
                    <div class="min-title">&nbsp;</div>
                    @if (count($results['news']['matches']))
                        <ul class="main-feed">
                            @foreach ($results['news']['matches'] as $new_id => $null)
                                <?
                                $new = isset($dicvals[$new_id]) ? $dicvals[$new_id] : null;
                                if (is_null($new))
                                    continue;
                                ?>
                                <li class="feed-item">
                                    <div class="search-info">
                                        <span class="info-type">Новости</span>
                                        <span class="info-date">{{ Helper::rdate('j M Y', $new->published_at) }}</span>
                                    </div>
                                    <a href="{{ URL::route('app.new', $new->slug) }}" class="feed-title">{{ $new->name }}</a>
                                    <div class="feed-desc">{{ @$excerpts['news'][$new_id] }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="grid_4">
                <div class="min-title">&nbsp;</div>
                <ul class="album-list search-albums">
                    @if (@count($results['photo']['matches']))
                        @foreach ($results['photo']['matches'] as $photo_id => $null)
                            <?
                            $photo = isset($dicvals[$photo_id]) ? $dicvals[$photo_id] : null;
                            if (is_null($photo))
                                continue;
                            #Helper::ta($photo);
                            ?>
                            <li class="album-item photo-item"><a href="{{ URL::route('app.gallery', $photo->id) }}" style="background-image: url({{ is_object($photo->image) ? $photo->image->thumb() : '' }})" class="album-photo"></a>
                                <div class="album-info">
                                    <div class="info-date"><span class="info-type">Фото</span><span>{{ Helper::rdate('j M Y', $photo->created_at) }}</span></div>
                                    <div class="info-title"><a href="{{ URL::route('app.gallery', $photo->id) }}" class="title-link">{{ $photo->name }}</a></div>
                                    @if (isset($photo->gallery) && is_object($photo->gallery) && isset($photo->gallery->photos) && is_object($photo->gallery->photos))
                                        <div class="info-amount">{{ count($photo->gallery->photos) }} фото</div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @endif

                    @if (@count($results['video']['matches']))
                        @foreach ($results['video']['matches'] as $video_id => $null)
                            <?
                            $video = isset($dicvals[$video_id]) ? $dicvals[$video_id] : null;
                            if (is_null($video))
                                continue;
                            $embed_link = str_replace('/watch?v=', '/embed/', $video->youtube_link);
                            ?>
                            <li class="album-item video-item"><a href="{{ $embed_link }}" style="background-image: url({{ is_object($video->image) ? $photo->image->thumb() : '' }})" class="js-fancybox album-photo fancybox.iframe"></a>
                                <div class="album-info">
                                    <div class="info-date"><span class="info-type">Видео</span><span>{{ Helper::rdate('j M Y', $video->created_at) }}</span></div>
                                    <div class="info-title"><a href="{{ $embed_link }}" class="title-link">{{ $video->name }}</a></div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

@stop


@section('scripts')
@stop