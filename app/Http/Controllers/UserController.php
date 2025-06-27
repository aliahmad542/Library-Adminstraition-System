<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Request as RequestModel;

use App\Models\PostRequest;
use App\Models\Request as ModelsRequest;
use App\Models\UserBook;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class UserController extends Controller
{ /** @var \App\Models\User $user */
    public function view_my_profile(){
          
        return response()->json(Auth::user());
    }
    public function Edit_my_profile(Request $request){
        // User::where('id',Auth()->id)->update([
        //     'firstname' => $request->firstname,
        //     'lastname' => $request->lastname,
        //     'location' => $request->location,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);
        /** @var \App\Models\User $user */

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $user->update($request->all());
        return response()->json('you are updated your profile successfully');
    }
   

    

    public function searchBook(Request $request)
    {
        $query = $request->get('q');

        $books = Book::where('title', 'like', "%$query%")
                     ->orWhereHas('author', fn($q) => $q->where('name', 'like', "%$query%"))
                     ->get();

        return response()->json($books);
    }

    public function filterBooks(Request $request)
    {
        $query = Book::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return response()->json($query->get());
    }

    public function Request_Book(Request $request, $book_id)
{
   
$quantity_requested=$request->input('quantity');
$book=Book::findOrFail($book_id);
if(!$book_id){
    return response()->json(['Sorry , Book Not Found']);
}
if($quantity_requested > $book->quantity ){
    return response()->json(['Sorry , Insufficient stock']);
}
$book->quantity -= $quantity_requested;
$book_requested=RequestModel::create([
    'user_id'=>$request->user_id,
    'book_id'=>$request->book_id,
    'quantity'=>$book->quantity
]);
    return response()->json(['you Bought the book successfully , Enjoy it',$book_requested]);
}










    // $quantity = $request->input('quantity');

   
    // $book = Book::find($book_id);
    // if (!$book) {
    //     return response()->json(['error' => 'Book not found'], 404);
    // }

    // if ($book->quantity < $quantity) {
    //     return response()->json(['error' => 'Insufficient stock'], 400);
    // }

    // $existing = PostRequest::where('user_id',Auth()->id)
    //     ->where('book_id', $book_id)
    //     ->first();

    // if ($existing) {
    //     return response()->json(['message' => 'Book already requested'], 400);
    // }

    // $requestEntry = PostRequest::create([
    //     'user_id' => Auth()->id,
    //     'book_id' => $book_id,
    //     'quantity' => $quantity,
    // ]);

    // $book->quantity -= $quantity;
    // $book->save();

    // return response()->json(['message' => 'Book requested', 'request' => $requestEntry]);



    public function add_To_Favorite($book_id)
    {
        $book = Book::find($book_id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->favoriteByUser()->syncWithoutDetaching([Auth::id()]);        
        

        return response()->json(['message' => 'Book added to favorites']);
    }

    public function download_Book($book_id)
    {
        $book = Book::find($book_id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->download(storage_path("app/{$book->file_path}"));
    }

    public function view_Favorite_Books()
    {    
       
        $user=Auth::user();
      $favorite=  $user->favoriteBooks;
        return response()->json(  $favorite);
        
    }

    public function view_Downloaded_Books()
    {
        // غير مفعّل حاليًا
        return response()->json(['message' => 'Not implemented']);
    }

    public function view_Requested_Books()
    {
        $requests = PostRequest::where('user_id', Auth::id())->with('book')->get();
        return response()->json($requests);
    }
}
