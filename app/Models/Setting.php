<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
	use HasFactory;

	protected $fillable = [
		'key',
		'value',
		'group',
	];

	 // Get raw value
    public static function get($key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    // Set raw value
    public static function set($key, $value, $group = 'cms')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

	   // Get JSON value
    public static function getJson($key, $default = [])
    {
        $value = static::get($key);

        if (!$value) return $default;

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $default;
    }

    // Set JSON value
    public static function setJson($key, $value, $group = 'cms')
    {
        return static::set($key, json_encode($value), $group);
    }
}


