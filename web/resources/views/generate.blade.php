<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transmètre als clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">

                    <form method="POST" action="{{ route('generatePost') }}">
                        @csrf                       

                        <div class="flex items-center mt-4">
                            <div>

                                <!-- text to explain what this does -->
                                <p class="text-gray-700 dark:text-gray-300 font-bold">Aquesta funció és una acció irreversible. Si us plau, assegura't de voler regenerar el calendari.
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        Recomanem executar aquesta funció un cop al mes.
                                    </p>    
                                    <br>
                                    <x-danger-button class="">
                                        {{ __('Regenerar calendari') }}
                                    </x-danger-button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
