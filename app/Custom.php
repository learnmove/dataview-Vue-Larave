<?php

namespace App;
use App\Helper\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use DataViewer;
    protected $fillable=['name','phone','email'];
    protected $table='customs';
    public static $columns=['id','name','email','phone','created_at','updated_at'];
    //
}
