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


                        <div class="mt-7 mb-10">
                            <x-input-label for="poblacio" :value="__('Intodueix el nom del teu municipi:')" class="text-blue-700 dark:text-blue-300" />
                      <!-- store the rating in a hidden variable       <input id="poblacio" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="municipi" rows="4" required>    --> 
                            <select id="poblacio" class="block mt-7 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="municipi" required>
                                <option value="" selected disabled>Selecciona el municipi</option>
                                <?php $municipis = ["Calonge de Segarra", "Castellfollit de Riubregós", "Prats de Rei", "Pujalt", "Sant Pere Sallavinera", "Sant Martí Sesgueioles", "Argençola", "Copons", "Jorba", "Montmaneu", "Rubió", "Veciana", "Bellprat", "Bruc", "Castellolí", "Orpí", "Santa Maria de Miralles", "Cabrera d\'Anoia", "Torre de Claramunt", "Vallbona d\'Anoia", "Llacuna", "Conesa", "Llorac", "Passanant i Belltall", "Piles", "Savallà del Comtat", "Vallfogona de Riucorb", "Forès", "Rocafort de Queralt", "Carme", "Mediona", "Font-rubí", "Pontons", "Torrelles de Foix", "Cabanyes", "Pacs del Penedès", "Sant Cugat Sesgarrigues", "Santa Fe del Penedès", "Vilobí del Penedès", "Castellet i la Gornal", "Albinyana", "Bonastre", "Santa Oliva", "Olivella", "Olesa de Bonesvalls", "Puigdàlber", "Sant Llorenç d\'Hortons", "Subirats", "Torrelavit", "Masllorenç", "Montmell", "Salomó", "Vespella de Gaià", "Blancafort", "Pira", "Senan", "Aiguamúrcia", "Cabra del Camp", "Querol", "Pontils", "Figuerola del Camp", "Montferri", "Rodonyà", "Vallclara", "Vilanova de Prades", "Mont-ral", "Riba", "Vilaverd", "Garidells", "Masó", "Milà", "Vallmoll", "Alió", "Bràfim", "Puigpelat", "Vilabella", "Nulles", "Rourell", "Argentera", "Botarell", "Colldejou", "Pratdip", "Riudecanyes", "Vilanova d\'Escornalbou", "Aleixar", "Alforja", "Duesaigües", "Maspujols", "Riudecols", "Arbolí", "Capafonts", "Febró", "Vilaplana", "Albiol", "Almoster", "Perafort", "Pobla de Mafumet", "Vilallonga del Camp", "Nou de Gaià", "Riera de Gaià", "Catllar", "Secuita", "Renau", "Montblanc", "Campllong", "Llambilles", "Sant Andreu Salou", "Massanes", "Sant Feliu de Buixalleu", "Aiguaviva", "Sant Martí de Llémena", "Brunyola i Sant Martí Sapresa", "Osor", "Susqueda", "Sant Miquel de Campmajor", "Mieres", "Sant Aniol de Finestres", "Canet d\'Adri", "Camós", "Palau-sator", "Regencós", "Vall-llobrega", "Cruïlles nells i Sant", "Sadurní de l\'Heura", "Forallac", "Parlavà", "Pera", "Rupià", "Juià", "Madremanya", "Sant Martí Vell", "Corçà", "Foixà", "Fontanilles", "Gualta", "Serra de Daró", "Ullà", "Colomers", "Garrigoles", "Tallada d\'Empordà", "Vilopriu", "Cervià de Ter", "Palol de Revardit", "Ventalló", "Viladamat", "Albons", "Bellcaire d\'Empordà", "Sant Miquel de Fluvià", "Torroella de Fluvià", "Vilaür", "Vilamacolum", "Vilademuls", "Maià de Montcal", "Sant Ferriol", "Crespià", "Esponellà", "Fontcoberta", "Argelaguer", "Riudaura", "Sant Jaume de Llierca", "Vall de Bianya", "Albanyà", "Montagut i Oix", "Sales de Llierca", "Tortellà", "Borrassà", "Siurana", "Garrigàs", "Navata", "Far d\'Empordà", "Fortià", "Riumors", "Santa Llogaia d\'Àlguema", "Vila-sacra", "Cabanes", "Pau", "Pedret i Marzà", "Selva de Mar", "Avinyonet de Puigventós", "Cabanelles", "Lladó", "Vilanant", "Boadella i les Escaules", "Cistella", "Sant Llorenç de la Muga", "Terrades", "Masarac", "Mollet de Peralada", "Capmany", "Pont de Molins", "Espolla", "Rabós", "Vilamaniscle", "Vajol", "Cantallops", "Ordis", "Palau de Santa Eulàlia", "Pontós", "Vilafant", "Vilamalla", "Biure", "Beuda", "Jafre", "Torrent", "Ultramort", "Ullastret", "Sant Joan de Mollet", "Viladasens", "Fogars de la Selva", "Girona", "Marganell", "Castellví de Rosanes", "Collbató", "Rellinars", "Ullastrell", "Òrrius", "Santa Maria de Martorelles", "Vallgorguina", "Vilalba Sasserra", "Campins", "Cànoves i Samalús", "Fogars de Montclús", "Gualba", "Sant Pere de Vilamajor", "Castellfollit del Boix", "Castellgalí", "Mura", "Talamanca", "Sant Llorenç Savall", "Gallifa", "Tagamanent", "Figaró-Montmany", "Montseny", "Sant Esteve de Palautordera", "Aguilar de Segarra", "Fonollosa", "Rajadell", "Castellnou de Bages", "Sant Mateu de Bages", "Granera", "Monistrol de Calders", "Sant Quirze Safaja", "Calders", "Castellcir", "Collsuspina", "Estany", "Sant Feliu Sasserra", "Viver i Serrateix", "Sagàs", "Santa Maria de Merlès", "Olost", "Oristà", "Sant Martí d\'Albars", "Sobremunt", "Olvan", "Lluçà", "Perafita", "Alpens", "Malla", "Muntanyola", "Folgueroles", "Santa Eugènia de Berga", "Santa Eulàlia de Riuprimer", "Vilanova de Sau", "Sant Martí de Centelles", "Gurb", "Masies de Roda", "Santa Cecília de Voltregà", "Tavertet", "Rupit i Pruit", "Sant Bartomeu del Grau", "Masies de Voltregà", "Orís", "Sant Boi de Lluçanès", "Santa Maria de Besora", "Sant Vicenç de Torelló", "Sora", "Vidrà", "Montesquiu", "Sant Agustí de Lluçanès", "Tavèrnoles", "Sant Sadurní d\'Osormort", "Espinelves", "Brull", "Espunyola", "Montclar", "Capolat", "Castellar del Riu", "Fígols", "Nou de Berguedà", "Quar", "Vilada", "Llosses", "Vallfogona de Ripollès", "Borredà", "Castell de l\'Areny", "Sant Jaume de Frontanyà", "Vallcebre", "Sant Julià de Cerdanyola", "Gisclareny", "Saldes", "Gósol", "Castellar de n\'Hug", "Campelles", "Gombrèn", "Planoles", "Toses", "Setcases", "Llanars", "Molló", "Ogassa", "Vilallonga de Ter", "Pardines", "Queralbs", "Vic"]; ?>
                                @foreach ($municipis as $municipi)
                                    <option value="{{ $municipi }}">{{ $municipi }}</option>
                                
                                @endforeach

                            </select>
                        <x-input-error :messages="$errors->get('municipi')" class="mt-4" />
                        </div>


                        <style>
                            .scl2{
                                scale:2;
                            }
                        </style>

                        <div class="mt-1">
                            <x-input-label for="rating" :value="__('Com valores la duració de l\'estada de la furgoneta?')" class="text-blue-700 dark:text-blue-300" />
                        </div>
                        <div class="mt-4 mb-8">
                            <div class="mt-2 flex space-x-4 star-rating">
                                <input type="hidden" name="rating" id="rating" value="">     <!-- store the rating in a hidden variable -->
                                <span class="fa fa-star text-black-700 dark:text-black-300 scl2" data-value="1"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300 scl2" data-value="2"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300 scl2" data-value="3"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300 scl2" data-value="4"></span>
                                <span class="fa fa-star text-black-700 dark:text-black-300 scl2" data-value="5"></span>
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
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

                        <div class="mt-3 mb-7">
                            <x-input-label for="q2" :value="__('En cas que hagi faltat temps, intodueix quants minuts més farien falta:')" class="text-blue-700 dark:text-blue-300" />
                            <input id="q2" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="time_increment" rows="4" required>
                            <x-input-error :messages="$errors->get('time_increment')" class="mt-4" />
                        </div>


                        <!-- Time interval -->
                    
                        <div class="mt-5">
                            <x-input-label for="timetable" :value="__('A quina franja t\'agradaria més que arribessim al teu municipi?')" class="text-gray-700 dark:text-gray-300" />
                            <input type="hidden" name="timetable" id="timetable" value=""> 
                            <div class="mt-6 flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-indigo-600 dark:text-indigo-400" name="option" value="1" required>
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Matí</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-indigo-600 dark:text-indigo-400" name="option" value="2">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Migdia</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-indigo-600 dark:text-indigo-400" name="option" value="3">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Tarda</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('option')" class="mt-6" />
                        </div>


                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const radioButtons = document.querySelectorAll('input[name="option"]');
                                const timetableInput = document.getElementById('timetable');

                                radioButtons.forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        timetableInput.value = this.value; // Set the hidden input value to the selected radio button value
                                        console.log('Selected timetable:', this.value);
                                    });
                                });
                            });
                        </script>



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
