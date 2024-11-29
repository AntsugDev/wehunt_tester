<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = [
      "name",
      "label"
    ];

    /**
     * @throws \Exception
     */
    public static function getRoot (){
        $role = self::where('name','=','root')->get()->pluck('id')->toArray();
        if(count($role) > 0) return $role[0];
        else throw new \Exception("Role not found",404);
    }

    /**
     * @throws \Exception
     */
    public static function getGuest (){
        $role = self::where('name','=','guest')->get()->pluck('id')->toArray();
        if(count($role) > 0) return $role[0];
        else throw new \Exception("Role not found",404);
    }
}
