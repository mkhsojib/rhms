<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'is_public',
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key
     */
    public static function setValue($key, $value)
    {
        $setting = static::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            static::create([
                'key' => $key,
                'value' => $value,
                'type' => 'text',
                'group' => 'general',
                'label' => ucfirst(str_replace('_', ' ', $key)),
            ]);
        }
        
        return $setting;
    }

    /**
     * Get all settings grouped by their group
     */
    public static function getGrouped()
    {
        return static::orderBy('group')->orderBy('label')->get()->groupBy('group');
    }

    /**
     * Get settings by group
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)->orderBy('label')->get();
    }

    /**
     * Get public settings
     */
    public static function getPublic()
    {
        return static::where('is_public', true)->pluck('value', 'key');
    }
}
