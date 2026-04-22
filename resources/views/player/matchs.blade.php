<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Padel Plaza | Mes Matchs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .glass-dark { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(8px); }

        /* ===== DARK SELECT THEME (matching admin) ===== */
        .dark-select {
            background: #0F172A;
            color: white;
            border: 1px solid rgba(16,185,129,0.1);
            border-radius: 1.25rem;
            padding: 0.6rem 2.5rem 0.6rem 2.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            width: auto;
            min-width: 130px;
            transition: all 0.2s;
        }
        .dark-select:focus {
            border-color: rgba(16,185,129,0.5);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.08);
        }
        .dark-select-wrap { position: relative; }
        .dark-select-wrap .icon-chevron {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #10B981;
            pointer-events: none;
            font-size: 8px;
            z-index: 1;
        }

    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen flex flex-col overflow-hidden">
        
        <div class="flex justify-between items-end mb-8 shrink-0">
            <div>
                <h2 class="text-3xl font-[900] text-slate-900 tracking-tight uppercase">Arena <span class="text-emerald-500">Timeline</span></h2>
                <p class="text-slate-400 font-bold text-sm mt-1">Vos prochains rendez-vous et votre historique de performance.</p>
            </div>
            
            <div class="bg-slate-900 px-6 py-4 rounded-[2rem] shadow-xl border border-slate-800 flex items-center gap-4">
                <div class="text-center border-r border-slate-700 pr-4">
                    <p class="text-[8px] font-black text-emerald-500 uppercase tracking-widest mb-1">Total XP</p>
                    <p class="text-xl font-[900] text-white leading-none">{{ Auth::user()->xp_points }}</p>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Niveau Actuel</p>
                    <p class="text-lg font-[900] text-white leading-none">{{ Auth::user()->level->level_name ?? 'ROOKIE' }}</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex gap-8 min-h-0 overflow-hidden">
            
            <div class="w-1/3 flex flex-col min-h-0">
                <div class="flex items-center justify-between mb-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Prochains Matchs</h3>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4">
                    @forelse($upcomingMatches as $match)
                    <div class="group bg-slate-50 rounded-[2.5rem] p-6 border border-transparent hover:border-emerald-200 hover:bg-white transition-all duration-500">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex flex-col items-center justify-center shadow-sm border border-slate-100">
                                <span class="text-[9px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($match->start_time)->translatedFormat('M') }}</span>
                                <span class="text-lg font-[900] text-slate-900 leading-none">{{ \Carbon\Carbon::parse($match->start_time)->format('d') }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ $match->court->name }}</p>
                                <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($match->start_time)->format('H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                            <div class="flex -space-x-2">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-sm">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0F172A&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover">
                                @endif
                                <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[8px] text-slate-400 font-black" title="En attente d'adversaires">?</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center text-center px-6">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-dashed border-slate-200 text-slate-200">
                            <i class="fas fa-calendar-plus text-2xl"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Aucun match de prévu</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center justify-between mb-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Historique des Matchs</h3>
                    </div>

                    <form action="{{ route('player.matchs') }}" method="GET" class="flex items-center gap-2">
                        {{-- Mois --}}
                        <div class="dark-select-wrap">
                            <select name="month" onchange="this.form.submit()" class="dark-select" style="min-width: 110px;">
                                <option value="">Mois</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down icon-chevron"></i>
                        </div>

                        {{-- Année --}}
                        <div class="dark-select-wrap">
                            <select name="year" onchange="this.form.submit()" class="dark-select" style="min-width: 80px;">
                                <option value="">Années</option>
                                @foreach(range(date('Y'), date('Y')-2) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down icon-chevron"></i>
                        </div>

                        {{-- Tri --}}
                        <div class="dark-select-wrap">
                            <select name="sort" onchange="this.form.submit()" class="dark-select" style="min-width: 120px;">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>+ Récent</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>+ Ancien</option>
                            </select>
                            <i class="fas fa-chevron-down icon-chevron"></i>
                        </div>

                        {{-- Réinitialiser --}}
                        <a href="{{ route('player.matchs') }}" class="w-10 h-10 bg-slate-900 border border-slate-800 text-emerald-500 rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-lg active:scale-90" title="Réinitialiser les filtres">
                            <i class="fas fa-undo-alt text-xs"></i>
                        </a>
                    </form>
                </div>

                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 overflow-hidden flex flex-col">
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-8">
                        <div class="space-y-4">
                            @forelse($pastMatches as $match)
<div id="match-{{ $match->id }}"
     class="flex items-center gap-6 p-5 rounded-[2rem] transition-all duration-500 group border-2
        {{ $match->result === 'win' ? 'bg-emerald-50 border-emerald-200' : ($match->result === 'loss' ? 'bg-red-50 border-red-200' : 'bg-transparent border-transparent hover:bg-slate-50') }}">

    {{-- Date --}}
    <div class="text-center min-w-[50px]">
        <p class="text-[10px] font-black text-slate-300 uppercase leading-none mb-1">{{ \Carbon\Carbon::parse($match->start_time)->format('d') }}</p>
        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tight">{{ \Carbon\Carbon::parse($match->start_time)->translatedFormat('M') }}</p>
        <p class="text-[8px] font-bold text-emerald-500 uppercase tracking-tight mt-1">{{ \Carbon\Carbon::parse($match->start_time)->format('H:i') }}</p>
    </div>

    {{-- Infos --}}
    <div class="flex-1">
        <p class="text-sm font-black text-slate-900 uppercase tracking-tight leading-none mb-1 group-hover:text-emerald-600 transition-colors">{{ $match->court->name }}</p>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $match->total_price }} PC — {{ \Carbon\Carbon::parse($match->start_time)->format('H:i') }}</p>
    </div>

    {{-- XP --}}
    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">+{{ $match->total_price }} XP</p>

    {{-- Toggle Victoire / Défaite --}}
    <div class="flex flex-col gap-1.5">
        <button onclick="setResult({{ $match->id }}, 'win')" id="win-{{ $match->id }}"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all
                {{ $match->result === 'win' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-slate-100 text-slate-400 hover:bg-emerald-100 hover:text-emerald-600' }}">
            <i class="fas fa-trophy text-[8px]"></i> Victoire
        </button>
        <button onclick="setResult({{ $match->id }}, 'loss')" id="loss-{{ $match->id }}"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all
                {{ $match->result === 'loss' ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'bg-slate-100 text-slate-400 hover:bg-red-100 hover:text-red-500' }}">
            <i class="fas fa-times text-[8px]"></i> Défaite
        </button>
    </div>
</div>
                            @empty
                            <div class="h-64 flex flex-col items-center justify-center opacity-40">
                                <i class="fas fa-folder-open text-4xl mb-4 text-slate-200"></i>
                                <p class="text-[10px] font-black uppercase tracking-widest text-center">Aucun match trouvé pour<br>cette période</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

               <!-- FOOTER : Statistiques Premium -->
        <div class="mt-8 py-6 px-10 bg-white/70 backdrop-blur-md rounded-[3rem] border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex justify-between items-center shrink-0">
            <div class="flex gap-12">
                <!-- Bloc Ratio -->
                <div class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100/50 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Ratio Victoire</p>
                        <p id="win-rate-display" class="text-2xl font-[900] text-slate-900 uppercase tracking-tight leading-none">{{ $winRate }}%</p>
                    </div>
                </div>

                <!-- Bloc Temps de Jeu -->
                <div class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100/50 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-stopwatch text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Temps de jeu</p>
                        <p class="text-2xl font-[900] text-slate-900 uppercase tracking-tight leading-none">{{ $totalPlayTime }}H</p>
                    </div>
                </div>
            </div>

            <!-- Badge saisonnier -->
            <div class="text-right">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 rounded-full shadow-lg shadow-slate-200">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></div>
                    <span class="text-[9px] font-black text-white uppercase tracking-widest">Saison 2026</span>
                </div>
            </div>
        </div>

        </div>
    </main>

<script>
function setResult(matchId, result) {
    fetch(`/player/matchs/${matchId}/result`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ result: result })
    })
    .then(response => response.json())
    .then(data => {
        // 1. Mise à jour du Ratio en bas de page
        const rateDisplay = document.getElementById('win-rate-display');
        if (rateDisplay) {
            rateDisplay.innerText = data.newRate + '%';
        }

        // 2. Mise à jour de la couleur de la ligne (Match Card)
        const matchDiv = document.getElementById(`match-${matchId}`);
        matchDiv.className = "flex items-center gap-6 p-5 rounded-[2rem] transition-all duration-500 group border-2";
        
        if (data.result === 'win') {
            matchDiv.classList.add('bg-emerald-50', 'border-emerald-200');
        } else if (data.result === 'loss') {
            matchDiv.classList.add('bg-red-50', 'border-red-200');
        } else {
            matchDiv.classList.add('bg-transparent', 'border-transparent', 'hover:bg-slate-50');
        }

        // 3. Mise à jour du bouton Victoire
        const winBtn = document.getElementById(`win-${matchId}`);
        winBtn.className = `flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all ${data.result === 'win' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-slate-100 text-slate-400 hover:bg-emerald-100 hover:text-emerald-600'}`;

        // 4. Mise à jour du bouton Défaite
        const lossBtn = document.getElementById(`loss-${matchId}`);
        lossBtn.className = `flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all ${data.result === 'loss' ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'bg-slate-100 text-slate-400 hover:bg-red-100 hover:text-red-500'}`;
    });
}
</script>


</body>
</html>