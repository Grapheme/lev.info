<?php

class Photo extends Eloquent {

	protected $guarded = array();

	protected $table = 'photos';

	public static $order_by = 'photos.id DESC';

	public function thumb() {
		#return link::to(Config::get('site.galleries_thumb_dir')) . "/" . $this->name;
		return URL::to(Config::get('site.galleries_thumb_public_dir') . "/" . $this->name);
	}

	public function full() {
		return $this->path();
	}

	public function path() {
		#return link::to(Config::get('site.galleries_photo_dir')) . "/" . $this->name;
		return URL::to(Config::get('site.galleries_photo_public_dir') . "/" . $this->name);
	}

    public function fullpath() {
        #return link::to(Config::get('site.galleries_photo_dir')) . "/" . $this->name;
        return str_replace('//', '/', public_path(Config::get('site.galleries_photo_public_dir') . "/" . $this->name));
    }

    public function extract() {
        return $this;
    }

	public function cachepath($w, $h, $method = 'crop') {
		return URL::to(Config::get('site.galleries_cache_public_dir') . "/" . $this->id . "_" . $w . "x" . $h . ($method == 'resize' ? 'r' : '') . ".png");
	}

	public function fullcachepath($w, $h, $method = 'crop') {
		return str_replace('//', '/', public_path(Config::get('site.galleries_cache_public_dir') . "/" . $this->id . "_" . $w . "x" . $h . ($method == 'resize' ? 'r' : '') . ".png"));
	}



    public static function upload($url, $gallery = NULL) {

        $img_data = @file_get_contents($url);
        if (!$img_data)
            return false;

        $tmp_path = storage_path(md5($url));
        file_put_contents($tmp_path, $img_data);
        #$file = (new Symfony\Component\HttpFoundation\File\File($tmp_path));
        $file = (new \Symfony\Component\HttpFoundation\File\UploadedFile($tmp_path, basename($url)));

        ## Check upload & thumb dir
        $uploadPath = Config::get('site.galleries_photo_dir');
        $thumbsPath = Config::get('site.galleries_thumb_dir');

        if(!File::exists($uploadPath))
            File::makeDirectory($uploadPath, 0777, TRUE);
        if(!File::exists($thumbsPath))
            File::makeDirectory($thumbsPath, 0777, TRUE);

        ## Generate filename
        $fileName = time() . "_" . rand(1000, 1999) . '.' . $file->getClientOriginalExtension();

        echo $fileName;
        @unlink($tmp_path);
        die;
    }

}