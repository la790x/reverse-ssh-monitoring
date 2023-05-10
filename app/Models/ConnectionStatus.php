<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConnectionStatus
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|RsshConnection[] $rssh_connections
 *
 * @package App\Models
 */
class ConnectionStatus extends Model
{
	protected $table = 'connection_statuses';

	protected $fillable = [
		'name'
	];

	public function rssh_connections()
	{
		return $this->hasMany(RsshConnection::class);
	}
}
