<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    {{ HTML::scriptmod(Config::get('site.theme_path').'/scripts/vendor.js') }}
    {{ HTML::scriptmod(Config::get('site.theme_path').'/scripts/main.js') }}