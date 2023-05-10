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
        Schema::create('rssh_connections', function (Blueprint $table) {
            $table->id();
            $table->string('server_username');
            $table->string('server_password')->nullable();
            $table->string('server_ip');
            $table->string('server_port');
            $table->string('local_port');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('connection_status_id');
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('connection_status_id')->references('id')->on('connection_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rssh_connections');
    }
};
