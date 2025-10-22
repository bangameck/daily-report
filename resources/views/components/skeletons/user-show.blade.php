<div class="max-w-xl mx-auto p-4 animate-pulse">
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <div class="flex flex-col items-center">
            <div class="w-24 h-24 rounded-full bg-gray-300 border-4 border-white shadow-md"></div>
            <div class="h-6 w-1/2 bg-gray-300 rounded mx-auto mt-4"></div>
            <div class="h-4 w-1/3 bg-gray-300 rounded mx-auto mt-2"></div>
            <div class="h-5 w-16 bg-gray-300 rounded-full mt-2"></div>
        </div>

        <div class="flex justify-around items-center mt-6 pt-4 border-t border-gray-200">
            <div class="text-center">
                <div class="h-5 w-10 bg-gray-300 rounded-md mx-auto"></div>
                <div class="h-3 w-16 bg-gray-300 rounded-md mx-auto mt-2"></div>
            </div>
            <div class="text-center">
                <div class="h-5 w-10 bg-gray-300 rounded-md mx-auto"></div>
                <div class="h-3 w-20 bg-gray-300 rounded-md mx-auto mt-2"></div>
            </div>
        </div>
    </div>

    <nav class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200">
            @for ($i = 0; $i < 5; $i++)
                <div class="flex items-center justify-between p-4 h-[57px]">
                    <div class="flex items-center w-full">
                        <div class="h-6 w-6 bg-gray-300 rounded-md"></div>
                        <div class="h-4 w-1/3 bg-gray-300 rounded ml-4"></div>
                    </div>
                    <div class="h-4 w-1/2 bg-gray-300 rounded-md"></div>
                </div>
            @endfor
        </div>
    </nav>
</div>
