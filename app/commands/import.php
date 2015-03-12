<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class import extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Очистка';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->tbls_material = [
            '7_material_004',
            '7_material_005',
            '7_material_006',
        ];
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
        /**
         *
         * artisan import --type=photo
         *
         */

        $type = $this->option('type');
        if (!$type) {

            $this->info('Select type for import');
            $this->info('For example: php artisan.php import --type=photo');
            die;

        } elseif (!method_exists($this, 'import_' . $type)) {

            $this->info('Illegal type: ' . $type);
            die;
        }


        $this->info('IMPORT :: ' . $type);
        $this->info("Start work...");

        $method = 'import_' . $type;
        $this->$method();

        $this->info("Finish work.");
	}



    protected function import_news() {

        foreach ($this->tbls_material as $tbl) {

            $model = (new BaseModel())->on('levichev_old')->getModel();
            $model->setTable($tbl);

            $result = $model->where('section_id', '11')->where('swtch', 'o')->orderBy('date1', 'ASC')->get();
            #Helper::ta($result);

            foreach ($result as $res) {

                #Helper::tad($res);

                $date = mb_substr($res->date1, 0, 10);

                if ($date < '2013-01-01')
                    continue;

                $image = NULL;
                if ($res->privileged_pict)
                    $image = 'http://data.spravedlivo.ru/depot/pict/' . mb_substr($res->privileged_pict, 0, 3) . '/' . $res->privileged_pict;

                $array = [
                    'id' => $res->id,
                    'title' => $res->title,
                    'published_at' => $date,
                    'preview' => $res->descr,
                    'content' => $res->body,
                    'image' => $image,
                ];

                $this->info(implode(' | ', $array));

                #die;

                ## Загрузка картинки по урл
                $photo = NULL;
                if ($image)
                    $photo = Photo::upload($array['image']);

                ## Вставка записи в словарь
                DicVal::inject('news', [
                    'slug' => Helper::translit($array['title']),
                    'name' => $array['title'],
                    'fields' => [
                        'image' => is_object($photo) ? $photo->id : '',
                        'published_at' => $array['published_at'],
                    ],
                    'textfields' => [
                        'preview' => $array['preview'],
                        'content' => $array['content'],
                    ],
                ]);

                break(2);
            }

            unset($model);
        }
        unset($model);

        return true;
    }




	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			#array('example', InputArgument::REQUIRED, 'An example argument.'),
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
    protected function getOptions() {
        return [
            #array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
            ['type', null, InputOption::VALUE_OPTIONAL, 'Only email option.', null],
        ];
    }

}
