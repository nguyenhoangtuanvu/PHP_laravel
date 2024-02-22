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
            <th>id</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><img src="{{ $user->images->count() >0 ? asset('upload/'. $user->images->first()->url) : 'upload/default.webp' }}" width="70px" height="70px" alt=""></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>{{ $user->phone }}</td>
                <td style="display:flex; padding-top: 20px;">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning" style="margin-right: 20px;">Edit</a>

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