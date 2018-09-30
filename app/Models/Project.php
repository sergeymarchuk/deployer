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
    protected $fillable = ['title', 'path', 'project_status_id', 'deployed_at', 'webhook', 'hash', 'slug'];

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
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'users_has_projects');
    }
}