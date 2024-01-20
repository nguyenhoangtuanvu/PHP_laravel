@extends('admin.layouts.app')

@section('title', 'roles')
@section('content')

<h2>Roles List</h2>
<div class="card"> 
    <div><a href="{{ route('roles.create')}}" class="btn btn-primary"> Create</a></div>
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
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}"
                        method="post">
                        @csrf
                        @method('delete')

                    </form>

                    <button class="btn btn-delete btn-danger" data-id={{ $role->id }}>Delete</button>

                </td>
            </tr>
        @endforeach
    </table>
    {{ $roles->links() }}
</div>
@endsection