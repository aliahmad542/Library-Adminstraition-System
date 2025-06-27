<?php

namespace App\Http\Controllers;
use App\Models\PostRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class AuthorController extends Controller
{
    public function publish_Book(Request $request)
    {
        
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'price' => 'required|integer',
                'quantity' => 'required|integer',
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:10240',
            ]);
    
            $path = $request->file('file_path')->store('books');
    
            $postRequest = PostRequest::create([
                'title' => $validated['title'],
                'author_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'description' => $validated['description'],
                'price' => $validated['price'], 
                'file_path' => $path,
                'admin_id' => 0,
                'status'=>'pending',
                'quantity'=>$validated['quantity']
            ]);
    
            return response()->json([
                'message' => 'Publishing request is pending , The Admin will respond shortly after checking the content',
                'data' => $postRequest,
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function view_Publishing_Requests()
    {
        $requests = PostRequest::where('author_id', Auth()->id)->get();
        return response()->json([$requests,'here is the publishing book until the admin accept or reject it']);
    }

    public function delete_Publishing_Request($id)
    {
        $request = PostRequest::where('id', $id)
            ->where('author_id', Auth()->id)
            ->first();

        if (!$request) {
            return response()->json(['error' => 'Request not found'], 404);
        }

        $request->delete();

        return response()->json(['message' => 'Publishing request deleted successfully']);
    }
}
