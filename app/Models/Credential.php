<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Credential
 * @package App\Models
 * @version March 26, 2021, 4:29 pm UTC
 *
 * @property string $name
 * @property json $body
 */
class Credential extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'credentials';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'client_id',
        'client_secret',
        'resource',
        'grant_type',
        'subscription_id',
        'tenant',
        'resource_group',
        'redirect_uri',
        'role_group',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'client_id'         => 'string',
        'client_secret'     => 'string',
        'resource'          => 'string',
        'grant_type'        => 'string',
        'subscription_id'   => 'string',
        'tenant'            => 'string',
        'resource_group'    => 'string',
        'redirect_uri'      => 'string',
        'role_group'        => 'string',
        'active'            => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'client_id'         => 'required|min:2|max:255',
        'client_secret'     => 'required|min:2|max:255',
        'resource'          => 'required|min:2|max:255',
        'grant_type'        => 'required|min:2|max:255',
        'subscription_id'   => 'required|min:2|max:255',
        'tenant'            => 'required|min:2|max:255',
        'resource_group'    => 'required|min:2|max:255',
        'redirect_uri'      => 'required|min:2|max:255',
        'role_group'        => 'required|min:2|max:255',
        'active'            => 'required'
    ];


}
