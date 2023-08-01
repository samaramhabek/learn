<html>


@can('create articles')
<a href="/articles/create"> create</a>
@endcan

@can('index articles')
<a href="/articles"> index</a>
@endcan
@can('edit articles')
<a href="/articles/edit"> edit</a>
@endcan
</html>
