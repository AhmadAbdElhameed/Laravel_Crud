<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use File;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('index')->with('posts',$posts);
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
        if($request->hasFile('cover')){
            $file = $request->file('cover');
            $imageName=time().'_'.$file->getClientOriginalName();
            $file->move(\public_path("cover/"),$imageName);

            
            $post = new Post([
                'title' => $request->title,
                'author' => $request->author,
                'body' => $request->body,
                'cover' => $imageName,
            ]);
            $post->save();
        }


        if($request->hasFile('images')){
            $files = $request->file('images');
            foreach($files as $file){
                $imageName = time().'_'.$file->getClientOriginalName();
                $request['post_id'] = $post->id;
                $request['image'] = $imageName;
                $file->move(\public_path("images/"),$imageName);
                Image::create($request->all());
            }
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $post=Post::findOrFail($id);
        if ($request->hasFile("cover")) {
            if(File::exists("cover/".$post->cover)){
                File::delete("cover/".$post->cover);
            }
            $file = $request->file('cover');
            $post->cover = time().'_'.$file->getClientOriginalName();
            $file->move(\public_path("/cover"),$post->cover);
            $request['cover'] = $post->cover;

        }
        $post->update([
            'title' => $request->title,
            'author' => $request->author,
            'body' => $request->body,
            'cover' => $post->cover,
        ]);

        if($request->hasFile('images')){
            $files = $request->file('images');
            foreach($files as $file){
                $imageName = time().'_'.$file->getClientOriginalName();
                $request['post_id'] = $id;
                $request['image'] = $imageName;
                $file->move(\public_path("images/"),$imageName);
                Image::create($request->all());
            }
        } 
        
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        if(File::exists('cover/'.$post->cover)){
            File::delete('cover/'.$post->cover);
        }

        $images = Image::where('post_id',$post->id)->get();
        foreach($images as $image){
            if(File::exists('images/'.$image->image)){
                File::delete('images/'.$image->image);
            }
        }

        $post->delete();
        return back();
    }

    public function deleteImage($id){
        $images = Image::findOrFail($id); 
        if(File::exists('images/'.$images->image)){
            File::delete('images/'.$images->image);
        }
        Image::find($id)->delete();
        return back();
    }
    // public function deleteCover($id){
    //     $cover = Post::findOrFail($id)->cover; 
    //     if(File::exists('cover/'.$cover)){
    //         File::delete('cover/'.$cover);
    //     }
    //     return back();
    // }

    public function deleteCover($id){
        $cover=Post::findOrFail($id)->cover;
        if (File::exists("cover/".$cover)) {
            File::delete("cover/".$cover);
        }
        return back();
    }
}
