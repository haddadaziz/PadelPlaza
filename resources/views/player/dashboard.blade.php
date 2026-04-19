<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Mon Arena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .coin-card { background: linear-gradient(135deg, #064e3b 0%, #10b981 100%); }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

<main class="flex-1 ml-64 p-8 bg-[#F8FAFC] h-screen overflow-hidden flex flex-col">
    
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-emerald-400 font-black italic text-xl shadow-lg border-2 border-white">
                    {{ Auth::user()->level ?? 12 }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fas fa-check text-[8px] text-white"></i>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-[900] text-slate-900 tracking-tighter italic uppercase leading-none">Arena de {{ explode(' ', Auth::user()->name)[0] }}</h2>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1 italic">Membre Gold • <span class="text-emerald-500">En ligne</span></p>
            </div>
        </div>
        

    </div>

    <div class="grid grid-cols-12 gap-6 flex-1">
        
        <div class="col-span-8 space-y-6">
            
            <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden group min-h-[220px] flex flex-col justify-center">
                <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/10 rounded-full -mr-20 -mt-20 blur-[100px]"></div>
                
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.4em] mb-2 italic">Portefeuille Plaza</p>
                        <h3 class="text-6xl font-[900] text-white italic tracking-tighter leading-none">
                            {{ Auth::user()->coins_balance }} <span class="text-xl text-slate-500 font-black">PC</span>
                        </h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('player.reservations.create') }}" class="bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase italic tracking-widest hover:bg-white hover:text-emerald-600 transition-all shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3 active:scale-95">
                            <i class="fas fa-plus-circle"></i> Réserver
                        </a>
                        <button class="bg-white/10 backdrop-blur-md text-white border border-white/10 px-8 py-4 rounded-2xl font-black text-[11px] uppercase italic tracking-widest hover:bg-white/20 transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-wallet"></i> Recharger
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm flex-1">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-sm font-black text-slate-900 italic uppercase tracking-widest">Calendrier des matchs</h4>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">2 Réservations actives</span>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-emerald-200 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex flex-col items-center justify-center border border-slate-100 shadow-sm">
                                <span class="text-[8px] font-black text-slate-400 uppercase">Avr</span>
                                <span class="text-lg font-black text-slate-900 italic leading-none">22</span>
                            </div>
                            <div>
                                <p class="font-black text-slate-900 uppercase italic text-sm tracking-tighter">Court Panoramique #1</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase italic"><i class="far fa-clock text-emerald-500 mr-1"></i> 20:00 — 21:30</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-200"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-4 flex flex-col gap-6">
            
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col items-center justify-center flex-1">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Saison Progression</h4>
                
                <div class="relative w-40 h-40 mb-6">
                    <svg class="w-full h-full rotate-[-90deg]">
                        <circle cx="80" cy="80" r="72" stroke="currentColor" stroke-width="10" fill="transparent" class="text-slate-50" />
                        <circle cx="80" cy="80" r="72" stroke="currentColor" stroke-width="10" fill="transparent" 
                                stroke-dasharray="452.3" stroke-dashoffset="135"
                                class="text-emerald-500 transition-all duration-1000 ease-out" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-[900] text-slate-900 italic leading-none">70<span class="text-sm">%</span></span>
                        <span class="text-[8px] font-black text-slate-400 uppercase mt-2">Vers Niv. 13</span>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-sm font-black text-slate-900 uppercase italic tracking-tighter">Expert Player</p>
                    <div class="mt-4 flex gap-1 justify-center">
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-slate-100 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-slate-100 rounded-full"></div>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-500 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <i class="fas fa-fire absolute right-[-10px] bottom-[-10px] text-8xl text-white/10 -rotate-12 group-hover:rotate-0 transition-transform duration-700"></i>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100 mb-2 italic">Win Streak</p>
                <h3 class="text-4xl font-[900] italic leading-none uppercase">5 Matchs<br>Gagnés</h3>
            </div>

        </div>
    </div>
</main>
</body>
</html>