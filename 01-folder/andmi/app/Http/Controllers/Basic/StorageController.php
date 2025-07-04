<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\File\File;
use Illuminate\Http\Request;
use ZipArchive;

class StorageController extends Controller
{
    public function download(Request $request)
    {
        $uuid = $request->query('uuid');
        $file = File::where('uuid', $uuid)->first();

        return response()->download(storage_path('app/public/' . $file->path), $file->name);
    }

    public function zip(Request $request)
    {
        $name = $request->input('name');
        $uuids = $request->input('uuids', []);
        $files = File::whereIn('uuid', $uuids)->get();

        if ($files->isEmpty()) {
            return response()->json(['error' => 'No valid files found'], 404);
        }

        $zip = new ZipArchive();
        $path = storage_path('app/public/archives');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $prefix = now()->format('Y-m-d');
        $zip_name = $path . '/' . $prefix . '-' . $request->user()->id . '-' . $name . '.zip';

        if ($zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $i = 1;

            foreach ($files as $file) {
                $path = storage_path('app/public/' . $file->path);
                $name = $prefix . '-' . $i . '-' . $file->name;

                $zip->addFile($path, $name);

                $i++;
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($zip_name);
    }
}
