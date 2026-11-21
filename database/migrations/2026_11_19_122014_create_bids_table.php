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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel projects
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // Relasi ke tabel users sebagai developer
            $table->foreignId('developer_id')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->unsignedBigInteger('harga');

            $table->unsignedInteger('durasi');

            $table->text('proposal');

            $table->boolean('is_winner')->default(false);

            // Mencegah developer menawar proyek yang sama dua kali
            $table->unique(
                ['project_id', 'developer_id'],
                'uq_project_developer'
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
