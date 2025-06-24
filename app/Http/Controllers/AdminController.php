<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function view_all_users(){
        $users=User::all();
        return response()->json([$users]);
    }
    public function view_all_books(){
        $books=Book::all();
        return response()->json([$books]);
    }
   public function ban_user($userId){
         
           

           
           $user=User::findOrFail($userId);
           $user->is_banned=true;
           $user->save();
           return response()->json(['this user is baned from your App',$user]);
   }
   public function Unban_user($userId){
   
           $user=User::findOrFail($userId);
           $user->is_banned=false;
           $user->save();
       return response()->json(['this user Become Unbaned from your App ',$user]);
   } 
   public function delete_user($id){
      User::destroy($id);
      return response()->json('this user is deleted from your App');
   }
   public function publishing_requests(){
    $pendingRequests=PostRequest::where('status','pending')->get();
 return response()->json([$pendingRequests,'here is  the requested books you can accept it or reject it']);
   }
   public function delete_requests($requestId){
    $postRequest = PostRequest::findOrFail($requestId);
    
    $postRequest->status = 'rejected';
    $postRequest->admin_id = Auth::id(); 
    $postRequest->save();

    return response()->json([
        'message'=>'request is rejected',
        'data' => $postRequest
    ], 200);

   }
   public function approve_requests($bookId){
    $postRequest = PostRequest::findOrFail($bookId);
    
    $postRequest->status = 'approved';
    $postRequest->admin_id = Auth::id(); 
    $postRequest->save();

    return response()->json([
        'message'=>'request is Approved',
        'data' => $postRequest
    ], 200);
   }
}
