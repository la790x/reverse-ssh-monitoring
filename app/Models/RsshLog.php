<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RsshLog
 * 
 * @property int $id
 * @property string $log
 * @property int $rssh_connection_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property RsshConnection $rssh_connection
 *
 * @package App\Models
 */
class RsshLog extends Model
{
	protected $table = 'rssh_logs';

	protected $casts = [
		'rssh_connection_id' => 'int'
	];

	protected $fillable = [
		'log',
		'rssh_connection_id'
	];

	public function rssh_connection()
	{
		return $this->belongsTo(RsshConnection::class);
	}
}
