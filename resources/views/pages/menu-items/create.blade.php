@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-sm border border-stroke shadow-default dark:bg-gray-800">
    <h2 class="text-2xl font-bold mb-6 dark:text-white">Add New Menu Item</h2>
    
    <form action="{{ route('menu-items.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-white">Item Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>
        
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-white">Price</label>
            <input type="number" name="price" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Description</label>
            <textarea name="description" rows="3" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-white">Category</label>
            <select name="category_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Save Item</button>
    </form>
</div>
@endsection