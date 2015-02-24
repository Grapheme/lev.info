<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?
$contacts = Dic::valueBySlugs('options', 'footer_contacts', ['textfields']);
$facebook_link = Dic::valueBySlugs('options', 'facebook_link', ['textfields']);
$twitter_link = Dic::valueBySlugs('options', 'twitter_link', ['textfields']);
?>
<footer class="main-footer">
    <div class="container_12">
        <div class="grid_12">
            <ul class="footer-ul">
                <li>
                    <div class="ul-image"></div>
                    <a href="#" class="ul-text">Партия Справедливая Россия</a>
                </li>
                <li>
                    <div class="ul-image"></div>
                    <a href="#" class="ul-text">Палата депутатов партии Справедливая Россия</a>
                </li>
            </ul>
            @if (isset($contacts) && is_object($contacts) && $contacts->value)
                <div class="footer-contacts">
                    {{ nl2br($contacts->value) }}
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="grid_12 footer-bottom">
            <div class="footer-desc">© 2008-{{ date('Y') }}, Официальный сайт Николая Левичева, депутата Государственной Думы
                Федерального Собрания РФ VI созыва, Заместителя Председателя Государственной Думы РФ от фракции
                СПРАВЕДЛИВАЯ РОССИЯ, Председателя Совета Палаты депутатов Партии СПРАВЕДЛИВАЯ РОССИЯ.
            </div>
            <ul class="footer-soc">
                @if (isset($twitter_link) && is_object($twitter_link) && $twitter_link->value)
                    <li><a href="{{ $twitter_link->value }}" class="soc-twitter"></a></li>
                @endif
                @if (isset($facebook_link) && is_object($facebook_link) && $facebook_link->value)
                    <li><a href="{{ $facebook_link->value }}" class="soc-facebook"></a></li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</footer>