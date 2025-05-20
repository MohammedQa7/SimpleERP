<?php

namespace App\Http\Controllers;

use App\Enums\FolderApperanceStatus;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folder = Folder::withCount('subFolders')
            ->whereNull('parent_id')->get();
        return Inertia::render('FileManager/Index', [
            'folders' => FolderResource::collection($folder),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FolderRequest $request)
    {
        Folder::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'visibility' => $request->visibility,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        $folder->load('subFolders.parentFolder', 'parentFolder.parentFolder');

        return Inertia::render('FileManager/SingleFolder', [
            'folder' => new FolderResource($folder),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}