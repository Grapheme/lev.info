<?
/**
 * TITLE: Биография - Публикации
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
$publications = Dic::valuesBySlug('publications', function($query) {
    $query->filter_by_field(DB::raw("'published_at'"), '<=', date('Y-m-d'));
    $query->order_by_field('published_at', 'DESC');
}, ['fields', 'textfields'], true, true, false);
$publications = DicLib::loadImages($publications, 'image');
#Helper::tad($publications);

$books = Dic::valuesBySlug('books', function($query) {
    $query->where('created_at', '<=', date('Y-m-d H:i:s'));
    #$query->orderBy('created_at', 'DESC');
    $query->orderBy('lft', 'DESC');
}, ['fields', 'textfields'], true, true, false);
$books = DicLib::loadImages($books, 'image');
$books = DicLib::loadFiles($books, 'file');
#Helper::tad($books);
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="h1-cont">
        <div class="container_12">
            <div class="grid_12">
                <h1>Биография</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="bio">
        <div class="container_12">
            <div class="grid_12">
                <div class="bio-title">{{ $page->block('description', 'name') }}</div>
                <div class="bio-desc">
                    {{ $page->block('description') }}
                </div>

                {{ Menu::placement('biography_menu') }}

            </div>
            <div class="clearfix"></div>
            <ul class="bio-tabs">
                <li data-tab="press" class="tab-item press-tab">
                    <div class="grid_8">
                        <div class="min-title">Публикации в прессе</div>
                        @if (isset($publications) && is_object($publications) && $publications->count())
                            <ul class="press-ul">
                                @foreach ($publications as $publication)
                                    <li class="press-li">
                                        <div class="press-cont"><a href="{{ $publication->link ?: '#' }}" class="press-image"><img src="{{ is_object($publication->image) ? $publication->image->thumb() : '' }}"></a>
                                            <div class="press-info">
                                                <div class="press-date">{{ Helper::rdate('j M Y', $publication->published_at) }}</div><a href="{{ $publication->link ?: '#' }}" class="press-title">{{ $publication->name }}</a>
                                                <div class="upper-title">{{ $publication->source }}</div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="grid_4">
                        <div class="min-title">Книги</div>
                        @if (isset($books) && is_object($books) && $books->count())
                            <ul class="books-ul">
                                @foreach ($books as $book)
                                    <?
                                    $link = '#';
                                    if (is_object($book->file) && $book->file->id) {
                                        $link = $book->file->path;
                                    } elseif ($book->link) {
                                        $link = $book->link;
                                    }
                                    ?>
                                    <li class="books-li"><a href="{{ $link }}" class="book-image"><img src="{{ is_object($book->image) ? $book->image->thumb() : '' }}"></a>
                                        <div class="book-info"><a href="{{ $link }}" class="book-title">{{ $book->name }}</a>
                                            <div class="book-desc">{{ nl2br($book->description) }}</div>
                                            @if (isset($book->file) && is_object($book->file) && $book->file->id)
                                                <a href="{{ $link }}" class="book-type">PDF ({{ ceil(($book->file->filesize)/1024) }} кB.)</a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>

@stop


@section('scripts')
@stop