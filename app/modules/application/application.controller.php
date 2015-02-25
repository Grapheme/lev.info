<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/news/{slug}', array('as' => 'app.new', 'uses' => __CLASS__.'@getAppNew'));
            Route::get('/gallery/{slug}', array('as' => 'app.gallery', 'uses' => __CLASS__.'@getAppGallery'));
        });
    }


    /****************************************************************************/


	public function __construct(){
        #
	}


    public function getAppNew($slug) {

        $new = Dic::valueBySlugs('news', $slug, ['fields', 'textfields'], true, true, false, 2);
        $new = DicLib::loadImages($new, 'image');
        #Helper::smartQueries(1);
        #Helper::tad($new);

        return View::make(Helper::layout('news_one'), compact('new', 'slug'));
    }


    public function postSendMessage() {

        #
    }


    public function postArchitectsCompetition() {

        #
    }

}