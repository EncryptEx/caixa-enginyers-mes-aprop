<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Formulari de satisfacció') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">

                    <form method="POST" action="{{ route('form') }}">
                        @csrf

                        <div class="mt-1">
                            <x-input-label for="rating" :value="__('Com valores la duració de l\'estada de la furgoneta?')" class="text-blue-700 dark:text-blue-300" />
                        </div>
                        <div class="mt-4">
                            <div class="mt-2 flex space-x-4 star-rating">
                                <input type="hidden" name="rating" id="rating" value="">     <!-- store the rating in a hidden variable -->
                                <span class="fa fa-star text-black-700 dark:text-black-300" data-value="1"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300" data-value="2"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300" data-value="3"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300" data-value="4"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300" data-value="5"></span>
                            </div>
                            <x-input-error :messages="$errors->get('option')" class="mt-2" />
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const stars = document.querySelectorAll('.star-rating .fa-star');
                                const ratingInput = document.getElementById('rating');

                                stars.forEach((star, index) => {
                                    star.addEventListener('click', function() {
                                        const value = this.getAttribute('data-value');
                                        ratingInput.value = value; // Set the hidden input value
                                        console.log('Rating:', value);
                                        
                                        stars.forEach((s, i) => {
                                            s.classList.toggle('checked', i <= index);
                                        });
                                    });
                                });
                            });
                        </script>

                        <style>
                            .fa-star.checked {
                                color: #3B82F6;
                            }
                        </style>

                        <div class="mt-3">
                            <x-input-label for="q2" :value="__('En cas que hagi faltat temps, intodueix quants minuts més farien falta:')" class="text-blue-700 dark:text-blue-300" />
                            <textarea id="q2" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="question" rows="4" required></textarea>
                            <x-input-error :messages="$errors->get('question')" class="mt-4" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
