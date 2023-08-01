<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">

            <label for="exampleInputEmail1">name category</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Enter email">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">description</label>
            <input name="desc" type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div id="field-container">

            <label>images:</label>
            {{-- <button type="button" id="add" class="btn btn-primary">add image</button> --}}
            <input type="file" name="images[]" class="form-control" id="images" multiple value=""
                onchange="previewImage(this);"><br>



            <div class="form-group">
                <div id="image-preview-container" style="max-width: 200px; max-height: 200px;">

                    <img id="preview" src="" alt="" style="max-width: 200px; max-height: 200px;">

                </div>
            </div>
        </div>


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
        $(document).ready(function() {
            $('#images').on('change', function() {
                previewImages(this.files);
            });
        });

        function previewImages(files) {
            var container = $('#image-preview-container');
            container.empty();

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = $('<img>').attr('src', e.target.result).addClass('img-fluid');
                    container.append(img);

                };

                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
