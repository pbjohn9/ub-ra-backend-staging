@foreach ($role->permissions as $permission)
    {{ $permission->title }}
@endforeach