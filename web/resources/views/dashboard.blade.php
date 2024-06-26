

<x-app-layout>
    <x-slot:calendarScripts>
        
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js" media="print"></script>
        <script> 
            document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'CEST',
                initialView: 'timeGridFourDay',
                firstDay: 1,
                headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'timeGridDay,timeGridFourDay,dayGridMonth,listWeek',
                },
                views: {
                timeGridFourDay: {
                    type: 'timeGridWeek',
                    slotMinTime: '7:00:00',
                    slotMaxTime: '17:00:00',
                }
                },
                events: @json($events),
            });

            calendar.render();
            });
        </script>
        <style>
            #calendar table {
                border-radius: 4px;
            }
            @media (prefers-color-scheme: dark) {
                #calendar * {
                    border-color: var(--lt-color-gray-600, #5e636e) !important;
                    color: var(--lt-color-gray-200, #f1f3f9);
                }
                fc .fc-list-event td, .fc .fc-list-event:hover td{
                    background-color: var(--lt-color-gray-800, #2d2f36) !important;
                }
                .fc .fc-list-sticky .fc-list-day > * {
                    background-color: var(--lt-color-gray-800, #2d2f36) !important;
                }

            }
            [class^="fc"][scope="colgroup"] {
                background-color: var(--lt-color-gray-800, #2d2f36);
            }
            @media (prefers-color-scheme: light) {
                #calendar * {
                    color: var(--lt-color-gray-900) !important;
                    border-color: var(--lt-color-gray-400) !important;
                }
            }
        </style>
    </x-slot:calendarScripts>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="calendar" class="py-4 px-4"></div>
            </div>
        </div>
    </div>
    
</x-app-layout>