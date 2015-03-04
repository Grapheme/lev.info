<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?
$options = Dic::valuesBySlugs('options', ['facebook_link', 'twitter_link', 'footer_contacts'], ['textfields']);
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
            @if (isset($options['footer_contacts']) && is_object($options['footer_contacts']) && $options['footer_contacts']->value)
                <div class="footer-contacts">
                    {{ nl2br($options['footer_contacts']->value) }}
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
                @if (isset($options['twitter_link']) && is_object($options['twitter_link']) && $options['twitter_link']->value)
                    <li><a href="{{ $options['twitter_link']->value }}" class="soc-twitter"></a></li>
                @endif
                @if (isset($options['facebook_link']) && is_object($options['facebook_link']) && $options['facebook_link']->value)
                    <li><a href="{{ $options['facebook_link']->value }}" class="soc-facebook"></a></li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</footer>