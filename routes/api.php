<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostRequestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin as Ali;
use App\Models\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register-admin', [RegisteredUserController::class, 'register_Admin']);

Route::post('register-user', [RegisteredUserController::class, 'register_User']); 
Route::post('register-author', [RegisteredUserController::class, 'register_Author']);
Route::post('verify-email-user', [VerifyEmailController::class, 'verify_Email_user']);
Route::post('verify-email-author', [VerifyEmailController::class, 'verify_Email_author']);
Route::post('verify-email-admin', [VerifyEmailController::class, 'verify_Email_admin']);
Route::post('login-user', [AuthenticatedSessionController::class, 'login_user']);
Route::post('login-author', [AuthenticatedSessionController::class, 'login_author']);
Route::post('login-admin', [AuthenticatedSessionController::class, 'login_admin']);




Route::middleware(['auth:sanctum','user'])->group(function(){
Route::get('view-my-profile', [UserController::class, 'view_my_Profile']);
Route::Post('edit-my-profile', [UserController::class, 'Edit_my_Profile']);
Route::post('buy-books/{bookId}', [UserController::class, 'Buy_Book']);
Route::post('add-book-to-Favorite/{BookId}', [UserController::class, 'add_To_Favorite']);
Route::get('view-favorite-books', [UserController::class, 'view_Favorite_Books']);
Route::get('download-books/{book}', [UserController::class, 'download_Book']); // need a check
Route::get('view-requested-book', [UserController::class, 'view_Requested_Books']);
Route::get('Suggest-Extra-Copies',[BookController::class,'Suggest_Extra_Copies']);

});

Route::middleware(['auth:sanctum','author'])->group(function(){
// Route::post('publish-book', [AuthorController::class, 'publish_Book']);
Route::get('view-publishing-books', [AuthorController::class, 'view_Publishing_Requests']);
Route::delete('delete-publishing-request/{id}', [AuthorController::class, 'delete_Publishing_Request']);
Route::get('All-author-books/{id}', [BookController::class, 'allAuthorBooks']);

});

Route::middleware(['auth:sanctum','admin'])->group(function(){
Route::post('ban-user/{id}',[AdminController::class,'ban_user']);
Route::post('Unban-user/{id}',[AdminController::class,'Unban_user']);
Route::get('delete-user/{id}',[AdminController::class,'delete_user']);
Route::get('view-all-users',[AdminController::class,'view_all_users']);
Route::get('view-all-books',[AdminController::class,'view_all_books']);
Route::get('view-publishing-requests',[AdminController::class,'publishing_requests']); 
Route::get('delete-requests/{id}',[AdminController::class,'delete_requests']);
Route::get('approve-requests/{id}',[AdminController::class,'approve_requests']);
Route::post('add-category',[CategoryController::class,'add_category']);
Route::post('update-book/{id}',[BookController::class,'update_book']);
Route::get('delete-book/{id}',[BookController::class,'delete_book']);
Route::get('get-category',[AdminController::class,'add_category']);//NeWWW
Route::get('get-Post-Request-By/{id}',[AdminController::class,'get_Post_Request_By_id']);//NeWWW
Route::get('get-user-by/{id}', [AdminController::class, 'get_User_By_id']);//NeWWW
Route::get('get-book-by/{id}', [AdminController::class, 'get_Book_By_id']);//NeWWW
Route::get('total-profit', [AdminController::class, 'get_total_profit']);//NeWWW
Route::get('/post-request/{id}', [PostRequestController::class, 'show']);
Route::get('low-demand-books',[BookController::class,'show_law_demands_books']);
Route::get('Most-Requested-books',[BookController::class,'Most_Requested_books']);
Route::get('High-Demand-Categories',[BookController::class,'High_Demand_Categories']);
Route::get('peak-purchase-hours',[BookController::class,'peak_purchase_hours']);
Route::get('Most-Active-User',[BookController::class,'Most_Active_User']);
Route::get('Monthly-report',[BookController::class,'Monthly_report']);
Route::get('ineffective-Books',[BookController::class,'ineffective_Books']);
});
    
Route::middleware(['auth:sanctum', 'adminOrAuthor'])->group(function(){

Route::post('publish-book',[BookController::class,'publish_book']);
});