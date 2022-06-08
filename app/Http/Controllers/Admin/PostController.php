<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Post;
use App\Category;
use App\Tag;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts= Post::all();

        return view('admin.posts.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags= Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'title' => 'required|max:255',
            'content' => 'required|min:8|max:100',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'exists:tags,id',
            ],
            // L'array sottostante equivale ad un messaggio di errore personalizzato,
            // Lo si può utilizzare per cambiare il soggetto dell'errore es 'name.required' => 'The name field is required.'
            [
                'title.required' => 'LoL, you forgot the title.',
                'content.min' => "C'mon man, you're almost there!",
                'content.required'=> 'LoL, you also forgot the content.',
                'category_id.exists' => 'La categoria selected don\'t exists',
                'tags' => 'The tag selected don\'t exists'
            ]
        );
            $postData = $request->all();
            $newPost = new Post();

            $newPost->fill($postData);

            $slug = Str::slug($newPost->title);
            $alternativeSlug = $slug;
            $postFound = Post::where('slug', $alternativeSlug)->first();
            $counter = 1;
            while($postFound){
                $alternativeSlug = $slug . '_' . $counter;
                $counter++;
                $postFound = Post::where('slug', $alternativeSlug)->first();
            }
            $newPost->slug = $alternativeSlug;
            $newPost->save();

            // add tags
            if(array_key_exists('tags', $postData)){
                $newPost->tags()->sync($postData['tags']);
            }


            $newPost->save();
            return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);

        if(!$post){
            abort(404);
        }

        $category = Category::find($post->category_id);
        $tags= Tag::find($post);

        return view('admin.posts.show', compact('post', 'category', 'tags'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // $post=Post::find($id);

        $categories = Category::all();
        $tags= Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:8',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'exists:tags,id'
        ],
        // L'array sottostante equivale ad un messaggio di errore personalizzato,
        // Lo si può utilizzare per cambiare il soggetto dell'errore es 'name.required' => 'The name field is required.'
        [
            'title.required' => 'LoL, you forgot the title.',
            'content.min' => "C'mon man, you're almost there!",
            'content.required'=> 'LoL, you also forgot the content.',
            'category_id.exists' => 'La categoria selected don\'t exists',
            'tags' => 'The tag selected don\'t exists'
        ]
    );
            $postData = $request->all();

            $post->fill($postData);
            $slug = Str::slug($post->title);
            $alternativeSlug = $slug;
            $postFound = Post::where('slug', $alternativeSlug)->first();
            $counter = 1;
            while($postFound){
                $alternativeSlug = $slug . '_' . $counter;
                $counter++;
                $postFound = Post::where('slug', $alternativeSlug)->first();
            }
            $post->slug = $alternativeSlug;

            // add tags
            if(array_key_exists('tags', $postData)){
                $post->tags()->sync($postData['tags']);
            } else {
                $post->tags()->sync([]);
            }

            $post->update();
            return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post){
            $post->tags()->sync([]);
            $post->delete();
        }

        return redirect()->route('admin.posts.index') ;
    }
}
