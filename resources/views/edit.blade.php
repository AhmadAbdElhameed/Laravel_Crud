<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Post</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    </head>
    <body>

        <div class="container" style="margin-top: 50px;">
            <div class="row">
                <div class="col-lg-3">
                    <p>Cover :</p>
                    <img src="/cover/{{$post->cover}}" class="img-responsive" style="max-height: 100px;max-width:100px" alt="">
                    <form action="/deletecover/{{ $post->id }}" method="post">
                        <button class="btn text-danger">X</button>
                        @csrf
                        @method('delete')
                    </form>
                    <br>
                    @if (count($post->images) > 0)
                        <p>Images :</p>
                        @foreach ($post->images as $img)
                            <img src="/images/{{$img->image}}" class="img-responsive" style="max-height: 100px;max-width:100px" alt="image">
                            <form action="/deleteimage/{{$img->id}}" method="POST">
                                <button class="btn text-danger">X</button>
                                @csrf
                                @method("delete")
                            </form>
                        @endforeach
                    @endif

                </div>

                <div class="col-lg-6">
                    <h3 class="text-center text-danger"><b>Update post</b></h3>
                    <div class="form-group">
                        <form action="/update/{{$post->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" class="form-control m-2" placeholder="title" value="{{$post->title}}">
                            <input type="text" name="author" class="form-control m-2" placeholder="author" value="{{$post->author}}">
                            <textarea name="body" cols="30" rows="5" placeholder="body" class="form-control m-2">{{$post->body}}</textarea>
                            <label class="m-2">Cover Image</label>
                            <input type="file" name="cover" id="input-file-now-custom-3" class="form-control m-2">
                        
                            <label class="m-2">Images</label>
                            <input type="file" name="images[]" multiple id="input-file-now-custom-3" class="form-control m-2">
                        
                            <button type=   "submit" class="btn btn-danger mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </body>
</html>