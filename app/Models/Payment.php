<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	/** @use HasFactory<PaymentFactory> */
	use HasFactory;

	protected $fillable = [
		'member_id',
		'amount',
		'date',
	];

	public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(Member::class);
	}
}
