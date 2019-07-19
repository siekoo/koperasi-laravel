<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
	        $table->date('joined_at');
	        $table->softDeletes();

	        $table->string('number');
	        $table->string('fullname');
	        $table->string('father_name');
	        $table->string('grandfather_name');
	        $table->enum('gender', array('M', 'F'));
	        $table->string('job');
	        $table->string('phone');
	        $table->string('birth_place');
	        $table->date('birth_date');

	        $table->string('address');
	        $table->string('dusun');
	        $table->string('desa');
	        $table->integer('kecamatan');
	        $table->integer('kabkot');
			$table->integer('provinsi');

	        $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
