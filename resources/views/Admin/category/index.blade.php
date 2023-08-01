
<head>

    <title>Pusher Test</title>
    <head>
        <!-- Other meta tags, stylesheets, etc. -->
        {{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}
     
    
</head>
<body>
    <!-- Add this to your HTML -->
<span id="notification-badge" class="badge bg-danger">{{count(Auth::user()->unreadNotifications) }}

<a href="{{url('all-notifications')}}" class="view link-icon-detail"  title="Bell" data-id="3602145" 
data-src="?term=notification&amp;page=1&amp;position=3&amp;origin=tag">
    <img src="https://cdn-icons-png.flaticon.com/128/3602/3602145.png"
     data-src="https://cdn-icons-png.flaticon.com/128/3602/3602145.png" alt="Bell " title="Bell " width="64" height="64" class="lzy lazyload--done" srcset="https://cdn-icons-png.flaticon.com/128/3602/3602145.png 4x">
  </a></span> 
 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

{{-- <body> --}}
    <title>Categories</title>

    <h1>Categories</h1>
    <form  action="/admin/category" method="get">
        
    
        <input type="text" name="search" placeholder="search by name">
        <select  name="parent_id" class="form-control" required >
            <option>select... </option>
            @foreach ($parents as  $parent )
          
            <option value="{{$parent->id}}">{{$parent->name}}</option>
            @endforeach

        </select>

    <button type="submit">filtter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">desc</th>
                <th scope="col">parent name</th>

                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td><a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->desc }}</td>
                    <td>{{ $category->parent->name }}</td>


                    <td> <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
    
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  
    <script>
 let notificationCount = "{{count(Auth::user()->unreadNotifications) }}";
 
// Enable pusher logging - don't include this in production
var key = "{{config('services.pusher.key')}}";
Pusher.logToConsole = true;

var pusher = new Pusher(key, {
  cluster: 'ap2',
  
    authEndpoint:'/broadcasting/auth',

});

var channel = pusher.subscribe('private-App.Models.User.{{Auth::id()}}');
channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
    notificationCount++;
    document.getElementById('notification-badge').textContent = notificationCount;
  alert(data.title);
});
</script>
//    <script>
//   import Echo from 'laravel-echo'
//   'key'=app.config('services.pusher.app_key');
//   window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'key',
//     cluster: 'ap2',
//     forceTLS: true
//   });
//   $id=Auth(guard:'admin')::id();
  
//   var channel = Echo.channel('private-App.Models.Admin'.+$id);
//   channel.listen('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
//     alert(JSON.stringify(data));
//   });
//   </script> 