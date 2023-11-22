<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth:sanctum')->except(['index', 'show']); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->paginate(3);

        return new ProjectResource(true, 'List Project', $projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('if_admin');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required',
            'desc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        
        $project = Project::create([
            'title' => $request->title,
            'image' => $uploadedFile,
            'url' => $request->url,
            'desc' => $request->desc
        ]);

        return new ProjectResource(true, 'Project Berhasil Ditambahkan', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return new ProjectResource(true, 'Detail Project', $project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('if_admin');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required',
            'desc' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {

            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

            //update post with new image
            $project->update([
                'image' => $uploadedFile,
                'title'     => $request->title,
                'url'   => $request->url,
                'desc'   => $request->desc,
            ]);

        } else {

            //update post without image
            $project->update([
                'title'     => $request->title,
                'url'   => $request->url,
                'desc'   => $request->desc,
            ]);
        }

        return new ProjectResource(true, 'Project Berhasil Diupdate', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('if_admin');
        
        $project->delete();

        return new ProjectResource(true, 'Project Berhasil Dihapus', null);
    }

}
