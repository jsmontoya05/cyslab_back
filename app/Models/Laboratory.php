<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Laboratory
 * @package App\Models
 * @version March 26, 2021, 4:30 pm UTC
 *
 * @property string $name
 * @property json $body
 * maxUsersInLab: 1
name: "aaaaa"
template: ""
usageQuota: "a"
 */
class Laboratory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'laboratories';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'maxUsersInLab',
        'name',
        'template',
        'usageQuota'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'maxUsersInLab'=> 'integer',
        'name' => 'string',
        'template' => 'string',
        'usageQuota' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:55',
        'maxUsersInLab' => 'required|min:1|max:5',
        'template' => '',
        'usageQuota' => 'required|min:1|max:255',
    ];


}
