<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    public function selectuserauth(){
       
        $id = Auth::id();
        return DB::connection('mysql')->select("select * from users where id = ?",[$id]);
   }
   public function updatedo($user_id,$user_name,$user_email,$user_tel){
        $uinxTimeStamp = Carbon::now()->toDateTimeString();
        DB::connection('mysql')->update("UPDATE users SET name = ? , email = ? , tel = ? ,updated_at = ? WHERE id = ?;",[$user_name,$user_email,$user_tel,$uinxTimeStamp,$user_id]);
    }

    public function deleterole($organization_id,$user_id)
    {
        
        DB::connection('mysql')->delete("DELETE FROM user_organization WHERE organization_id = ? AND user_id = ?;",[$organization_id,$user_id]);
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','tel'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
