<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Boutique | Ecommerce bootstrap template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- gLightbox gallery-->
    <link rel="stylesheet" href="vendor/glightbox/css/glightbox.min.css">
    <!-- Range slider-->
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Choices CSS-->
    <link rel="stylesheet" href="vendor/choices.js/public/assets/styles/choices.min.css">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="vendor/swiper/swiper-bundle.min.css">
    <!-- Google fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="page-holder bg-light">
        <!-- navbar-->
        <section class="py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-6">
                        <!-- PRODUCT SLIDER-->
                        <div class="row m-sm-0">
                            <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                                <div class="swiper product-slider-thumbs">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            @foreach ($images as $image)
                                                <img src="{{ asset('imagesproduct/' . $image->image) }}" alt="">
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- PRODUCT DETAILS-->
                    <div class="col-lg-6">
                        <ul class="list-inline mb-2 text-sm">
                            <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                            <li class="list-inline-item m-0 1"><i class="fas fa-star small text-warning"></i></li>
                            <li class="list-inline-item m-0 2"><i class="fas fa-star small text-warning"></i></li>
                            <li class="list-inline-item m-0 3"><i class="fas fa-star small text-warning"></i></li>
                            <li class="list-inline-item m-0 4"><i class="fas fa-star small text-warning"></i></li>
                        </ul>
                        <h1>{{ $product->name }}</h1>

                        <p class="text-sm mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut
                            ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient
                            montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis{{ $product->desc }}.
                        </p>
                        <div class="row align-items-stretch mb-4">
                            <div class="col-sm-5 pr-sm-0">
                                <div
                                    class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">


                                </div>
                            </div>


                            <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                    class="text-uppercase text-dark">Category:</strong><a class="reset-anchor ms-2"
                                    href="#!">{{$product->category->name}}</a></li>
                                    <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                        class="text-uppercase text-dark">price:</strong><a class="reset-anchor ms-2"
                                        href="#!">{{$product->price}}</a></li>
                                        <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                            class="text-uppercase text-dark">saleprice:</strong><a class="reset-anchor ms-2"
                                            href="#!">{{$product->saleprice}}</a></li>
                                            <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                                class="text-uppercase text-dark">quantity:</strong><a class="reset-anchor ms-2"
                                                href="#!">{{$product->quantity}}</a></li>
                                                <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                                    class="text-uppercase text-dark">brand:</strong><a class="reset-anchor ms-2"
                                                    href="#!">{{$product->brand}}</a></li>
                                                    <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                                        class="text-uppercase text-dark">status:</strong><a class="reset-anchor ms-2"
                                                        href="#!">{{$product->status}}</a></li>

                                                           <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                                        class="text-uppercase text-dark">tags:<strong>
                                                        @foreach($product->tags as $tag) 
                                                        <a class="reset-anchor ms-2"
                                                        href="#!">{{$tag->title}}</a>
                                                    @endforeach</li>
    
                            </ul>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/glightbox/js/glightbox.min.js"></script>
    <script src="vendor/nouislider/nouislider.min.js"></script>
    <script src="vendor/swiper/swiper-bundle.min.js"></script>
    <script src="vendor/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="js/front.js"></script>
    <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite - 
        //   see more here 
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {

            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
                var div = document.createElement("div");
                div.className = 'd-none';
                div.innerHTML = ajax.responseText;
                document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot 
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </div>
</body>

</html>
