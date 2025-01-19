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
        Schema::create('email_account_providers', function (Blueprint $table) {
            $table->id();
            $table->string('applicationname');
            $table->string('host');
            $table->unsignedSmallInteger('port');
            $table->string('encryption')->nullable();
            $table->string('from');
            $table->string('fromname');
            $table->string('username');
            $table->string('password');
            $table->boolean('default')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_account_providers');
    }
};
