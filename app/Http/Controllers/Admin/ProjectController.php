<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\admin\AuthNeed;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::latest()->first();
        return view('admin.welcome', compact('project'));

    }
    public function update()
    {
        $project = Project::latest()->first();
        return view('admin.project', compact('project'));

    }

    public function create()
    {
        return view('admin.project');
    }

    public function edit(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:50',
            'url' => 'nullable|url',
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('admin.project.index')->with('success', 'Project detail updated successfully.');
    }
}
