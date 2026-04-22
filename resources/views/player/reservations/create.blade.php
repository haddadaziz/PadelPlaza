<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Réserver un match</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        .slot-checkbox:checked + label { background-color: #10B981; color: white; border-color: #10B981; transform: scale(1.05); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10B981; }
                /* Animation du cercle vert des terrains */
        .court-radio:checked + div .check-box { background-color: #10B981; border-color: #10B981; }
        .court-radio:checked + div .check-icon { opacity: 1; transform: scale(1); }

    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen overflow-hidden flex flex-col">
        
        <div class="flex items-center gap-4 mb-8 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-black">01</span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">Terrain & Heure</span>
            </div>
            <div class="h-px w-12 bg-slate-200"></div>
            <div class="flex items-center gap-2 opacity-30">
                <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-black">02</span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Options</span>
            </div>
            <div class="h-px w-12 bg-slate-200"></div>
            <div class="flex items-center gap-2 opacity-30">
                <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-black">03</span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Paiement</span>
            </div>
        </div>

        <form action="{{ route('player.reservations.options') }}" method="GET" class="grid grid-cols-12 gap-8 flex-1 overflow-hidden min-h-0">
            
            <div class="col-span-7 flex flex-col min-h-0">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-6 shrink-0">Choisissez votre Court</h3>
                
                <div class="flex-1 overflow-y-auto pr-4 space-y-4 pb-6 custom-scrollbar">
@foreach($courts as $court)
<label class="relative block {{ $court->is_active ? 'cursor-pointer' : 'cursor-not-allowed opacity-60' }} group">
    <input type="radio" name="court_id" value="{{ $court->id }}" class="peer sr-only court-radio" required {{ !$court->is_active ? 'disabled' : '' }}>
    
    <div class="bg-white p-6 rounded-[2.5rem] border-2 border-transparent {{ $court->is_active ? 'peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30' : 'bg-slate-50' }} transition-all flex items-center gap-6 shadow-sm hover:shadow-md">
        <div class="w-28 h-28 rounded-3xl bg-slate-100 overflow-hidden shrink-0">
            <img src="{{ asset('storage/'.$court->image) }}" class="w-full h-full object-cover transition-all {{ !$court->is_active ? 'grayscale' : '' }}">
        </div>
        
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-lg font-black text-slate-900 uppercase tracking-tight leading-tight">{{ $court->name }}</h4>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[9px] font-black {{ $court->is_active ? 'text-emerald-500' : 'text-red-500' }} uppercase tracking-widest">
                            {{ $court->is_active ? '● Disponible' : '● En Maintenance' }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-[900] text-emerald-500 leading-none">{{ $court->price_coins }} <span class="text-[10px]">PC</span></p>
                    <p class="text-[8px] font-bold text-slate-300 uppercase tracking-widest mt-1">/ Heure</p>
                </div>
            </div>
        </div>

        @if($court->is_active)
        <div class="w-6 h-6 rounded-full border-2 border-slate-100 flex items-center justify-center transition-colors duration-300 check-box">
            <i class="fas fa-check text-white text-[10px] opacity-0 scale-50 transition-all duration-300 check-icon"></i>
        </div>
        @else
        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fas fa-lock text-slate-300 text-[10px]"></i>
        </div>
        @endif
    </div>
</label>
@endforeach

                </div>
            </div>

            <div class="col-span-5 flex flex-col gap-6 min-h-0">
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm shrink-0">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Date du match</label>
                    <input type="date" name="date" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-3.5 font-black text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all">
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex-1 flex flex-col min-h-0 relative">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block shrink-0">Période & Horaire</label>
                    
                    <div class="grid grid-cols-3 gap-2 mb-6 shrink-0">
                        <button type="button" onclick="filterByPeriod('night')" id="btn-night" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase text-slate-500 transition-all hover:bg-slate-100">
                            <i class="fas fa-moon mr-1"></i> 00h-08h
                        </button>
                        <button type="button" onclick="filterByPeriod('day')" id="btn-day" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase text-slate-500 transition-all hover:bg-slate-100">
                            <i class="fas fa-sun mr-1"></i> 08h-16h
                        </button>
                        <button type="button" onclick="filterByPeriod('evening')" id="btn-evening" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase text-slate-500 transition-all hover:bg-slate-100">
                            <i class="fas fa-stars mr-1"></i> 16h-00h
                        </button>
                    </div>

                    <div id="time-slots-container" class="flex-1 overflow-y-auto pr-2 pb-4 grid grid-cols-2 gap-3 custom-scrollbar">
                        <div class="col-span-2 text-center py-10">
                            <p class="text-[10px] font-bold text-slate-400">Veuillez choisir un terrain et une date.</p>
                        </div>
                    </div>

                    <button id="submit-btn" type="submit" disabled class="mt-4 bg-slate-900 text-white w-full py-4 rounded-[1.2rem] font-[900] uppercase tracking-widest hover:bg-emerald-500 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 shrink-0 opacity-50 cursor-not-allowed">
                        Suivant <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>

        </form>
    </main>

    <script>
        let allAvailableSlots = [];

        function filterByPeriod(period) {
            const container = document.getElementById('time-slots-container');
            const submitBtn = document.getElementById('submit-btn');
            
            document.querySelectorAll('.period-btn').forEach(btn => {
                btn.classList.remove('bg-emerald-500', 'text-white');
                btn.classList.add('bg-slate-50', 'text-slate-500');
            });
            document.getElementById('btn-' + period).classList.remove('bg-slate-50', 'text-slate-500');
            document.getElementById('btn-' + period).classList.add('bg-emerald-500', 'text-white');

            let min, max;
            if (period === 'night') { min = 0; max = 7; }
            else if (period === 'day') { min = 8; max = 15; }
            else { min = 16; max = 23; }

            const filtered = allAvailableSlots.filter(slot => {
                const hour = parseInt(slot.split(':')[0]);
                return hour >= min && hour <= max;
            });

            container.innerHTML = '';
            if (filtered.length === 0) {
                container.innerHTML = '<div class="col-span-2 text-center py-10"><p class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Aucun créneau libre</p></div>';
            } else {
                filtered.forEach((time, index) => {
                    container.insertAdjacentHTML('beforeend', `
                        <div class="relative">
                            <input type="radio" name="time_slot" id="slot-${index}" value="${time}" class="sr-only slot-checkbox" required>
                            <label for="slot-${index}" class="flex items-center justify-center py-4 bg-slate-50 border border-slate-100 rounded-2xl text-[11px] font-black text-slate-500 cursor-pointer transition-all hover:bg-emerald-50 hover:border-emerald-200 uppercase tracking-tight">
                                ${time}
                            </label>
                        </div>
                    `);
                });
                
                document.querySelectorAll('.slot-checkbox').forEach(radio => {
                    radio.addEventListener('change', () => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                });
            }
        }

        function fetchSlots() {
            const courtId = document.querySelector('input[name="court_id"]:checked')?.value;
            const date = document.querySelector('input[name="date"]').value;
            const container = document.getElementById('time-slots-container');
            const submitBtn = document.getElementById('submit-btn');

            if (courtId && date) {
                container.innerHTML = '<div class="col-span-2 text-center py-10"><i class="fas fa-spinner fa-spin text-emerald-500 mb-2"></i><p class="text-[10px] font-black text-emerald-500 uppercase animate-pulse">Chargement...</p></div>';
                
                fetch(`/api/available-slots?court_id=${courtId}&date=${date}`)
                    .then(res => res.json())
                    .then(data => {
                        allAvailableSlots = data.available_slots;
                        container.innerHTML = '<div class="col-span-2 text-center py-10"><p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Choisissez une période ↑</p></div>';
                        document.querySelectorAll('.period-btn').forEach(btn => {
                            btn.classList.remove('bg-emerald-500', 'text-white');
                            btn.classList.add('bg-slate-50', 'text-slate-500');
                        });
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    });
            }
        }

        document.querySelectorAll('input[name="court_id"]').forEach(radio => radio.addEventListener('change', fetchSlots));
        document.querySelector('input[name="date"]').addEventListener('change', fetchSlots);
        document.querySelector('input[name="date"]').setAttribute('min', new Date().toISOString().split('T')[0]);
    </script>

</body>
</html>