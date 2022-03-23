<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Setting
 * @package App\Models
 * @version June 23, 2021, 12:03 pm -05
 *
 * @property string $main_color
 * @property string $text_color
 * @property string $logo
 * @property string $ip_check_middleware
 * @property integer $active
 */
class Setting extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'settings';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'main_color',
        'text_color',
        'logo',
        'ip_check_middleware',
        'route_spa_application',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'main_color' => 'string',
        'text_color' => 'string',
        'logo' => 'string',
        'ip_check_middleware' => 'string',
        'route_spa_application' =>'string',
        'active' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'main_color'           => 'min:2|max:50',
        'text_color'           => 'min:2|max:50',
        'logo'                 => 'image|mimes:png|max:2048',
        'ip_check_middleware'  => 'required|min:2|max:255',
        'route_spa_application'=> 'required|min:2|max:255',
        'active'               => 'required'
    ];

    
}
