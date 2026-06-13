@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="font-bold mb-4">Add New Category</h3>
        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="name" placeholder="Category Name" class="border p-2 rounded flex-1" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <table class="w-full">
            @foreach($categories as $category)
            <tr class="border-b">
                <td class="py-3">{{ $category->name }}</td>
                <td class="py-3 text-right">
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection