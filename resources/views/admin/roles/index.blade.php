@extends('admin.layouts.app')

@section('title', 'roles')
@section('content')

<h2>Roles List</h2>
<div class="card"> 
    @if (session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
    @endif
        
    @can('create-role')
    <div><a href="{{ route('roles.create')}}" class="btn btn-primary"> Create</a></div>
    @endcan
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>DisplayName</th>
            <th>Action</th>
        </tr>

        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>

                <td>{{ $role->display_name }}</td>
                <td>
                    @can('update-role')
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                    @endcan
                    @can('delete-role')
                    <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-delete btn-danger" data-id={{ $role->id }}>Delete</button>
                    </form>
                    @endcan



                </td>
            </tr>
        @endforeach
    </table>
    {{ $roles->links() }}
</div>
@endsection