<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiparisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siparis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sepet_id')->unique();
            $table->decimal('siparis_tutari', 10, 4);
            $table->string('durum', 30)->nullable();

            $table->string('adsoyad', 50)->nullable();
            $table->string('adres', 200)->nullable();
            $table->string('telefon', 15)->nullable();
            $table->string('ceptelefon', 15)->nullable();
            $table->string('banka', 20)->nullable();
            $table->integer('taksit_sayisi')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();

            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siparis');
    }
}
