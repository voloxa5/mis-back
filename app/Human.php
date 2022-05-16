<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed surname
 * @property mixed patronymic
 * @property mixed sex_id
 * @property mixed id
 * @property mixed dob
 * @property mixed info
 */
class Human extends Model
{
    protected $fillable = array('name', 'surname', 'patronymic', 'sex_id', 'dob', 'info');

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function basicPhoto()
    {
        $result = $this->HasOneThrough(
            Photo::class,
            HumanPhoto::class,
            'human_id',
            'id',
            'id',
            'photo_id',
        )->where('is_basic', '=', 1);

        return $result;
    }
}
