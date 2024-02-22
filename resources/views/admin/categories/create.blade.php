@extends('admin.layouts.app')

@section('title', 'Create category')
@section('content')

<div class="card">
        <h1>Create role</h1>

        <div>
            <form action="{{ route('categories.store') }}" method="post">
                @csrf

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control"> 
                    @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="parent_id" class="ms-0">Parent Categories</label>
                    <select name="parent_id" class="form-control">
                        <option value="">Select parent category</option>

                        @foreach ($parent as $items)
                        <option value="{{ $items->id}}" {{ old('parent_id') == $items->id ? 'selected' : ''}}>{{ $items->name }}</option>
                        @endforeach

                    </select>

                    @error('parent_id')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection