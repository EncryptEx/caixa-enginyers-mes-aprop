<?php 
use Carbon\Carbon;

function getDirectionsUrl($source, $destination)
{
    // Replace spaces with '+'
    $formattedSource = str_replace(' ', '+', $source);
    $formattedDestination = str_replace(' ', '+', $destination);

    // Construct the Google Maps URL
    $url = "https://www.google.com/maps/dir/?api=1&origin={$formattedSource}&destination={$formattedDestination}";

    return $url;
}


?>



<x-app-layout>
    <style>
        .progress-circle {
            position: relative;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: conic-gradient(rgb(96 165 250 / var(--tw-text-opacity,1)) 0%, #4caf50 0%, #ddd 0%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #progress-text {
            font-size: 24px;
            color: var(--lt-color-gray-700, #f1f3f9);
            background-color: var(--lt-color-gray-800, #1d1e20);
            border-radius: 50%;
            width: 75%;
            height: 75%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media screen and (prefers-color-scheme: dark) {
            #progress-text {
                color: var(--lt-color-gray-200);
            }
        }

        #progress-input {
            margin-top: 20px;
            width: 300px;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('En viu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- card with title and time remaining -->
                <div class="py-4 px-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 leading-tight items-center justify-center text-center">
                        @if(isset($event))
                            @if ($event['tipus'] == 'sortida')
                                Conduïnt cap a <u>{{ $event['desti'] }}</u> desde <u>{{ $event['lloc_sortida'] }} </u>.
                                <br>Link a la ubicació: <a href="{{ getDirectionsUrl($event['lloc_sortida'], $event['desti']) }}"
                                    class="text-blue-500 dark:text-blue-400"> aquí.</a>
                            @else
                                Servei a {{ $event['lloc_arribada'] }} durant {{ $event['duracio_estada'] }} minuts.
                            @endif
                        @else 
                            Ja has acabat! Passa un bon dia!
                        @endif

                    </h2>
                        <p class="text-gray-500 dark:text-gray-400 text-center">
                        @if (isset($event))
                                @if ($event['tipus'] == 'sortida')
                                    {{ __('Arribada d\'aqui: ') }}
                                @else
                                    {{ __('Temps restant: ') }}

                                @endif
                            </p>
                            <br>


                            <div class="progress-circle mx-auto" id="progress-circle">
                                <span id="progress-text">
                                    <span id="text" class="text-gray-500 dark:text-gray-400 text-4xl"></span>
                                </span>

                            </div>
                        @endif
                </div>
            </div>
        </div>

        @if(isset($event))
            <script>

                // Set the date we're counting down to (ISO 8601 format)

                // Update the count down every 1 second


                const countdownFunction = setInterval(function () { repeat(); }, 1000);

                const progressCircle = document.getElementById('progress-circle');
                const progressText = document.getElementById('progress-text');
                function repeat() {

                    // Get today's date and time
                    const now = new Date().getTime();
                    const startTemp = {{ Carbon::parse($event['hora'])->timestamp }} * 1000 ;
                    @if ($event['tipus'] == 'sortida')
                        const endTemp = startTemp + {{ 60 * $event['temps_trajecte'] }} * 1000;
                    @else
                        const endTemp = startTemp + {{ 60 * $event['duracio_estada'] }} * 1000;
                    @endif
                    const countDownDate = endTemp;
                    const totalDuration = endTemp - startTemp;

                    // Find the distance between now and the count down date
                    const distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);


                    const percentage = 100 - Math.min((distance / totalDuration) * 10, 100).toFixed(2);



                    // Display the result in the element with id="timer"
                    let timeString = "";

                    if (days > 0) {
                        timeString += days + "d ";
                    }
                    if (hours > 0) {
                        timeString += hours + "h ";
                    }
                    if (minutes > 0) {
                        timeString += minutes + "m ";
                    }
                    if (seconds > 0) {
                        timeString += seconds + "s ";
                    }

                    document.getElementById("text").innerHTML = timeString.trim();


                    updateProgress(percentage);

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(countdownFunction);
                        document.getElementById("timer").innerHTML = "EXPIRED";
                    }
                }
                repeat();

                function updateProgress(value) {
                    const percentage = Math.min(Math.max(value, 0), 100);
                    const degree = (percentage / 100) * 360;

                    progressCircle.style.background = `conic-gradient(rgb(96 165 250 / var(--tw-text-opacity,1)) ${degree}deg, #ddd ${degree}deg)`;
                }
            </script>
        @endif
</x-app-layout>