<x-app-layout>
    <x-slot:calendarScripts>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
        <style>
            #map {
                height: 50rem;
                width: 100%;
            }
            .leaflet-top .leaflet-routing-container:nth-of-type(1){
                display: none; 
            }

            /* Customize the appearance of the turn instruction container */
            .leaflet-routing-container {
                background-color: #fff;
                border: 2px solid #3388ff;
                border-radius: 5px;
                padding: 10px;
            }

            /* Customize the appearance of turn instruction text */
            .leaflet-routing-conain {
                background-color: #fff;
                color: #333;
                font-size: 14px;
            }

            /* Customize the appearance of turn instruction icons */
            .leaflet-routing-icon {
                background-color: #fff;
                width: 24px;
                height: 24px;
                margin-right: 5px;
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
            <div id="route-directions" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <script defer>
        // Initialize the map
        var map = L.map('map').setView([42.0, 2.2], 8); // Center the map on a specific location

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        var control = L.Routing.control({
            lineOptions: {
                styles: [{ color: '#3388ff', weight: 5, opacity: 0.7 }]
            }
        }).addTo(map);

        // Function to add a route to the map
        function addRoute(departure, destination) {
            fetch(`{{ env('DATA_URI') }}/discover/${departure}`)
                .then(response => response.json())
                .then(data => {

                    console.log(data);
                    var departureLatLng = [data.lat, data.lon];
                    fetch(`{{ env('DATA_URI') }}/discover/${destination}`)
                        .then(response => response.json())
                        .then(data2 => {
                            ways(data.lat, data.lon, data2.lat, data2.lon);
                        });

                });
        }

        // Plot routes from data
        @foreach ($events as $item)

            addRoute('{{ $item["lloc_sortida"] }}', '{{ $item["desti"] }}');

        @endforeach

        function ways(p1lat, p1lon, p2lat, p2lon) {
            L.Routing.control({
                waypoints: [
                    L.latLng(p1lat, p1lon),
                    L.latLng(p2lat, p2lon)
                ],
                routeWhileDragging: true
            }).addTo(map);
        }



        
        // control.on('routesfound', function(e) {
        //     var routes = e.routes;
        //     var directionsDiv = document.getElementById('route-directions');
        //     directionsDiv.innerHTML = ''; // Clear previous directions

        //     routes.forEach(function(route, index) {
        //         route.instructions.forEach(function(instruction) {
        //             var instructionDiv = document.createElement('div');
        //             instructionDiv.classList.add('instruction');
        //             instructionDiv.textContent = instruction.text;
        //             directionsDiv.appendChild(instructionDiv);
        //         });
        //     });
        // });


    </script>


</x-app-layout>