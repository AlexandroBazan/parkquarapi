<?php

namespace Impark\Filter\test;

use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model 
{
	protected $table = 'timestamps';

	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'user_id', 'type', 'app_id', 'ip'
    ];


    public function toArray($options = 0) {
        return parent::toArray();
    }
}
