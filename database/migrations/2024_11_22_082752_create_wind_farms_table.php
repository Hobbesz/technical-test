<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wind_farms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->double('latitude', 7, 5);
            $table->double('longitude', 8, 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wind_farms');
    }
};
