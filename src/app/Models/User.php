<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function learnableSkills()
    {
        return $this->belongsToMany(Skill::class, 'learnable_skills', 'user_id', 'skill_id');
    }

    public function teachableSkills()
    {
        return $this->belongsToMany(Skill::class, 'teachable_skills', 'user_id', 'skill_id');
    }

    /**
     * Configure learnable skills for the user.
     *
     * @return void
     */
    public function configureLearnableSkills()
    {
        // ユーザーが学びたいスキルを中間テーブルに関連付ける
        $learnableSkills = Skill::all()->random(rand(1, 8));
        $this->learnableSkills()->sync($learnableSkills);
    }

    /**
     * Configure teachable skills for the user.
     *
     * @return void
     */
    public function configureTeachableSkills()
    {
        // ユーザーが教えられるスキルを中間テーブルに関連付ける
        $teachableSkills =  Skill::all()->random(rand(1, 8));
        $this->teachableSkills()->sync($teachableSkills);
    }

}
