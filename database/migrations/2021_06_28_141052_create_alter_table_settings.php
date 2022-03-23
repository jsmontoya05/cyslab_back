<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateAlterTableSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if(env('DB_CONNECTION') === 'mysql'){
            DB::statement('ALTER TABLE settings MODIFY logo LONGBLOB;');
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') === 'mysql') {
            DB::statement('ALTER TABLE settings MODIFY logo BLOB;');
        }
    }
}
