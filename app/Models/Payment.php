<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Atributos permitidos para atribuição em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'plan_id',

        // Mercado Pago
        'mp_payment_id',
        'external_reference',
        'transaction_id',
        'payment_method',
        'amount',
        'status',
    ];

    /**
     * Um pagamento pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um pagamento pertence a um plano.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
