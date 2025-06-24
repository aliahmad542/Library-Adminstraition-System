<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function add_book(Request $request){
       $request->validate([
        'title'        => 'required|string|max:255',
        'Description'  => 'required|string',
        'price'        => 'required|numeric',
        'category_id'  => 'required|exists:categories,id',
        'admin_id'     => 'required|exists:admins,id',
        'author_id'    => 'required|exists:authors,id',
        'quantity'     => 'required|integer',
        'file_path'    => 'required|file|mimes:pdf,doc,docx,epub' // حسب نوع الملفات المسموحة
    ]);
    $filePath = $request->file('file_path')->store('books', 'public');
    $data=Book::create([
      'title'        => $request->title,
      'Description'  => $request->Description,
      'price'        => $request->price,
      'file_path'    => $filePath,
      'category_id'  => $request->category_id,
      'admin_id'     => $request->admin_id,
      'author_id'    => $request->author_id,
      'quantity'     => $request->quantity
  ]);
      
      return response()->json(['you are added a new book successfully . Now , All users can see it' , $data]);
    }
    public function update_book(Request $request , $bookId){
     $newData=Book::findOrFail($bookId);
     $newData->update($request->all());
     
     return response()->json(['this book has been updated successfully',$newData]);
    }
    public function delete_book($bookId){

        Book::where('id',$bookId)->delete();
        //Book::destroy($bookId);
        return response()->json('this book has been deleted successfully');

    }
}
