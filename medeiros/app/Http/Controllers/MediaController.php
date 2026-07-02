<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('dashboard.admin.media', compact('media'));
    }

    public function upload(Request $request)
    {
        $data = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $file->storeAs('media', $filename, 'public');

        Media::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->route('admin.media')->with('success', 'Imagem enviada com sucesso!');
    }

    public function uploadJson(Request $request)
    {
        $data = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $file->storeAs('media', $filename, 'public');

        $media = Media::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return response()->json([
            'url' => $media->url,
            'id' => $media->id,
            'original_name' => $media->original_name,
        ]);
    }

    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();
        return redirect()->route('admin.media')->with('success', 'Imagem removida!');
    }

    public function libraryList()
    {
        $media = Media::latest()->get()->map(fn($m) => [
            'id' => $m->id,
            'url' => $m->url,
            'original_name' => $m->original_name,
            'size' => $m->size,
        ]);
        return response()->json($media);
    }
}
