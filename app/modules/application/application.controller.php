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


    public function postRequestCall() {

        #
    }


    public function postSendMessage() {

        #
    }


    public function postArchitectsCompetition() {

        #
    }

}