<?php namespace App\Models;

use Illuminate\Database\Eloquent\{SoftDeletes, Model};

/**
 * Class Project
 *
 * @package App
 * @property string $title
 * @property string $description
 * @property string $project_status
*/
class Project extends Model
{
    use SoftDeletes;

    /**
     * @var string $table
     */
    protected $table = 'projects';

    /**
     * @var array $fillable
     */
    protected $fillable = ['title', 'description', 'project_status_id'];

    /**
     * Set to null if empty
     * @param $input
     */
    public function setProjectStatusIdAttribute($input)
    {
        $this->attributes['project_status_id'] = $input ? $input : null;
    }

    /**
     * @return mixed
     */
    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id')->withTrashed();
    }
}