<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Services\GeminiAiService;

class UploadController extends Controller
{
    public function index()
    {
        return Inertia::render('FileUpload/Upload');
    }

    public function store(Request $request, GeminiAiService $geminiAiService)
    {   
        $request->validate([
            'images' => 'required|array',
        ]);
        try {
            $imageUrls = array_map(fn($imagePath) => 'storage/' . $imagePath, $request->images);
            $result = $geminiAiService->analyzeImages($imageUrls);
            return Inertia::render('FileUpload/Upload', [
                'imageAnalysisResult' => $result,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gemini AI API call failed', ['error' => $e->getMessage()]);
            return redirect()->back();
        }
    }

    public function upload(Request $request){
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time().'.'.$request->images->extension();
        $filePath =  $request->file('images')->storeAs('images', $imageName, 'public');
        return $filePath;
    }
}
