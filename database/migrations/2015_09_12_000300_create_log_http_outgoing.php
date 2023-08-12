<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_http_outgoing', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('url');
            $table->string('method');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('headers')->nullable();
            $table->string('body')->nullable();
            $table->longText('response')->nullable();

            $table->timestamps();
        });
    }
};
