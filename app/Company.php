<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'email', 'logo', 'website'
    ];

    public $timestamps = true;

	public function employee()
	{
	    return $this->hasOne(Employee::class);
	}
}
