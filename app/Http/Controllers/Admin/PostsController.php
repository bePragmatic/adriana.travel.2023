<?php

namespace App\Http\Controllers\Admin;

use App\Http\Start\Helpers;
use App\Models\ProfilePicture;
use App\Post;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\PostsDataTable;
use Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->helper   = new Helpers();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostsDataTable $dataTable)
    {
        return $dataTable->render('admin.posts.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Post::findOrFail($id);

        return view('admin.posts.edit', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $post = Post::findOrFail($id);

        $data = [];


        foreach ($request->get('translations') as $translation) {
            $data[$translation['locale']]['slug'] = null;
            $data[$translation['locale']]['title'] = $translation['title'];
            $data[$translation['locale']]['meta_title'] = $translation['meta_title'];
            $data[$translation['locale']]['content'] = $translation['content'];
            $data[$translation['locale']]['meta_description'] = $translation['meta_description'];
            $data[$translation['locale']]['meta_keywords'] = $translation['meta_keywords'];
        }

        $post->update($data);

        if ($request->has('img')){

           $this->image_upload($post);
        }


        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function image_upload($post)
    {

       $post = Post::findOrFail($post);
        $image = request()->file('image');


        if ($image) {
            $extension = $image->getClientOriginalExtension();
            $filename = 'post_' . time() . '.' . $extension;
            $imageRealPath = $image->getRealPath();
            $filesize = $image->getSize(); // get image file size

            $extension = strtolower($extension);

            if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png' && $extension != 'gif') {
                flash_message('danger', trans('messages.profile.cannot_upload')); // Call flash message function

                return back();
            }
               if(UPLOAD_DRIVER=='cloudinary') {
                $upload_driver = "Cloudinary";
                try  {
                 /*   $last_src=DB::table('profile_picture')->where('user_id',request()->user_id)->first()->src;
                    \Cloudder::upload(request()->file('post'));
                    $c=\Cloudder::getResult();
                    $filename=$c['public_id'];
                    if($last_src != ""  && !isLiveEnv()) {
                        \Cloudder::destroy($last_src);
                    }*/
                }
                catch (\Exception $e) {
                    if($e->getCode() == '400') {
                        flash_message('danger', trans('messages.profile.image_size_exceeds_10mb'));
                    }
                    else {
                        flash_message('danger', $e->getMessage());
                    }
                    return back();
                }
            }
            else {
                $upload_driver = "Local";
                $img = Image::make($imageRealPath)->orientate();
                $path = dirname($_SERVER['SCRIPT_FILENAME']) . '/images/blog/' . $post->id;
                if (!file_exists($path)) {
                    mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/images/blog/' . $post->id, 0777, true);
                }

                $success = $img->save('images/blog/' . $post->id . '/' . $filename);

                $compress_success = $this->helper->compress_image('images/blog/' . $post->id . '/' . $filename, 'images/blog/' . $post->id . '/' . $filename, 80);
                //change compress image in 510*510
                $compress_success = $this->helper->compress_image('images/blog/' . $post->id . '/' . $filename, 'images/blog/' . $post->id . '/' . $filename, 80, 600, 400);

                $compress_success = $this->helper->compress_image('images/blog/' . $post->id . '/' . $filename, 'images/blog/' . $post->id . '/' . $filename, 80, 1200, 800);

                //end change
                if (!$success) {
                    flash_message('danger', trans('messages.profile.cannot_upload')); // Call flash message function
                    return back();
                }
            }
            $success = $img->save('images/blog/' . $post->id . '/' . $filename);

            $post->update(['img' => $filename]);

            /*delete file from server*/
            if ($filename) {
                $compress_images = ['_800x500.', '_400x250.'];
                $this->helper->remove_image_file($filename, 'images/blog/' . $post->id, $compress_images);
            }
            /*delete file from server*/

            flash_message('success', trans('messages.profile.picture_uploaded')); // Call flash message function

            return redirect()->back();
        }
    }
}
