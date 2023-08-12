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
            $table->string('headers')->nullable();
            $table->string('body')->nullable();
            $table->longText('response')->nullable();
            $table->longText('response_headers')->nullable();
            $table->string('duration');
            $table->longText('payload');
            $table->longText('payload_raw')->nullable();

            $table->string('controller');
            $table->string('action');
            $table->string('models');
            $table->string('ip');
            $table->timestamps();
        });
    }
};
