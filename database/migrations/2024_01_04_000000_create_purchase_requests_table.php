<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number')->unique(); // no. PR, auto generate

            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->string('unit_kerja')->nullable();
            $table->text('reason'); // alasan pengadaan

            $table->enum('status', [
                'menunggu_persetujuan',
                'disetujui',
                'ditolak',
                'diproses',
                'po_dibuat',
                'barang_diterima',
            ])->default('menunggu_persetujuan');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_note')->nullable(); // catatan persetujuan / alasan penolakan

            $table->timestamps();
        });

        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');
    }
};
