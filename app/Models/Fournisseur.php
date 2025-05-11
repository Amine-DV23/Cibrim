<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'address', 'user_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
