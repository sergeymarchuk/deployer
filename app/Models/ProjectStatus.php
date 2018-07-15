<?php namespace App\Models;

use Illuminate\Database\Eloquent\{SoftDeletes, Model};

/**
 * Class ProjectStatus
 *
 * @package App
 * @property string $title
*/
class ProjectStatus extends Model
{
    use SoftDeletes;

    /**
     * @var string $table
     */
    protected $table = 'project_statuses';

    /**
     * @var array $fillable
     */
    protected $fillable = ['title'];
}