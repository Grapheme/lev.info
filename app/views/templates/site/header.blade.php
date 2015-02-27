<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<header class="main-header">
    <div class="container_12">
        <div class="grid_12">
            <div class="person-info">
                <div class="person-title"><a href="{{ URL::route('mainpage') }}">Николай Левичев</a></div>
                <div class="person-desc"><a href="{{ URL::route('mainpage') }}">Заместитель Председателя Государственной Думы ФС РФ<br>VI созыва</a></div>
            </div>
            <nav class="main-nav">
                {{ Menu::placement('main_menu') }}
            </nav>
            <div class="search-block">
                <form action="{{ URL::route('page', 'search') }}" method="GET">
                    <div class="search-cont">
                        <input placeholder="Поиск по сайту" name="q" value="{{ Input::get('q') }}" class="us-input search-input">
                        <button class="search-btn"></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</header>