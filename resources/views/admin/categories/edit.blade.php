@extends('admin.layouts.app')
@section('title', 'Edit Category ' . $category->name)
@section('content')
    <div class="card">
        <h1>Edit role</h1>

        <div>
            <form action="{{ route('categories.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')


                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" value="{{ old('name') ?? $category->name }}" name="name" class="form-control"> 
                    @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                @if ($category->children->count() < 1)
                <div class="input-group input-group-static mb-4">
                    <label for="parent_id" class="ms-0">Parent Categories</label>
                    <select name="parent_id" class="form-control">
                        <option value="{{$parent->parent_id}}">{{$parent->parent__name}}</option>

                        @foreach ($parentList as $items)
                        <option value="{{ $items->id}}" {{ old('parent_id') == $items->id ? 'selected' : ''}}>{{ $items->name }}</option>
                        @endforeach

                    </select>

                    @error('parent_id')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                    
                @endif

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
