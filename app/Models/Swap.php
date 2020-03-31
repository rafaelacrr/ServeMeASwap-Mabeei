<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institutional_mail', 'subdomain'
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['administrator'];

    /**
     * Get admin of this Swap instance.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }
}
