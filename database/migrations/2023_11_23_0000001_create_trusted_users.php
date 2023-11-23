
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trusted_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('trusted_devices');
    }
};
