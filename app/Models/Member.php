<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	/** @use HasFactory<MemberFactory> */
	use HasFactory;

	protected $fillable = [
		'first_name',
		'last_name',
		'national_code',
		'birth_date',
		'phone',
	];

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}
}
