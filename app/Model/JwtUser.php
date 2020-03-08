<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class JwtUser extends Authenticatable implements JWTSubject
{

    protected $table="users";
    // Rest omitted for brevity
    protected $fillable = ['name', 'password','email'];
    protected $hidden = ['password', 'remember_token'];
    //
    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
        // TODO: Implement getJWTCustomClaims() method.
    }


    public function getmenus($id){
       $auth = $this->join("roles","users.role_id","=",'roles.id')->select("roles.auth")->get();
       $auth = $auth[0]['auth'];
        return  Menu::whereIn('id',explode(',',$auth))->get();
    }

/*    public function allowedUrl($id){
        $auth = $this->join("roles","users.role_id","=",'roles.id')->select("roles.auth")->get();
        $auth = $auth[0]['auth'];
        $data =  Menu::whereIn('id',explode(',',$auth))->pluck('url')->toarray();
        $arrs = [];
        foreach ($data as $k => $v){
            $arrs[$k] = "api/jwt/".$v;
        }
        return $arrs;
    }*/

}
