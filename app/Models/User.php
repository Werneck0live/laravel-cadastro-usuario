<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // protected $table = 'ib_users';

   protected $fillable = [
							'name',
							'email',
							'cpf',
							'telefone',
							'admin',
							'password'
							
						  ];
	// protected $guarded = '_token';
				  
}
