<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Réservation Manuelle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        .slot-checkbox:checked + label { background-color: #10B981; color: white; border-color: #10B981; transform: scale(1.05); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen flex flex-col overflow-hidden">
        
        <div class="mb-8 shrink-0">
            <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2 gap-2">
                <a href="/admin/reservations" class="hover:text-emerald-500 transition-colors">Réservations</a>
                <span>/</span>
                <span class="text-slate-900">Ajout Manuel</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase">Nouvelle Réservation</h2>
        </div>

        <form action="{{ route('admin.reservations.store') }}" method="POST" class="grid grid-cols-12 gap-8 flex-1 min-h-0">
            @csrf

            <div class="col-span-7 flex flex-col min-h-0 space-y-6 overflow-y-auto pr-4 custom-scrollbar pb-10">
                
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block italic">Client / Joueur</label>
                    <select name="user_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                        <option value="" disabled selected>Rechercher un joueur...</option>
                        @foreach($players as $player)
                            <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->email }})</option>
                        @endforeach
                    </select>
                    <p class="mt-3 text-[9px] text-slate-400 font-bold italic uppercase"><i class="fas fa-info-circle mr-1"></i> Si le joueur n'existe pas, créez son compte d'abord.</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 block italic">Sélectionner le Court</label>
                    <div class="space-y-3">
                        @foreach($courts as $court)
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="court_id" value="{{ $court->id }}" class="peer sr-only" required onchange="fetchSlots()">
                            <div class="p-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm">
                                        <i class="fas fa-table-tennis text-sm"></i>
                                    </div>
                                    <span class="font-black text-slate-900 uppercase italic text-sm">{{ $court->name }}</span>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 italic">{{ $court->price_coins }} PC / H</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                    <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-4 block italic relative z-10">Statut du paiement</label>
                    <div class="flex gap-4 relative z-10">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_status" value="paid" class="peer sr-only" checked>
                            <div class="py-3 text-center rounded-xl bg-white/5 border border-white/10 text-white font-black text-[10px] uppercase tracking-widest italic peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all">Déjà payé</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_status" value="pending" class="peer sr-only">
                            <div class="py-3 text-center rounded-xl bg-white/5 border border-white/10 text-white font-black text-[10px] uppercase tracking-widest italic peer-checked:bg-amber-500 peer-checked:border-amber-500 transition-all">À payer sur place</div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-span-5 flex flex-col min-h-0 gap-6">
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm shrink-0">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block italic">Date du match</label>
                    <input type="date" name="date" id="date-input" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-black italic text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all outline-none" onchange="fetchSlots()">
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex-1 flex flex-col min-h-0">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block italic shrink-0">Période & Horaire</label>
                    
                    <div class="grid grid-cols-3 gap-2 mb-6 shrink-0">
                        <button type="button" onclick="filterByPeriod('night')" id="btn-night" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase italic text-slate-500 transition-all">00h-08h</button>
                        <button type="button" onclick="filterByPeriod('day')" id="btn-day" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase italic text-slate-500 transition-all">08h-16h</button>
                        <button type="button" onclick="filterByPeriod('evening')" id="btn-evening" class="period-btn py-3 rounded-xl bg-slate-50 text-[8px] font-black uppercase italic text-slate-500 transition-all">16h-00h</button>
                    </div>

                    <div id="time-slots-container" class="flex-1 overflow-y-auto pr-2 pb-4 grid grid-cols-2 gap-3 custom-scrollbar">
                        <div class="col-span-2 text-center py-10 text-[10px] font-bold text-slate-400 italic uppercase">Choisissez un court et une date</div>
                    </div>

                    <button type="submit" id="submit-btn" disabled class="mt-4 bg-slate-900 text-white w-full py-5 rounded-[1.5rem] font-[900] uppercase italic tracking-widest hover:bg-emerald-500 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 shrink-0 opacity-50 cursor-not-allowed">
                        Enregistrer la réservation <i class="fas fa-save text-[10px]"></i>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        let allAvailableSlots = [];

        function fetchSlots() {
            const courtId = document.querySelector('input[name="court_id"]:checked')?.value;
            const date = document.getElementById('date-input').value;
            const container = document.getElementById('time-slots-container');

            if (courtId && date) {
                container.innerHTML = '<div class="col-span-2 text-center py-10"><i class="fas fa-circle-notch fa-spin text-emerald-500 text-xl"></i></div>';
                fetch(`/api/available-slots?court_id=${courtId}&date=${date}`)
                    .then(res => res.json())
                    .then(data => {
                        allAvailableSlots = data.available_slots;
                        container.innerHTML = '<div class="col-span-2 text-center py-10 text-[10px] font-bold text-emerald-500 italic uppercase animate-pulse">Sélectionnez une période ↑</div>';
                        document.querySelectorAll('.period-btn').forEach(btn => btn.classList.remove('bg-emerald-500', 'text-white'));
                    });
            }
        }

        function filterByPeriod(period) {
            const container = document.getElementById('time-slots-container');
            const submitBtn = document.getElementById('submit-btn');
            
            document.querySelectorAll('.period-btn').forEach(btn => {
                btn.classList.remove('bg-emerald-500', 'text-white');
                btn.classList.add('bg-slate-50', 'text-slate-500');
            });
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
                container.innerHTML = '<div class="col-span-2 text-center py-10 text-[10px] font-bold text-red-400 italic uppercase">Aucun créneau libre</div>';
            } else {
                filtered.forEach((time, index) => {
                    container.insertAdjacentHTML('beforeend', `
                        <div class="relative">
                            <input type="radio" name="time_slot" id="slot-${index}" value="${time}" class="sr-only slot-checkbox" required>
                            <label for="slot-${index}" class="flex items-center justify-center py-4 bg-slate-50 border border-slate-100 rounded-2xl text-[11px] font-black text-slate-500 italic cursor-pointer transition-all hover:bg-emerald-50 uppercase tracking-tighter">
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
    </script>
</body>
</html>