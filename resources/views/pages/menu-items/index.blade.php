@extends('layouts.app')

@section('content')
<div x-data="{
    transactions: {{ Js::from($menuItems) }},
    itemsPerPage: 5,
    currentPage: 1,
    get totalPages() { return Math.ceil(this.transactions.length / this.itemsPerPage); },
    get paginatedTransactions() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.transactions.slice(start, start + this.itemsPerPage);
    },
    getStatusClass(status) {
        return status === 'Success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    },
    prevPage() { if (this.currentPage > 1) this.currentPage--; },
    nextPage() { if (this.currentPage < this.totalPages) this.currentPage++; }
}">

    <div class="rounded-sm border border-stroke bg-white shadow-default p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-xl font-bold text-black">Menu Items List</h4>
            
            <a href="{{ route('menu-items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Item
            </a>
        </div>
        
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-2 text-left">
                    <th class="py-4 px-4 font-medium text-black">Item Name</th>
                    <th class="py-4 px-4 font-medium text-black">Date</th>
                    <th class="py-4 px-4 font-medium text-black">Price</th>
                    <th class="py-4 px-4 font-medium text-black">Category</th>
                    <th class="py-4 px-4 font-medium text-black">Status</th>
                    <th class="py-4 px-4 font-medium text-black">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <template x-for="transaction in paginatedTransactions" :key="transaction.id">
                    <tr>
                        <td class="py-4 px-4" x-text="transaction.name"></td>
                        <td class="py-4 px-4" x-text="transaction.date"></td>
                        <td class="py-4 px-4" x-text="transaction.price"></td>
                        <td class="py-4 px-4" x-text="transaction.category"></td>
                        <td class="py-4 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                  :class="getStatusClass(transaction.status)" 
                                  x-text="transaction.status"></span>
                        </td>
                        <td class="py-4 px-4 flex gap-4">
                            <a :href="'{{ url('/menu-items') }}/' + transaction.id + '/edit'" class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <button 
                                type="button" 
                                class="text-red-500 hover:text-red-700"
                                @click="Swal.fire({
                                    title: 'Delete ye item?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteForm-' + transaction.id).submit();
                                    }
                                })">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            
                            <form :id="'deleteForm-' + transaction.id" :action="'{{ url('/menu-items') }}/' + transaction.id" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        

        <div class="mt-4 flex justify-between">
            <button @click="prevPage" class="px-4 py-2 bg-gray-200 rounded">Prev</button>
            <span x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
            <button @click="nextPage" class="px-4 py-2 bg-gray-200 rounded">Next</button>
        </div>
    </div>
</div>
@endsection