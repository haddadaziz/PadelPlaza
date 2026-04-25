<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Mon Arena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        
        .progress-shine {
            position: absolute; top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }
        @keyframes shine { from { transform: translateX(-100%); } to { transform: translateX(100%); } }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

<main class="flex-1 lg:ml-64 p-6 lg:p-8 mt-16 lg:mt-0 min-h-screen flex flex-col lg:overflow-hidden">
    
    <div class="flex justify-between items-center mb-8 shrink-0">
        <div>
            <h2 class="text-3xl font-[900] text-slate-900 tracking-tight uppercase leading-none">Mon Arena</h2>
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em] mt-2">
                Performance Dashboard • Season 01
            </p>
        </div>

        <div class="flex items-center gap-4 bg-white p-3 pr-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-emerald-400 font-black text-lg shadow-lg overflow-hidden border border-emerald-500/30">
                @if(Auth::user()->level && Auth::user()->level->badge_image)
                    <img src="{{ asset('storage/' . Auth::user()->level->badge_image) }}" alt="Badge" class="w-full h-full object-cover">
                @else
                    {{ (Auth::user()->level->level_name ?? 'MEMBRE') }}
                @endif
            </div>
            <div>
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ Auth::user()->level->level_name ?? 'MEMBRE'}}</p>
                <p class="text-sm font-black text-slate-900 uppercase">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1 min-h-0">
        
        <div class="lg:col-span-8 flex flex-col gap-8 min-h-0">
            
            <div class="bg-slate-900 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group shrink-0">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full -mr-20 -mt-20 blur-[100px]"></div>
                
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4">PPC Disponible</p>
                        <h3 class="text-7xl font-[900] text-white tracking-tight leading-none">
                            {{ Auth::user()->coins_balance }}<span class="text-2xl text-slate-600 ml-3 font-black uppercase">PC</span>
                        </h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('player.reservations.create') }}" class="bg-emerald-500 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-emerald-600 transition-all shadow-xl shadow-emerald-500/20 text-center active:scale-95">
                            Réserver
                        </a>
                        <a href="{{ route('player.recharge') }}" class="bg-white/5 border border-white/10 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-white/10 transition-all text-center">
                            Recharger
                        </a>
                    </div>
                </div>
            </div>

<div class="bg-white rounded-[3.5rem] border border-slate-100 p-10 shadow-sm flex-1 min-h-0 flex flex-col">
    <!-- LE TITRE -->
    <div class="flex justify-between items-center mb-8 shrink-0">
        <h4 class="text-lg font-black text-slate-900 uppercase tracking-tight">Calendrier Personnel</h4>
        <div class="h-px flex-1 bg-slate-50 mx-8"></div>
        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Prochain match</span>
    </div>
    
    <!-- LE MATCH LE PLUS PROCHE -->
    <div class="space-y-4 overflow-y-auto custom-scrollbar flex-1 px-2 py-1">
        @if($nextMatch)
            <div class="flex items-center justify-between p-6 bg-emerald-50 rounded-[2.5rem] border-2 border-emerald-300 shadow-lg hover:scale-[1.02] hover:shadow-2xl hover:shadow-emerald-500/30 hover:bg-emerald-100 hover:border-emerald-400 transition-all duration-500 group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent progress-shine hidden group-hover:block"></div>
                
                <div class="flex items-center gap-8 relative z-10">
                    <!-- Date Dynamique -->
                    <div class="w-20 h-20 bg-white rounded-3xl flex flex-col items-center justify-center border border-slate-100 shadow-sm group-hover:shadow-emerald-100 transition-all">
                        <span class="text-[10px] font-black text-slate-300 uppercase">{{ \Carbon\Carbon::parse($nextMatch->start_time)->translatedFormat('M') }}</span>
                        <span class="text-3xl font-[900] text-slate-900 leading-none">{{ \Carbon\Carbon::parse($nextMatch->start_time)->format('d') }}</span>
                    </div>
                    <div>
                        <!-- Nom du terrain -->
                        <h5 class="font-[900] text-slate-900 uppercase text-xl tracking-tight mb-2">{{ $nextMatch->court->name }}</h5>
                        <div class="flex items-center gap-4">
                            <!-- Heure Dynamique -->
                            <p class="text-xs text-slate-400 font-bold uppercase"><i class="far fa-clock text-emerald-500 mr-2"></i> {{ \Carbon\Carbon::parse($nextMatch->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($nextMatch->start_time)->addMinutes(60)->format('H:i') }}</p>
                            <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                            <span class="text-[9px] font-black text-emerald-500 uppercase">Confirmé</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- MESAAGE SI AUCUN MATCH -->
            <div class="flex flex-col items-center justify-center h-full text-center py-6 text-slate-400">
                <i class="fas fa-calendar-times text-3xl mb-3 opacity-20"></i>
                <p class="text-[10px] font-black uppercase tracking-widest">Tu n'as aucun match prévu</p>
                <a href="{{ route('player.reservations.create') }}" class="mt-4 text-[10px] font-black text-emerald-500 uppercase tracking-widest hover:text-emerald-600">Réserver maintenant <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        @endif
    </div>

    <!-- LE BOUTON VOIR TOUT (fixé en bas de la carte) -->
    <a href="{{ route('player.matchs') }}" class="mt-4 pt-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-emerald-500 transition-colors border-t border-slate-50 block w-full">
        Consulter mon calendrier complet <i class="fas fa-chevron-right ml-1 text-[8px]"></i>
    </a>
</div>

        </div>

        <div class="lg:col-span-4 flex flex-col gap-8 min-h-0">
            
            <div class="bg-white rounded-[3.5rem] border border-slate-100 p-10 shadow-sm flex flex-col items-center text-center">
                <p class="text-[9px] font-black text-black-300 uppercase tracking-[0.3em] mb-8">Rang de Prestige</p>
                
                <div class="relative mb-8">
                    <svg class="w-48 h-48 rotate-[-90deg]">
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-50" />
                        <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="6" fill="transparent" 
                                stroke-dasharray="552.9" stroke-dashoffset="{{ 552.9 - (552.9 * $progress / 100) }}"
                                class="text-emerald-500 transition-all duration-1000 ease-out" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center p-6">
                        <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center shadow-[0_0_30px_rgba(16,185,129,0.3)] relative overflow-hidden border-4 border-white group">
                            @if(Auth::user()->level && Auth::user()->level->badge_image)
                                <img src="{{ asset('storage/' . Auth::user()->level->badge_image) }}" alt="Rank" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125 scale-110">
                            @else
                                <span class="text-white text-4xl font-black">{{ substr(Auth::user()->level->level_name ?? 'B', 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <h4 class="text-2xl font-[900] text-slate-900 uppercase tracking-tight">{{ Auth::user()->level->level_name ?? 'Bois' }}</h4>
                <div class="mt-6 w-full space-y-2">
                    <div class="flex justify-between text-[10px] font-black uppercase">
                        <span class="text-slate-400">Progression</span>
                        <span class="text-emerald-500">{{ $progress }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
<p class="text-[10px] font-black text-slate-400 uppercase">
    @if($nextLevel)
        Encore <span class="text-emerald-500">{{ $xpRemaining }} XP</span> pour atteindre le niveau {{ $nextLevel->level_name }}
    @else
        Niveau Maximum atteint !
    @endif
</p>

                </div>
            </div>

        </div>
    </div>
</main>
@include('components.notif')
</body>
</html>