<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillRequest;
use App\Models\Skill;

/**
 * Skill management controller for admin dashboard.
 */
class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index()
    {
        $skills = Skill::displayOrder()->paginate(20);
        $totalSkills = Skill::count();
        $categories = ['backend' => 'Backend', 'frontend' => 'Frontend', 'database' => 'Database', 'devops' => 'DevOps', 'tools' => 'Tools & Architecture'];

        return view('admin.skills.index', compact('skills', 'totalSkills', 'categories'));
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create()
    {
        return view('admin.skills.form', [
            'skill' => new Skill(),
            'editing' => false,
        ]);
    }

    /**
     * Store a newly created skill.
     */
    public function store(SkillRequest $request)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['order'] = $data['order'] ?? 0;

        Skill::create($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill added successfully!');
    }

    /**
     * Show the form for editing the specified skill.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.form', [
            'skill' => $skill,
            'editing' => true,
        ]);
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(SkillRequest $request, Skill $skill)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['order'] = $data['order'] ?? 0;

        $skill->update($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully!');
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill removed successfully!');
    }
}
