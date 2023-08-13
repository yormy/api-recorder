<?php

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
        Schema::create('log_http_incoming', function (Blueprint $table) {
            $table->id();
            $table->integer('status_code');
            $table->string('url');
            $table->string('method');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->longText('headers')->nullable();
            $table->longText('body')->nullable();
            $table->longText('body_raw')->nullable();
            $table->longText('response')->nullable();
            $table->string('response_headers')->nullable();
            $table->string('duration');
            $table->string('controller');
            $table->string('action');
            $table->string('models_retrieved');
            $table->string('from_ip');
            $table->timestamps();
        });
    }
};
