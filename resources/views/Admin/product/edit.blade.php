@extends('layout.master-dasboard')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form  action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
     
        <div class="form-group">

            <label for="exampleInputEmail1">name product:</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                   value="{{old('name',$product->name)}}"  placeholder="Enter name">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">description</label>
            <input name="desc" type="text"  value="{{old('desc',$product->desc)}}" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group">
            <label>select category </label>
            <select  name="category_id" class="form-control" required   >
                {{-- <option selected >{{$product->category->name}}</option> --}}
                @foreach ($categories as  $category )
              
                <option value="{{$category->id}}" @if($category->id==$product->category_id) selected @endif >{{$category->name}}</option>
                @endforeach

            </select>

  
            <div id="field-container">
                @foreach ($images as $image)
                    <div class="image-container">
                        <label>Image:</label>
                        <input type="file" name="images[]" class="form-control" onchange="previewImage(this);"
                            accept="image/*"><br>
                        <div class="image-preview-container" style="max-width: 200px; max-height: 200px;">
                            <img src="{{ asset('imagesproduct/' . $image->image) }}" alt="Image Preview" class="preview-image"
                                style="max-width: 100%; max-height: 100%;">
                            <button type="button" class="btn btn-danger remove-image" data-image-id="{{ $image->id }}"
                                onclick="removeImage(this)">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
    
            <button type="button" class="btn btn-primary" onclick="addImageField()">Add Image</button>
          
        </div>
        <label >price:</label>
        <input type="number" name="price" value="{{old('price',$product->price)}}" class="form-control">
        <label >sale price:</label>
        <input type="number" name="saleprice"  value="{{old('saleprice',$product->saleprice)}}" class="form-control">
        <label >quantity:</label>
        <input type="number" name="quantity" value="{{old('quantity',$product->quantity)}}" class="form-control" >
        
        <label >brand:</label>
        <input type="text" name="brand"  value="{{old('brand',$product->brand)}}" class="form-control" >

        <br><label >status:</label>
        <input type="radio" name="status"  id="new"   value="new" @if($product->status == 'new') checked @endif >
        <input type="radio" name="status"  id="sale" value="sale" @if($product->status == 'sale') checked @endif>
        <input type="radio" name="status"  id="sold" value="sold" @if($product->status == 'sold') checked @endif>
        <br>
        
        <input name="tags" value="{{ ($product->tags)->pluck('title')->implode(',') }}">

        <br>



        <button type="submit" id="submit" class="btn btn-dark">Save</button>

    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- code script add remove input dynamic-->
    {{-- <script type="text/javascript">
    var i = 0;
    $("#add").click(function () {
        ++i;
        $("#field-container").append('<tr><td><input type="file" id="images" name="images[' + i +
            ']" placeholder="Enter image" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script> --}}
    {{--  show one image in view before save <script>
  
  function previewImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#preview').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
</script> --}}
<script>
    function previewImage(input) {
        var reader = new FileReader();
        var previewContainer = $(input).closest('.image-container').find('.image-preview-container');
        var previewImage = previewContainer.find('.preview-image');

        reader.onload = function(e) {
            previewImage.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }

    function removeImage(button) {
        $(button).closest('.image-container').remove();

    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.remove-image', function(event) {

        event.preventDefault();
        var imageId = $(this).data('image-id');
      //  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        alert(imageId)

        $.ajax({
            url: '/admin/delete/product/' + imageId,
            type: 'DELETE',
//             headers: {
//     'X-CSRF-TOKEN': csrfToken
//   },
            data : {
                "_token": "{{ csrf_token() }}",
            },

            success: function(response) {
                console.log(response);
                // Remove the image and delete button/link from the view
                // or update the view accordingly
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });



    function addImageField() {
        var newField = $('<div class="image-container">' +
            '<label>Image:</label>' +
            '<input type="file" name="images[]" class="form-control" onchange="previewImage(this);" accept="image/*"><br>' +
            '<div class="image-preview-container" style="max-width: 200px; max-height: 200px;">' +
            '<img src="" alt="Image Preview" class="preview-image" style="max-width: 100%; max-height: 100%;">' +
            '<button type="button" class="btn btn-danger remove-image" onclick="removeImage(this)">Delete</button>' +
            '</div>' +
            '</div>');

        $('#field-container').append(newField);
    }
    var input = document.querySelector('input[name=tags]');

// initialize Tagify on the above input node reference
new Tagify(input)
</script>

   
</body>
@endsection