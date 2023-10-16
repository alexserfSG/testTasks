<?php
 /**
 * Для выполнения тестового задания выбран фреймворк Laravel v10.28.0
 *
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{

    /**
    * Path of dirname where search is doing.
    *
    * @var string
     */
    const DATA_FILES_DIR = '/datafiles';

    /**
     * Method find all files with ".ixt" extension and show it sort by ASC.
     */
    public function get()
    {

        $files = scandir(self::DATA_FILES_DIR);
        $res = [];

        foreach ($files as $file) {

            # Также можно по-простому "/^[0-9A-Za-z]{1,50}\.ixt$/" .
            if (preg_match_all("/[[:alnum:]]{1,50}\.ixt$/",$file)) {
                $res[] = strtolower($file);
            }
        }

        if (!count($res)) {
            Log::error('Совпадения в имени файлов не найдены.');
            return false;
        }

        # Сортируем по алфавиту
        sort($res);

        return view('search')->with('files',$res);
    }
}

/**
 * Файл шаблона Search - search.blade.php
 *
 */

<ul>
    @foreach($files as $file)
        <li>{{$file}}</li>
    @endforeach
</ul>


