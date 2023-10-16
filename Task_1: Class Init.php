<?php

/**
 * Для выполнения тестового задания выбран фреймворк Laravel v10.28.0
 *
 */


namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;

Final class Init {

    /**
     * Table name that class Init create.
     *
     * @var string
     */
    const TABLE_NAME = 'test';

    /**
     * The cols (col "id" use as default and does not specified there) ot table TABLE_NAME.
     *
     * @var string
     */
    protected $_resultCol = 'result';
    protected $_firstNameCol = 'firstName';
    protected $_lastNameCol = 'lastName';
    protected $_createdCol = 'created';

    /**
     * The attributes that available for "result" col.
     *
     * @var array<string>
     */
    protected $_resultArray = [
        'error',
        'normal',
        'success',
        'expect',
        'warning',
    ];

    /**
     * The class constructor.
     */
    public function __construct() {
        $this->create();
        $this->fill();
    }

    /**
     * This method creates TABLE_NAME.
     *
     * @return void
     */
    private function create(): void {

        if (Schema::hasTable(self::TABLE_NAME)) {
            Log::error('Таблица ' . self::TABLE_NAME . ' уже существует.');
        } else {
            Schema::create(self::TABLE_NAME, function (Blueprint $table) {
                $table->increments('id');
                $table->string($this->_resultCol);
                $table->string($this->_firstNameCol);
                $table->string($this->_lastNameCol);
                $table->string($this->_createdCol);
            });
        }

    }

    /**
     * Method fills table by any data.
     *
     * @return void
     */

    private function fill(): void {

        foreach ($this->_resultArray as $key) {
            DB::table(self::TABLE_NAME)->insert(
                array(
                    $this->_resultCol => $key,
                    $this->_firstNameCol => 'MyFirstName',
                    $this->_lastNameCol => 'MyLastName',
                    $this->_createdCol => Carbon::now(),
                )
            );
        }

    }

    /**
     * Method get is getting rows from TABLE_NAME by param "result".
     *
     * @return Collection
     */

    public function get(): Collection
    {

        return DB::table(self::TABLE_NAME)
            ->where($this->_resultCol, '=', 'normal')
            ->orWhere($this->_resultCol, '=','success')
            ->get();

    }

}
