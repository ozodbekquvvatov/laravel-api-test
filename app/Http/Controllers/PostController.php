<?php
namespace App\Http\Controllers; 
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => Post::with('user')->get(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());

        return response()->json([
            'status' => 200,
            'data' => $post,
        ], 200);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Post topilmadi'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        
        // $request->validate([
        //     'title' => 'required|string',
        //     'body' => 'required|string',
        // ]); 
    
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Post topilmadi' 
            ], 404);
        }
        
        $post->update($request->only('title', 'body','user_id'));
        return response()->json([
            'status' => 200,
            'data' => $post
        ]);
    }
    

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Post topilmadi'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Post o‘chirildi'
        ]);
    }
}
