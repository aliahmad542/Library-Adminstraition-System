<?php

namespace App\Http\Controllers;

use App\Models\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostRequestController extends Controller
{
    public function publishing_requests(){
     PostRequest::all();
     return response()->json('this is all the publishing requests, you can accept or reject it');
}
public function delete_requests($postRequestId){
PostRequest::destroy($postRequestId);
// Mail::raw('Hi Dear , your Post Request is rejected because you book is forbidden', function ($message) use ($user) {
//     $message->to($user->email);
// });
return response()->json('this post Request is deleted');
}
public function approve_requests($postRequestId){
$request=PostRequest::findOrFail($postRequestId);
$request->status='approved';
// Mail::raw('Hi Dear , your Post Request is rejected because you book is forbidden', function ($message) use ($user) {
//     $message->to($user->email);
// });
return response()->json('this post Request is Approved');
}
}