<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable()->index(); // nullable para convidados (criados após pagamento)
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();

            $table->string('plan_slug')->nullable(); // redundante, mas útil para histórico
            $table->string('stripe_id')->nullable();
            $table->string('transaction_id')->nullable(); // caso use outro gateway
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status', 50)->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
