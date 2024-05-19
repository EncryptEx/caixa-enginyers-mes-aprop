<x-app-layout>
    <x-slot:calendarScripts>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
        <style>
            #map {
                height: 500px;
                width: 100%;
            }
        </style>
    </x-slot:calendarScripts>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mapa d\'avui') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([42.0, 2.2], 8); // Center the map on a specific location

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Function to add a route to the map
        function addRoute(departure, destination) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${departure}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var departureLatLng = [data[0].lat, data[0].lon];
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${destination}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    var destinationLatLng = [data[0].lat, data[0].lon];
                                    var route = L.polyline([departureLatLng, destinationLatLng], { color: 'blue' }).addTo(map);
                                    map.fitBounds(route.getBounds());
                                }
                            });
                    }
                });
        }

        // Plot routes from data
        @foreach ($events as $item)
       
                addRoute('{{ $item["lloc_sortida"] }}', '{{ $item["desti"] }}');
       
        @endforeach
    </script>


</x-app-layout>