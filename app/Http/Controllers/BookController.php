<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Admin;
use App\Models\PostRequest;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class BookController extends Controller
{ 
    public function index()
    {
        $books = Book::with(['author', 'category', 'admin'])->get();
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'category', 'admin'])->findOrFail($id);
        return response()->json($book);
    }

    
    public function update_book(Request $request , $bookId){
     $newData=Book::findOrFail($bookId);
     $newData->update($request->all());
     
     return response()->json(['this book has been updated successfully',$newData]);
    }
    public function delete_book($bookId){

        Book::where('id',$bookId)->delete();
        return response()->json('this book has been deleted successfully');

    }
    public function show_law_demands_books(){
        $lowdamandbooks = DB::table('requests')
        ->select('books.title', DB::raw('SUM(requests.quantity) as total_quantity'))
        ->join('books', 'requests.book_id', '=', 'books.id')
        ->groupBy('requests.book_id', 'books.title')
        ->orderBy('total_quantity', 'asc') 
        ->limit(5) 
        ->get()
        ->map(function($book) {
            return [
                'title' => $book->title . ' low requst',
                'total_quantity' => $book->total_quantity,
            ];
        });
        return response()->json([ $lowdamandbooks]);

    } 
    public function Most_Requested_books(){
        $Highdamandbooks = DB::table('requests')
        ->select('books.title', DB::raw('SUM(requests.quantity) as total_quantity'))
        ->join('books', 'requests.book_id', '=', 'books.id')
        ->groupBy('requests.book_id', 'books.title')
        ->orderBy('total_quantity', 'desc') 
        ->limit(5) 
        ->get()
        ->map(function($book) {
            return [
                'title' => $book->title . ' low requst',
                'total_quantity' => $book->total_quantity,
            ];
        });
        return response()->json([ $Highdamandbooks]);
    }
    public function peak_purchase_hours(){
        $topHours = DB::table('requests')
        ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total_orders')) // count() its count how much time the value is reapeted
        ->groupBy(DB::raw('HOUR(created_at)'))// its filters every value toa group
        ->orderByDesc('total_orders')
        ->limit(5)
        ->get()
        ->map(function($row) {
            $formattedHour = str_pad($row->hour, 2, '0', STR_PAD_LEFT) . ':00';
            return [
                'hour' => $formattedHour,
                'total_orders' => $row->total_orders,
            ];
        });
    
    return response()->json($topHours);
    

    

    }
    public function Most_Active_User(){
        $mostActiveUsers = User::select('users.id', 'users.firstname','users.lastname')
            ->join('requests', 'requests.user_id', '=', 'users.id')  
            ->selectRaw('COUNT(requests.id) as total_requests')      
            ->groupBy('users.id',  'users.firstname','users.lastname')                    
            ->orderByDesc('total_requests')                         
            ->get();                                                

        return response()->json($mostActiveUsers);
    }
    public function Monthly_report(){
    $month = $month ?? Carbon::now()->month;
    $year = Carbon::now()->year;

    $totalRequests = DB::table('requests')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->count();

    $topBooks = DB::table('requests')
        ->join('books', 'books.id', '=', 'requests.book_id')
        ->select('books.id', 'books.title', DB::raw('COUNT(requests.id) as total_requests'))
        ->whereMonth('requests.created_at', $month)
        ->whereYear('requests.created_at', $year)
        ->groupBy('books.id', 'books.title')
        ->orderByDesc('total_requests')
        ->limit(5)
        ->get();

    $topUsers = DB::table('requests')
        ->join('users', 'users.id', '=', 'requests.user_id')
        ->select('users.id', 'users.firstname','users.lastname', DB::raw('COUNT(requests.id) as total_requests'))
        ->whereMonth('requests.created_at', $month)
        ->whereYear('requests.created_at', $year)
        ->groupBy('users.id', 'users.firstname','users.lastname')
        ->orderByDesc('total_requests')
        ->limit(5)
        ->get();

    return response()->json([
        'month' => $month,
        'year' => $year,
        'total_requests' => $totalRequests,
        'top_books' => $topBooks,
        'top_users' => $topUsers
    ]);
    }
    public function High_Demand_Categories(){
        $topCategories = DB::table('requests')
    ->join('books', 'requests.book_id', '=', 'books.id')
    ->join('categories', 'books.category_id', '=', 'categories.id')
    ->select('categories.name', DB::raw('SUM(requests.quantity) as total_requested'))
    ->groupBy('categories.name')
    ->orderByDesc('total_requested')
    ->limit(5)
    ->get();
 return response()->json($topCategories);
    }
    public function ineffective_Books(){
        $ineffectiveBooks = Book::select('books.id', 'books.title')
        ->leftJoin('requests', 'requests.book_id', '=', 'books.id')   
        ->selectRaw('COUNT(requests.id) as total_requests')           
        ->groupBy('books.id', 'books.title')                         
        ->orderBy('total_requests', 'asc')                            
        ->get();

    return response()->json($ineffectiveBooks);
    }
    public function Suggest_Extra_Copies(){
        $userId = Auth::id(); 

        if (!$userId) {
            return response()->json(['message' => 'المستخدم غير مسجل الدخول'], 401);
        }
    
        $favoriteCategories = DB::table('requests')
            ->join('books', 'books.id', '=', 'requests.book_id')
            ->where('requests.user_id', $userId)
            ->select('books.category_id', DB::raw('COUNT(books.category_id) as total'))
            ->groupBy('books.category_id')
            ->orderByDesc('total')
            ->pluck('books.category_id');
    
        if ($favoriteCategories->isEmpty()) {
            return response()->json(['message' => 'لا توجد اهتمامات بعد لهذا المستخدم']);
        }
    
        $requestedBooks = DB::table('requests')
            ->where('user_id', $userId)
            ->pluck('book_id');
    
        $suggestedBooks = DB::table('books')
            ->whereIn('category_id', $favoriteCategories)
            ->whereNotIn('id', $requestedBooks)
            ->select('id', 'title', 'category_id')
            ->limit(10)
            ->get();
    
        return response()->json($suggestedBooks);
    }
    













    public function publish_book(Request $request)
{
    $request->validate([
        'title'       => 'required|string',
        'description' => 'required|string',
        'file_path'   =>  'required|file|mimes:pdf,docx,epub',
        'price'       => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'quantity'    => 'required|integer',
        'author_name' => 'required|string',
        'image_path'  => 'required|string',
    ]);

    $user = Auth::user();

    $isAdmin = Admin::where('email', $user->email)->exists();
    $isAuthor = Author::where('email', $user->email)->exists();

    if ($isAdmin) {
        $admin = Admin::where('email', $user->email)->first();

        Book::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'price'        => $request->price,
            'file_path'    => $request->file_path,
            'category_id'  => $request->category_id,
            'author_id'    => 0,
            'author_name'  => $request->author_name,
            'admin_id'     => $admin->id,
            'quantity'     => $request->quantity,
            'image_path'   => $request->image_path,
        ]);

        return response()->json(['message' => 'Book added directly by admin'], 201);

    } elseif ($isAuthor) {
        $author = Author::where('email', $user->email)->first();

        PostRequest::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $request->file_path,
            'price'        => $request->price,
            'category_id'  => $request->category_id,
            'author_id'    => $author->id,
            'author_name'  => $author->firstname.' '.$author->lastname,
            'admin_id'     => 0,
            'quantity'     => $request->quantity,
            'status'       => 'pending',
        ]);

        return response()->json(['message' => 'Publish request sent for approval'], 201);
    } else {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
public function allAuthorBooks($id)
{
    $books = Book::where('author_id', $id)->get();

    if ($books->isEmpty()) {
        return response()->json(['message' => 'No books found for this author'], 404);
    }

    return response()->json($books, 200);
}
}
