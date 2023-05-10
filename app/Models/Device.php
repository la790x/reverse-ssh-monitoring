<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Client $client
 * @property Collection|PingServer[] $ping_servers
 * @property Collection|RsshConnection[] $rssh_connections
 *
 * @package App\Models
 */
class Device extends Model
{
	protected $table = 'devices';

	protected $casts = [
		'client_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'client_id'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function ping_servers()
	{
		return $this->hasMany(PingServer::class);
	}

	public function rssh_connections()
	{
		return $this->hasMany(RsshConnection::class);
	}
}
