<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 py-4 animate-pulse">
    <div class="mb-4 p-4 bg-white rounded-lg shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center">
            <div class="h-10 bg-gray-300 rounded-md w-full sm:w-1/2"></div>
            <div class="h-10 bg-gray-300 rounded-md w-40 mt-3 sm:mt-0 sm:ml-4"></div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200">
            @for ($i = 0; $i < 5; $i++)
                <div class="p-4 flex items-center justify-between space-x-4">
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/3"></div>
                    </div>
                    <div class="h-5 w-5 bg-gray-300 rounded-full"></div>
                </div>
            @endfor
        </div>
    </div>
</div>
