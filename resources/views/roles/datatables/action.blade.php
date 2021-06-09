@can('role_edit')
    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-success waves-effect waves-light mr-2">
        {{ __('Edit') }}
    </a>
@endcan

@can('role_delete')
<form class="d-inline-block" action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure to delete this role?') }}');">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('Delete') }}</button>
</form>
@endcan