<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:table {--table=table_name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts missing translations into spatie fitting translation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table_name = $this->option('table');
        $model = $this->option('model');
        if($model == "all"){
            $path = app_path()."/Models";
            $files = array_diff(scandir($path), array('.', '..'));
            foreach($files as $file){
                $model = explode('.',$file)[0];
                $this->handleTranslations($model);
            }
        }else{
            $this->handleTranslations($model);
        }        

        return 0;
    }

    private function handleTranslations($model){
        $translatable_fields = app("App\\Models\\" . $model)->translatable;
        $table_name = app("App\\Models\\" . $model)->getTable();
        if ($translatable_fields) {
            $data = DB::table($table_name)->select(['id', ...$translatable_fields])->get();

            foreach ($data as $d) {
                $updates = [];
                foreach ($translatable_fields as $name) {
                    if (json_decode($d->$name) == null || gettype(json_decode($d->$name)) == 'integer' || gettype(json_decode($d->$name)) == 'double') {
                        $updates[$name] = json_encode(['en' => $d->$name ?? ""]);
                    }
                }
                if(!empty($updates)){
                    app("App\\Models\\" . $model)->where('id', $d->id)->update($updates);
                }
            }
        }
    }
}
