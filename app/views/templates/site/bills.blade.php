<?
/**
 * TITLE: Страница со списком законопроектов
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$options = Dic::valuesBySlugs('options', ['facebook_widget', 'twitter_widget'], ['textfields']);

$bills = Dic::valuesBySlug('bills', function($query) {

    $query->where('created_at', '<=', date('Y-m-d H:i:s'));
    $query->orderBy('created_at', 'DESC');

}, ['fields', 'textfields'], true, true, false, 10);
#$bills = DicLib::loadImages($bills, 'image');
$bills = DicLib::loadFiles($bills, 'file');
#Helper::smartQueries(1);
#Helper::tad($bills);
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Законопроекты</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="main-content">
        <div class="container_12">

            <div class="grid_8">
                <div class="block-title">
                    В настоящем разделе освещается законодательная деятельность депутата Государственной Думы Н. В. Левичева.
                </div>

                @if (isset($bills) && is_object($bills) && $bills->count())
                    <ul class="main-feed">
                        @foreach ($bills as $bill)
                            <li data-law-id="{{ $bill->id }}" class="feed-item js-law-item"><a href="#" class="feed-title js-open-law">{{ $bill->name }}</a>
                                <div class="feed-desc">{{ $bill->short }}</div>
                                <div class="js-tabs-parent">
                                    <ul class="feed-tab-links">
                                        @if ($bill->note)
                                            <li class="js-tab-link"><span>Пояснительная записка</span></li>
                                        @endif
                                        @if ($bill->fulltext)
                                            <li class="js-open-law"><span>Текст законопроекта</span></li>
                                        @endif
                                    </ul>
                                    <ul class="feed-tabs">
                                        @if ($bill->note)
                                            <li class="js-tab">
                                                <div class="tab-desc">
                                                    {{ $bill->note }}
                                                </div>
                                                @if ($bill->meta_info)
                                                    <div class="tab-bottom">
                                                        {{ $bill->meta_info }}
                                                    </div>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{ $bills->appends(Input::all())->links() }}
                @else
                    <div>
                        <br/>
                        Нет записей.
                    </div>
                @endif

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
    <div class="law-overlay js-law-overlay">
        <div class="law-close js-law-close"></div>
        <div class="law-arrow a-left js-law-prev"></div>
        <div class="law-arrow a-right js-law-next"></div>
        @if (isset($bills) && is_object($bills) && $bills->count())
            @foreach ($bills as $bill)

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

            @endforeach
        @endif
    </div>

@stop


@section('scripts')
@stop