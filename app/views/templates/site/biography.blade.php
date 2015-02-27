<?
/**
 * TITLE: Биография + Страницы жизни
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
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
                <li data-tab="bio" class="tab-item text-tab">
                    <div class="grid_12">
                        <div class="bio-text">
                            <div>
                                {{ $page->block('content') }}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>

@stop


@section('scripts')
@stop