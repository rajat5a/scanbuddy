@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-sm border border-stroke shadow-default">
    <h2 class="text-2xl font-bold mb-6">Edit Menu Item</h2>
    
    <form action="{{ route('menu-items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-4">
            <label class="block mb-2 text-sm font-medium">Category</label>
            <select name="category_id" class="w-full p-2 border rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium">Item Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium">Price</label>
            <input type="number" name="price" value="{{ $item->price }}" class="w-full p-2 border rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update Item</button>
    </form>
</div>
@endsection