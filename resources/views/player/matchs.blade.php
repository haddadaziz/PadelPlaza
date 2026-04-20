<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Mes Matchs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen flex flex-col overflow-hidden">
        
        <div class="flex justify-between items-end mb-8 shrink-0">
            <div>
                <h2 class="text-3xl font-[900] text-slate-900 tracking-tighter italic uppercase">Calendrier Arena</h2>
                <p class="text-slate-400 font-bold italic text-sm mt-1">Gérez vos réservations futures et revivez vos exploits.</p>
            </div>
            
            <div class="bg-slate-900 px-6 py-4 rounded-[2rem] shadow-xl border border-slate-800">
                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-1 italic text-center">Niveau Joueur</p>
                <p class="text-2xl font-[900] text-white italic leading-none">RANG {{ \App\Models\Level::where('min_xp', '<=', Auth::user()->xp_points)->count() }} <span class="text-xs text-slate-500 uppercase">{{ Auth::user()->level->level_name ?? 'Bois' }}</span></p>
            </div>
        </div>

        <div class="flex-1 flex gap-8 min-h-0 overflow-hidden">
            
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center gap-3 mb-4 px-4">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">Matchs à venir</h3>
                </div>

                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4">
                    @forelse($upcomingMatches as $match)
                    <div class="group bg-emerald-50 rounded-[2rem] p-6 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 transition-all duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-white rounded-2xl flex flex-col items-center justify-center shadow-sm border border-slate-100">
                                    <span class="text-[10px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($match->start_time)->translatedFormat('M') }}</span>
                                    <span class="text-xl font-[900] text-slate-900 italic leading-none">{{ \Carbon\Carbon::parse($match->start_time)->format('d') }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 uppercase italic tracking-tight">{{ $match->court->name }}</p>
                                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($match->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($match->start_time)->addHour()->format('H:i') }}</p>
                                </div>
                            </div>
                            <span class="bg-emerald-500/10 text-emerald-600 text-[8px] font-black px-3 py-1 rounded-full uppercase italic tracking-widest">Confirmé</span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-6">
                            <div class="flex -space-x-3">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-8 h-8 rounded-full border-2 border-emerald-100 object-cover" title="Moi">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff&font-weight=bold" class="w-8 h-8 rounded-full border-2 border-emerald-100 object-cover" title="Moi">
                                @endif
                                <div class="w-8 h-8 rounded-full border-2 border-emerald-100 bg-white flex items-center justify-center text-[8px] text-emerald-300 italic font-black">?</div>
                            </div>
                            <button class="text-[9px] font-black text-red-400 hover:text-red-600 uppercase italic tracking-widest transition-colors">
                                <i class="fas fa-times-circle mr-1"></i> Annuler
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center opacity-40">
                        <i class="fas fa-calendar-plus text-4xl mb-4 text-slate-200"></i>
                        <p class="text-[10px] font-black uppercase italic tracking-widest">Aucune réservation</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center gap-3 mb-4 px-4">
                    <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">Archives & Stats</h3>
                </div>

                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4">
                    @forelse($pastMatches as $match)
                    <div class="group bg-white rounded-[2rem] p-6 border border-slate-50 hover:bg-slate-50 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase italic tracking-[0.2em] mb-1">{{ \Carbon\Carbon::parse($match->start_time)->format('d/m/Y') }}</p>
                                <p class="text-sm font-black text-slate-900 uppercase italic tracking-tight opacity-60">{{ $match->court->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-[900] text-slate-900 italic leading-none">6-4 / 6-2</p>
                                <p class="text-[8px] font-black text-emerald-500 uppercase tracking-widest">+{{ $match->total_price }} XP</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center opacity-40">
                        <i class="fas fa-history text-4xl mb-4 text-slate-200"></i>
                        <p class="text-[10px] font-black uppercase italic tracking-widest">Historique vide</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="mt-6 py-4 px-8 bg-slate-50/50 rounded-[2rem] border border-slate-100 flex justify-between items-center shrink-0">
            <div class="flex gap-6 text-[9px] font-black text-slate-900 uppercase italic">
                <span>Total Matchs : {{ $pastMatches->count() + $upcomingMatches->count() }}</span>
            </div>
        </div>
    </main>

</body>
</html>