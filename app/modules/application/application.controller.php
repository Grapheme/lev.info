<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/news/{slug}', array('as' => 'app.new', 'uses' => __CLASS__.'@getAppNew'));
            Route::get('/gallery/{id}', array('as' => 'app.gallery', 'uses' => __CLASS__.'@getAppGallery'));
            Route::post('/ajax/send-message', array('as' => 'app.send-message', 'uses' => __CLASS__.'@postAjaxSendMessage'));

            Route::any('/ajax/marat/test', array('as' => 'app.marat.test', 'uses' => __CLASS__.'@postAjaxMaratTest'));
        });
    }


    /****************************************************************************/


	public function __construct(){
        #
	}


    public function getAppNew($slug) {

        $new = Dic::valueBySlugs('news', $slug, ['fields', 'textfields'], true, true, false, 2);
        $new = DicLib::loadImages($new, 'image');
        $new = DicLib::loadGallery($new, 'gallery');
        #Helper::smartQueries(1);
        #Helper::tad($new);

        return View::make(Helper::layout('news_one'), compact('new', 'slug'));
    }


    public function getAppGallery($id) {

        $gallery = Dic::valueBySlugAndId('photo', $id, ['fields', 'textfields'], true, true, false, 2);
        $gallery = DicLib::loadImages($gallery, 'image');
        $gallery = DicLib::loadGallery($gallery, 'gallery');
        #Helper::smartQueries(1);
        #Helper::tad($gallery);

        return View::make(Helper::layout('photo_one'), compact('gallery', 'slug'));
    }


    public function postAjaxSendMessage() {

        if(!Request::ajax())
            App::abort(404);

        $json_request = array('status' => TRUE, 'responseText' => '');

        $data = Input::all();

        Mail::send('emails.send-message', $data, function ($message) use ($data) {
            #$message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));

            $from_email = Dic::valueBySlugs('options', 'from_email');
            $from_email = is_object($from_email) ? $from_email->value : 'no@reply.ru';
            $from_name = Dic::valueBySlugs('options', 'from_name');
            $from_name = is_object($from_name) ? $from_name->value : 'No-reply';

            $message->from($from_email, $from_name);
            $message->subject('Сообщение обратной связи');

            #$email = Config::get('mail.feedback.address');
            $email = Dic::valueBySlugs('options', 'email');
            $email = is_object($email) ? $email->value : 'dev@null.ru';

            $emails = array();
            if (strpos($email, ',')) {
                $emails = explode(',', $email);
                foreach ($emails as $e => $email)
                    $emails[$e] = trim($email);
                $email = array_shift($emails);
            }

            $message->to($email);

            #$ccs = Config::get('mail.feedback.cc');
            $ccs = $emails;
            if (isset($ccs) && is_array($ccs) && count($ccs))
                foreach ($ccs as $cc)
                    $message->cc($cc);

            /**
             * Прикрепляем файл
             */
            #/*
            if (Input::hasFile('file') && ($file = Input::file('file')) !== NULL) {
                #Helper::dd($file->getPathname() . ' / ' . $file->getClientOriginalName() . ' / ' . $file->getClientMimeType());
                $message->attach($file->getPathname(), array('as' => $file->getClientOriginalName(), 'mime' => $file->getClientMimeType()));
            }
            #*/

        });

        #Helper::dd($result);
        return Response::json($json_request, 200);
    }


    public function postAjaxMaratTest() {

        cors();
        $data = Input::all();
        #Helper::tad($data);

        if (!@$data['image'])
            return 0;

        $data2 = ['data' => $data];

        Mail::send('emails.marat-test', $data2, function ($message) use ($data) {
            #$message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));

            $from_email = 'support@grapheme.ru';
            $from_name = 'Support';
            $email = 'ma@grapheme.ru';

            $message->from($from_email, $from_name);
            $message->subject('Подпись');
            $message->to($email);

            $tmp = explode(',', $data['image']);
            $img = base64_decode($tmp[1]);
            $message->attachData($img, 'image.png');

            /**
             * Прикрепляем файл
             */
            /*
            if (Input::hasFile('file') && ($file = Input::file('file')) !== NULL) {
                #Helper::dd($file->getPathname() . ' / ' . $file->getClientOriginalName() . ' / ' . $file->getClientMimeType());
                $message->attach($file->getPathname(), array('as' => $file->getClientOriginalName(), 'mime' => $file->getClientMimeType()));
            }
            #*/

        });

        #Helper::dd($result);
        return 1;
    }

}



function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    #echo "You have CORS!";
}