<?php

namespace Impark\Timestamps;

use Illuminate\Database\Eloquent\Model;

class TimestampsModel extends Model 
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
}
