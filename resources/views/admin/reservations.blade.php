<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Admin Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; overflow-x: hidden; }
        .arena-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-8 flex flex-col h-screen overflow-hidden">
        
        <div class="flex justify-between items-end mb-8 shrink-0">
            <div>
                <h2 class="text-4xl font-[900] text-slate-900 tracking-tighter italic uppercase">Planning <span class="text-emerald-500">Global</span></h2>
                <p class="text-slate-400 font-bold italic text-sm mt-1">Supervision et gestion des créneaux de l'Arena.</p>
            </div>
            
            <a href="{{ route('admin.reservations.create') }}" class="arena-gradient text-white px-8 py-4 rounded-[2rem] font-black shadow-2xl shadow-slate-300 transition-all hover:scale-105 active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest italic">
                <i class="fas fa-plus-circle"></i> Ajouter un Match
            </a>
        </div>

        <form action="{{ route('admin.reservations.index') }}" method="GET" class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-8 flex items-end gap-6 shrink-0">
            <div class="flex-1 flex flex-col gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2 italic">Jour de Match</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-emerald-500 group-focus-within:text-slate-900 transition-colors">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                           class="w-full bg-slate-50 border-2 border-transparent rounded-[1.5rem] pl-12 pr-6 py-4 text-xs font-[900] uppercase italic text-slate-700 outline-none focus:bg-white focus:border-emerald-500/30 focus:ring-4 focus:ring-emerald-500/5 transition-all cursor-pointer">
                </div>
            </div>

            <div class="flex-1 flex flex-col gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2 italic">Sélection Terrain</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-emerald-500 group-focus-within:text-slate-900 transition-colors">
                        <i class="fas fa-table-tennis-paddle-ball"></i>
                    </div>
                    <select name="court_id" class="w-full bg-slate-50 border-2 border-transparent rounded-[1.5rem] pl-12 pr-10 py-4 text-xs font-[900] uppercase italic text-slate-700 outline-none focus:bg-white focus:border-emerald-500/30 focus:ring-4 focus:ring-emerald-500/5 transition-all cursor-pointer appearance-none">
                        <option value="">Tous les terrains</option>
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}" {{ request('court_id') == $court->id ? 'selected' : '' }}>{{ $court->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-300">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="bg-slate-900 text-white px-10 h-14 rounded-[1.5rem] font-black text-[11px] uppercase tracking-widest italic hover:bg-emerald-500 hover:shadow-xl hover:shadow-emerald-500/20 transition-all active:scale-95 flex items-center gap-3">
                <span>Filtrer</span>
                <i class="fas fa-filter text-[10px]"></i>
            </button>
        </form>

        <div class="flex-1 overflow-y-auto custom-scrollbar pr-4 space-y-4">
            
            @forelse($reservations as $reservation)
            <div class="group bg-white rounded-[3rem] p-6 border border-slate-100 hover:border-emerald-200 transition-all duration-500 flex items-center gap-8 shadow-sm hover:shadow-xl">
                
                <div class="w-32 flex flex-col items-center justify-center border-r border-slate-50 px-4">
                    <span class="text-2xl font-[900] text-slate-900 italic leading-none">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</span>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mt-2">{{ $reservation->court->name }}</span>
                </div>

                <div class="flex-1 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-[1.8rem] bg-slate-900 border-4 border-white shadow-xl flex items-center justify-center text-white font-[900] italic text-xl overflow-hidden">
                        @if($reservation->user->profile_image)
                            <img src="{{ asset('storage/' . $reservation->user->profile_image) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($reservation->user->name, 0, 2)) }}
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xl font-[900] text-slate-900 italic uppercase tracking-tighter leading-none">{{ $reservation->user->name }}</h4>
                        <p class="text-[10px] font-black text-slate-400 uppercase italic mt-1">#RSV-{{ $reservation->id }} • {{ $reservation->user->coins_balance }} PC SOLDE</p>
                    </div>
                </div>

                <div class="flex-[0.8]">
                    <div class="flex flex-wrap gap-1 mb-2">
                        @forelse($reservation->equipments_info ?? [] as $item)
                            <span class="bg-slate-50 text-slate-500 text-[8px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter border border-slate-100">
                                {{ $item['qty'] }}x {{ $item['name'] }}
                            </span>
                        @empty
                            <span class="text-[10px] font-bold text-slate-200 italic uppercase">Sans équipement</span>
                        @endforelse
                    </div>
                    <p class="text-sm font-[900] text-slate-900 italic">{{ $reservation->total_price }} <span class="text-[10px] text-slate-400">PC</span></p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right min-w-[100px]">
                        @if($reservation->status == 'confirmed')
                            <span class="px-5 py-2 bg-emerald-50 text-emerald-600 text-[9px] font-[900] rounded-full uppercase tracking-widest italic border border-emerald-100">Confirmé</span>
                        @elseif($reservation->status == 'pending')
                            <span class="px-5 py-2 bg-amber-50 text-amber-600 text-[9px] font-[900] rounded-full uppercase tracking-widest italic border border-amber-100 animate-pulse">À Régler</span>
                        @else
                            <span class="px-5 py-2 bg-slate-100 text-slate-400 text-[9px] font-[900] rounded-full uppercase tracking-widest italic border border-slate-200">Annulé</span>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        @if($reservation->status == 'pending')
                        <button class="w-12 h-12 rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-200 hover:scale-110 transition-transform">
                            <i class="fas fa-check-double"></i>
                        </button>
                        @endif
                        <button class="w-12 h-12 rounded-2xl bg-white border border-slate-100 text-red-400 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </div>
                </div>

            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center py-20 opacity-40">
                <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mb-4 border border-dashed border-slate-300">
                    <i class="fas fa-calendar-times text-3xl text-slate-300"></i>
                </div>
                <p class="text-[10px] font-black uppercase italic tracking-[0.3em] text-slate-400">Aucun match trouvé</p>
            </div>
            @endforelse

        </div>
    </main>

    @include('components.notif')
</body>
</html>