@extends('admin.layouts.app')

@section('title', 'User')
@section('content')

<h2>Users List</h2>
<div class="card"> 
    @if (session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
    @endif
    <div><a href="{{ route('user.create')}}" class="btn btn-primary"> Create</a></div>
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>{{ $user->phone }}</td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('user.destroy', $user->id) }}" id="form-delete{{ $user->id }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-delete btn-danger" data-id={{ $user->id }}>Delete</button>
                    </form>


                </td>
            </tr>
        @endforeach
    </table>
    {{ $users->links() }}
</div>
@endsection