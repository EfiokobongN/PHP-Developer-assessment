<?php

use App\Models\Apikey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apikeys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->integer("is_expired")->default(0);
            $table->timestamps();
        });

        $apiToken = new Apikey();
        $apiToken->name = 'SystemAccessToken';
        $apiToken->key = 'dMNOcdMNOPefFGHIlefFGHIJKLmno';
        $apiToken->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apikeys');
    }
};
