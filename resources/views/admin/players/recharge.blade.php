<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Caisse Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        
        /* Design de base des cartes */
        .pack-card { 
            border: 2px solid #F1F5F9; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            position: relative;
        }

        /* Effet au survol */
        .pack-card:hover { border-color: #E2E8F0; transform: translateY(-2px); }

        /* DÉCORATION AUTOUR DE CELLE SÉLECTIONNÉE */
        input[type="radio"]:checked + .pack-card { 
            border-color: #10B981; 
            background-color: #F0FDF4; 
            transform: translateY(-3px);
            box-shadow: 0 15px 20px -5px rgba(16, 185, 129, 0.08);
        }

        /* Badge de validation dynamique */
        input[type="radio"]:checked + .pack-card::after {
            content: "\f058"; /* Icône Check FontAwesome */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 15px;
            right: 15px;
            color: #10B981;
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen overflow-hidden flex flex-col">
        
        <div class="mb-8 shrink-0 flex items-center justify-between">
            <div>
                <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2 gap-2">
                    <a href="{{ route('admin.players') }}" class="hover:text-emerald-500 transition-colors">Joueurs</a>
                    <span>/</span>
                    <span class="text-slate-900">Encaissement</span>
                </nav>
                <h2 class="text-3xl font-[900] text-slate-900 tracking-tighter italic uppercase leading-none">Caisse Admin</h2>
            </div>
            
            <div class="bg-white px-6 py-4 rounded-[2rem] flex items-center gap-4 border border-slate-100 shadow-sm">
                <div class="w-12 h-12 bg-slate-900 text-emerald-400 rounded-2xl flex items-center justify-center font-black text-lg italic border-2 border-slate-800">
                    {{ strtoupper(substr($player->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-black text-slate-900 uppercase italic tracking-tighter leading-none text-base">{{ $player->name }}</h3>
                    <p class="text-[9px] text-slate-400 font-black tracking-[0.2em] uppercase mt-1">Solde : <span class="text-emerald-500">{{ $player->coins_balance }} PC</span></p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.players.recharge.process', ['id' => $player->id]) }}" method="POST" class="grid grid-cols-12 gap-10 flex-1 min-h-0">
            @csrf
            
            <div class="col-span-7 flex flex-col min-h-0">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 shrink-0 italic">Options de recharge</h3>
                
                <div class="grid grid-cols-2 gap-6 overflow-y-auto pr-4 pt-6 pb-10 custom-scrollbar min-h-0">
                    
                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="100" class="peer sr-only" checked onchange="updateTotal(100)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                            <h4 class="text-2xl font-[900] text-slate-900 italic tracking-tighter uppercase">100 PC</h4>
                            <p class="text-slate-500 font-black text-[10px] mt-2 uppercase tracking-widest italic">100 DH à encaisser</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="500" class="peer sr-only" onchange="updateTotal(500)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[8px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest italic shadow-lg">Popular Choice</div>
                            <h4 class="text-2xl font-[900] text-slate-900 italic tracking-tighter uppercase">500 PC</h4>
                            <p class="text-emerald-600 font-black text-[10px] mt-2 uppercase tracking-widest italic">450 DH à encaisser</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="1200" class="peer sr-only" onchange="updateTotal(1200)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                            <h4 class="text-2xl font-[900] text-slate-900 italic tracking-tighter uppercase">1200 PC</h4>
                            <p class="text-slate-500 font-black text-[10px] mt-2 uppercase tracking-widest italic">1000 DH à encaisser</p>
                        </div>
                    </label>

                    <div class="bg-white p-8 rounded-[2.5rem] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 group hover:border-emerald-500 transition-all">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Saisie Manuelle</p>
                        <input type="number" id="custom-amount" name="custom_amount" placeholder="Coins..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-center font-black italic text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                    </div>
                </div>
            </div>

            <div class="col-span-5 flex flex-col min-h-0">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 shrink-0 italic text-right">Confirmation</h3>
                
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-8 flex flex-col flex-1 min-h-0">
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 mb-8 text-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
                        
                        <p class="text-[10px] font-black text-slate-500 uppercase italic mb-3 tracking-widest">Plaza Coins à injecter</p>
                        <div class="flex items-center justify-center gap-2 relative z-10">
                            <span id="display-amount" class="text-6xl font-[900] text-white italic tracking-tighter">100</span>
                            <span class="text-2xl font-black text-emerald-500 italic uppercase">PC</span>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-start gap-4 bg-blue-50 p-5 rounded-3xl border border-blue-100">
                            <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                            <p class="text-[10px] text-blue-700 font-black leading-relaxed italic uppercase tracking-tight">
                                Le solde sera mis à jour dès la validation. Pensez à donner le reçu au joueur.
                            </p>
                        </div>
                    </div>

                    <button type="submit" class="mt-8 bg-emerald-500 text-white w-full py-6 rounded-[2rem] font-[900] uppercase italic tracking-widest hover:bg-slate-900 transition-all shadow-2xl shadow-emerald-500/20 flex items-center justify-center gap-3 active:scale-95">
                        Confirmer l'ajout <i class="fas fa-bolt text-[10px]"></i>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Logique JS de mise à jour du Recap (inchangée)
        function updateTotal(val) {
            document.getElementById('display-amount').innerText = val;
            document.getElementById('custom-amount').value = '';
        }

        function selectCustom() {
            const val = document.getElementById('custom-amount').value;
            document.querySelectorAll('input[name="amount"]').forEach(r => r.checked = false);
            document.getElementById('display-amount').innerText = val || 0;
        }
    </script>
</body>
</html>