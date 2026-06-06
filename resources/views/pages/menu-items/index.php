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

    <div class="rounded-sm border border-stroke bg-white shadow-default p-6 dark:border-gray-700 dark:bg-gray-800">
        <h4 class="mb-6 text-xl font-bold text-black dark:text-white">Menu Items List</h4>
        
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Item Name</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Date</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Price</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Category</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="transaction in paginatedTransactions" :key="transaction.id">
                        <tr>
                            <td class="py-4 px-4 dark:text-gray-300" x-text="transaction.name"></td>
                            <td class="py-4 px-4 dark:text-gray-300" x-text="transaction.date"></td>
                            <td class="py-4 px-4 dark:text-gray-300" x-text="transaction.price"></td>
                            <td class="py-4 px-4 dark:text-gray-300" x-text="transaction.category"></td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="getStatusClass(transaction.status)" 
                                      x-text="transaction.status"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <button @click="prevPage" class="px-4 py-2 bg-gray-200 rounded dark:bg-gray-700 dark:text-white">Prev</button>
            <span class="dark:text-white" x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
            <button @click="nextPage" class="px-4 py-2 bg-gray-200 rounded dark:bg-gray-700 dark:text-white">Next</button>
        </div>
    </div>
</div>
@endsection