<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PingServer
 * 
 * @property int $id
 * @property Carbon $date_time
 * @property int $device_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Device $device
 *
 * @package App\Models
 */
class PingServer extends Model
{
	protected $table = 'ping_servers';

	protected $casts = [
		'date_time' => 'datetime',
		'device_id' => 'int'
	];

	protected $fillable = [
		'date_time',
		'device_id'
	];

	public function device()
	{
		return $this->belongsTo(Device::class);
	}
}
