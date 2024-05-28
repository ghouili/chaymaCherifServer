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
        Schema::create('demande', function (Blueprint $table) {
            $table->id();
            $table->string('annee');
            $table->string('status')->default('En cour');
            $table->string('description');
            $table->string('type');
            $table->float('montant');
            $table->unsignedBigInteger('id_budget');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_budget')->references('id')->on('budget')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande');
    }
};
