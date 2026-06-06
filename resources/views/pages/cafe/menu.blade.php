<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cafe->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800">{{ $cafe->name }}</h1>
        <p class="text-center text-gray-500 mt-2">{{ $cafe->description }}</p>

        @foreach($cafe->categories as $category)
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-orange-600 border-b pb-2">{{ $category->name }}</h2>
                
                @foreach($category->menuItems as $item)
                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <h3 class="font-bold">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-400">{{ $item->description }}</p>
                        </div>
                        <span class="font-bold">₹{{ number_format($item->price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>
</html>