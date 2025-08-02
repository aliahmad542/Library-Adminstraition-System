<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\PostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/view-all-users",
     *     summary="View all users",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function view_all_users()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     path="/api/view-all-books",
     *     summary="View all books",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function view_all_books()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * @OA\Patch(
     *     path="/api/ban-user/{id}",
     *     summary="Ban a user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User banned successfully")
     * )
     */
    public function ban_user($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();
        return response()->json(['message' => 'User banned successfully', 'user' => $user]);
    }

    /**
     * @OA\Patch(
     *     path="/api/unban-user/{id}",
     *     summary="Unban a user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User unbanned successfully")
     * )
     */
    public function unban_user($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();
        return response()->json(['message' => 'User unbanned successfully', 'user' => $user]);
    }

    /**
     * @OA\Delete(
     *     path="/api/delete-user/{id}",
     *     summary="Delete a user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully")
     * )
     */
    public function delete_user($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/view-publishing-requests",
     *     summary="View pending publishing requests",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Pending publishing requests",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PostRequest"))
     *     )
     * )
     */
    public function publishing_requests()
    {
        $pendingRequests = PostRequest::where('status', 'pending')->get();
        return response()->json($pendingRequests);
    }

    /**
     * @OA\Post(
     *     path="/api/delete-requests/{id}",
     *     summary="Reject a publishing request",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Publishing request rejected")
     * )
     */
    public function delete_requests($id)
    {
        $postRequest = PostRequest::findOrFail($id);
        $postRequest->status = 'rejected';
        $postRequest->admin_id = Auth::guard('admin')->id();
        $postRequest->save();

        return response()->json(['message' => 'Publishing request rejected', 'data' => $postRequest]);
    }

    /**
     * @OA\Post(
     *     path="/api/approve-requests/{id}",
     *     summary="Approve a publishing request and add book",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Publishing request approved and book added")
     * )
     */
    public function approve_requests($id)
    {
        $postRequest = PostRequest::findOrFail($id);
        $postRequest->status = 'approved';
        $postRequest->admin_id = Auth::guard('admin')->id();
        $postRequest->save();

        $book = new Book();
        $book->title = $postRequest->title;
        $book->author_id = $postRequest->author_id;
        $book->author_name = $postRequest->author_name;
        $book->category_id = $postRequest->category_id;
        $book->description = $postRequest->description;
        $book->admin_id = $postRequest->admin_id;
        $book->price = $postRequest->price;
        $book->quantity = $postRequest->quantity;
        $book->image_path = $postRequest->image_path;

        $book->save();
        $book->load('author');

        $postRequest->delete();

        return response()->json(['message' => 'Request approved and book added to library', 'book' => $book]);
    }

    /**
     * @OA\Get(
     *     path="/api/get-category",
     *     summary="Get all categories",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Category"))
     *     )
     * )
     */
    public function get_categories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * @OA\Get(
     *     path="/api/get-user-books/{id}",
     *     summary="Get books requested by a user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Books requested by user",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function get_user_books($id)
    {
        $user = User::findOrFail($id);
        $books = $user->requestedBooks; // تأكد ان relation موجودة في User model
        return response()->json($books);
    }
}
