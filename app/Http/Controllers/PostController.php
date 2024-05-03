<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostView;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(): View
    {
        $latestPosts = Post::query()
            ->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $popularPosts = Post::query()
            ->leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
            ->select('posts.*', DB::raw('COUNT(upvote_downvotes.id) as upvote_count'))
            ->where(function ($query) {
                $query
                    ->whereNull('upvote_downvotes.is_upvote')
                    ->orWhere('upvote_downvotes.is_upvote', '=', 1);
            })
            ->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderByDesc('upvote_count')
            ->groupBy('posts.id', 'posts.title', 'posts.slug', 'posts.thumbnail', 'posts.body', 'posts.active', 'posts.published_at', 'posts.user_id', 'posts.created_at', 'updated_at', 'meta_title', 'meta_description')
            ->limit(3)
            ->get();

        $user = auth()->user();
        if ($user) {
            $leftJoin = "(SELECT cp.category_id, cp.post_id FROM upvote_downvotes JOIN category_posts cp ON upvote_downvotes.post_id = cp.post_id WHERE upvote_downvotes.is_upvote = 1 and upvote_downvotes.user_id = ?) as t";
            $recomendedPosts = Post::query()
                ->leftJoin('category_posts as cp', 'posts.id', '=', 'cp.post_id')
                ->leftJoin(DB::raw($leftJoin), function ($join) {
                    $join->on('t.category_id', '=', 'cp.category_id')
                        ->on('t.post_id', "<>", 'cp.post_id');
                })
                ->select('posts.*')
                ->where('posts.id', '<>', DB::raw('t.post_id'))
                ->setBindings([$user->id])
                ->limit(3)
                ->get();
        } else {
            $recomendedPosts = Post::query()
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
                ->where('active', '=', true)
                ->whereDate('published_at', '<', Carbon::now())
                ->orderByDesc('view_count')
                ->groupBy('posts.id', 'posts.title', 'posts.slug', 'posts.thumbnail', 'posts.body', 'posts.active', 'posts.published_at', 'posts.user_id', 'posts.created_at', 'updated_at', 'meta_title', 'meta_description')
                ->limit(3)
                ->get();
        }
        // $categories = Category::query()
        //     ->whereHas('posts', function ($query) {
        //         $query->where('active', '=', true)
        //             ->whereDate('published_at', '<', Carbon::now());
        //     })
        //     ->select('categories.*')
        //     ->selectRaw('MAX(posts.published_at) as max_date')
        //     ->leftJoin('category_posts', 'categories.id', '=', 'category_posts.category_id')
        //     ->leftJoin('posts', 'posts.id', '=', 'category_posts.post_id')
        //     ->orderByDesc('max_date')
        //     ->groupBy('categories.id', 'categories.title', 'categories.slug', 'categories.created_at', 'categories.updated_at')
        //     ->limit(5)
        //     ->get();
        $categories = Category::query()
            //            ->with(['posts' => function ($query) {
            //                $query->orderByDesc('published_at');
            //            }])
            ->whereHas('posts', function ($query) {
                $query
                    ->where('active', '=', 1)
                    ->whereDate('published_at', '<', Carbon::now());
            })
            ->select('categories.*')
            ->selectRaw('MAX(posts.published_at) as max_date')
            ->leftJoin('category_posts', 'categories.id', '=', 'category_posts.category_id')
            ->leftJoin('posts', 'posts.id', '=', 'category_posts.post_id')
            ->orderByDesc('max_date')
            ->groupBy([
                'categories.id',
                'categories.title',
                'categories.slug',
                'categories.created_at',
                'categories.updated_at',
            ])
            ->limit(5)
            ->get();
        return view('home', compact('latestPosts', 'popularPosts', 'recomendedPosts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        if (!$post->active || $post->published_at > Carbon::now()) {
            throw new NotFoundHttpException();
        }

        $next = Post::query()
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $previous = Post::query()
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();

        $user = $request->user();
        PostView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'post_id' => $post->id,
            'user_id' => $user?->id
        ]);

        return view('posts.view', compact('post', 'previous', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function byCategory(Category $category)
    {
        $posts = Post::query()
            ->join('category_posts', 'posts.id', '=', 'category_posts.post_id')
            ->where('category_posts.category_id', '=', $category->id)
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('posts.index', compact('posts', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
