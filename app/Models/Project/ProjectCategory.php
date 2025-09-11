<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = [
        'type_id',
        'name',
    ];

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
