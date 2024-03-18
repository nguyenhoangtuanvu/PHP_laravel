@extends('admin.layouts.app')

@section('title', 'Category')
@section('content')

<h2>Roles List</h2>
<div class="card"> 
    @if (session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
    @endif
    @can('create-category')
    <div><a href="{{ route('categories.create')}}" class="btn btn-primary"> Create</a></div>
    @endcan
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Parent Name</th>
            <th>Action</th>
        </tr>

        @foreach ($category as $items)
            <tr>
                <td>{{ $items->id }}</td>
                <td>{{ $items->name }}</td>

                <td>{{ $items->parent_name }}</td>
                <td>
                    @can('update-category')
                    <a href="{{ route('categories.edit', $items->id) }}" class="btn btn-warning">Edit</a>
                    @endcan
                    @can('delete-category')
                    <form action="{{ route('categories.destroy', $items->id) }}" id="form-delete{{ $items->id }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-delete btn-danger" data-id={{ $items->id }}>Delete</button>
                    </form>
                    @endcan



                </td>
            </tr>
        @endforeach
    </table>
    {{ $category->links() }}
</div>
@endsection

@section('script')
    

    <script>
        // $(() => {
        //     function confirmDelete() {
        //         return new Promise((resolve, reject) => {
        //             Swal.fire({
        //             title: "Are you sure?",
        //             text: "You won't be able to revert this!",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonColor: "#3085d6",
        //             cancelButtonColor: "#d33",
        //             confirmButtonText: "Yes, delete it!"
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     resolve(true);
        //                 }else {
        //                     reject(false);
        //                 }
        //             });
        //         })
        //     }

        //     $(document).on('click', '.btn-delete', function(e) {
        //         e.preventDefault();
        //         let id = $(this).data('id');
        //         confirmDelete().then(function() {
        //             $(`#form-delete${id}`).submit();
        //         }).catch();
        //     })
        // })
    </script>
@endsection