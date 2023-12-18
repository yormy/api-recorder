<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apiio_http_outgoing', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->integer('status_code');
            $table->string('url');
            $table->string('method');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->longText('headers')->nullable();
            $table->longtext('body')->nullable();
            $table->longText('response')->nullable();

            $table->timestamps();
        });
    }
};
