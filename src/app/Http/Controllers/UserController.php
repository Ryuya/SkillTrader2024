<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        // プロフィール情報を返す
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'learnable_skills' => $user->learnable_skills,
            'teachable_skills' => $user->teachable_skills,
        ]);
    }

    public function edit(Request $request)
    {
        // \Log::info($request->all());
        $user = User::find($request->id);
        \Log::info($user);
        // 名前とメールアドレスの更新
        $user->name = $request->name;
        $user->email = $request->email;
    
        // 学びたいスキルの名前の配列を抽出
        $learnableSkillNames = array_column($request->learnable_skills, 'name');
        // 学びたいスキルIDの配列を取得
        $learnableSkillIds = Skill::whereIn('name', $learnableSkillNames)->pluck('id')->toArray();
        // 学びたいスキルを同期
        $user->learnableSkills()->sync($learnableSkillIds);
    
        // 教えたいスキルの名前の配列を抽出
        $teachableSkillNames = array_column($request->teachable_skills, 'name');
        // 教えたいスキルIDの配列を取得
        $teachableSkillIds = Skill::whereIn('name', $teachableSkillNames)->pluck('id')->toArray();
        // 教えたいスキルを同期
        $user->teachableSkills()->sync($teachableSkillIds);
    
        $user->save();
    
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'learnable_skills' => $user->learnableSkills()->get()->pluck('name'),
            'teachable_skills' => $user->teachableSkills()->get()->pluck('name'),
        ]);
    }
}