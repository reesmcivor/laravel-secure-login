
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trusted_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->smallInteger('attempts')->default(0);
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('notified_at')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('trusted_ips');
    }
};
