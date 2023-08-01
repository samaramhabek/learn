<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Document</title>
</head>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="post" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">

            <label for="exampleInputEmail1">name category</label>
            <input type="text" value="{{ old('name', $category->name) }} " name="name" class="form-control"
                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">description</label>
            <textarea name="desc" type="text" class="form-control" id="exampleInputPassword1" value="desc"
                placeholder="Password">{{ $category->desc }}</textarea>
        </div>
        <div id="field-container">
            @foreach ($images as $image)
                <div class="image-container">
                    <label>Image:</label>
                    <input type="file" name="images[]" class="form-control" onchange="previewImage(this);"
                        accept="image/*"><br>
                    <div class="image-preview-container" style="max-width: 200px; max-height: 200px;">
                        <img src="{{ asset('images/' . $image->image) }}" alt="Image Preview" class="preview-image"
                            style="max-width: 100%; max-height: 100%;">
                        <button type="button" class="btn btn-danger remove-image" data-image-id="{{ $image->id }}"
                            onclick="removeImage(this)">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary" onclick="addImageField()">Add Image</button>
        <button type="submit" class="btn btn-dark">Save</button>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                //alert(imageId)

                $.ajax({
                    url: '/admin/delete/' + imageId,
                    type: 'DELETE',
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
        </script>

</body>

</html>
