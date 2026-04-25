<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Options de jeu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        @media (min-width: 1024px) { body { overflow: hidden; } }
        .qty-btn { transition: all 0.2s ease; }
        .qty-btn:active { transform: scale(0.9); }
        .equipment-card:has(input:checked) { border-color: #10B981; background-color: #F0FDF4; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 lg:ml-64 p-6 lg:p-8 mt-16 lg:mt-0 min-h-screen flex flex-col lg:h-screen lg:overflow-hidden">
        
        <div class="flex flex-wrap items-center gap-y-4 gap-x-6 mb-8 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-black border border-emerald-200"><i class="fas fa-check"></i></span>
                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-slate-400">Terrain & Heure</span>
            </div>
            <div class="hidden sm:block h-px w-8 lg:w-12 bg-emerald-200"></div>
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-black shadow-lg shadow-emerald-200">02</span>
                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-slate-900">Options & Matos</span>
            </div>
            <div class="hidden sm:block h-px w-8 lg:w-12 bg-slate-200"></div>
            <div class="flex items-center gap-2 opacity-30">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-black">03</span>
                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-slate-500">Paiement</span>
            </div>
        </div>

        <form action="{{ route('player.reservations.checkout') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1 overflow-y-auto lg:overflow-hidden min-h-0">
            <input type="hidden" name="court_id" value="{{ $court->id }}">
<input type="hidden" name="date" value="{{ $date }}">
<input type="hidden" name="time_slot" value="{{ $time_slot }}">

            <div class="col-span-1 lg:col-span-8 space-y-6 overflow-y-auto lg:pr-4 pb-10">
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Besoin de matériel ?</h3>
                        <p class="text-slate-400 font-bold text-sm">Louez vos accessoires.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($equipments as $item)
                    <div class="bg-white p-6 rounded-[2.5rem] border-2 border-slate-50 shadow-sm hover:shadow-md transition-all group equipment-card">
                        <div class="flex gap-5 items-center">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl bg-slate-50 flex items-center justify-center p-3 shrink-0">
                                <img src="{{ asset('storage/'.$item->image) }}" class="max-h-full object-contain group-hover:scale-110 transition-transform">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-black text-slate-900 uppercase tracking-tight leading-none mb-1">{{ $item->name }}</h4>
                                <p class="text-emerald-500 font-black text-sm mb-4">{{ $item->price_coins }} <span class="text-[9px]">PC</span></p>
                                
                                <div class="flex items-center gap-4 bg-slate-50 w-fit px-3 py-2 rounded-xl border border-slate-100">
                                    <button type="button" onclick="changeQty('{{ $item->id }}', -1)" class="qty-btn w-6 h-6 flex items-center justify-center text-slate-400 hover:text-slate-900"><i class="fas fa-minus text-[10px]"></i></button>
<input type="number" name="equipments[{{ $item->id }}]" id="qty-{{ $item->id }}" data-price="{{ $item->price_coins }}" value="0" min="0" max="{{ $item->stock }}" readonly class="w-6 bg-transparent text-center font-black text-xs text-slate-900 border-none outline-none focus:ring-0">
                                    <button type="button" onclick="changeQty('{{ $item->id }}', 1)" class="qty-btn w-6 h-6 flex items-center justify-center text-slate-400 hover:text-emerald-500"><i class="fas fa-plus text-[10px]"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-1 lg:col-span-4">
                <div class="bg-slate-900 rounded-[3rem] p-8 text-white h-full flex flex-col relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-500/20 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                    
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-400 mb-8">Récapitulatif de ta session</h4>
                    
                    <div class="space-y-6 flex-1">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas fa-calendar-check text-emerald-400"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-500 uppercase">Match prévu le</p>
                                <p class="text-sm font-black uppercase">{{ $date }} • {{ $time_slot }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas fa-table-tennis-paddle-ball text-emerald-400"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-500 uppercase">Court sélectionné</p>
                                <p class="text-sm font-black uppercase">{{ $court->name }}</p>
                            </div>
                        </div>

                        <div class="h-px bg-white/10 w-full"></div>

                        <div class="flex justify-between items-center py-4">
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total Actuel</span>
                            <div class="text-right">
                                <span class="text-3xl font-[900] text-white tracking-tight" id="total-display">{{ $court->price_coins }}</span>
                                <span class="text-xs font-black text-emerald-500 ml-1 uppercase">PC</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-white py-5 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                            Réserver
                        </button>
                        <a href="{{ route('player.reservations.create') }}" class="w-full flex items-center justify-center text-[10px] font-black text-slate-500 uppercase hover:text-white transition-colors tracking-widest">
                            <i class="fas fa-chevron-left mr-2"></i> Modifier le terrain
                        </a>
                    </div>
                </div>
            </div>

        </form>
    </main>

<script>
    // 1. On mémorise le prix de base du terrain grâce à Blade
    const courtPrice = {{ $court->price_coins }};

    function changeQty(id, delta) {
        const input = document.getElementById('qty-' + id);
        let val = parseInt(input.value) + delta;
        if (val >= 0 && val <= parseInt(input.max)) {
            input.value = val;
            updateTotal(); // On appelle la fonction de calcul
        }
    }

    function updateTotal() {
        let total = courtPrice; // On repart du prix du terrain
        
        // 2. On récupère tous nos inputs d'équipements
        const equipmentInputs = document.querySelectorAll('input[name^="equipments["]');
        
        // 3. Pour chaque équipement, on additionne (Quantité * Prix)
        equipmentInputs.forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseInt(input.getAttribute('data-price')) || 0;
            total += (qty * price);
        });

        // 4. On injecte le nouveau total avec un petit effet d'animation sympa (optionnel mais cool)
        const displayElement = document.getElementById('total-display');
        displayElement.style.transform = 'scale(1.1)'; // Petit bump
        setTimeout(() => { displayElement.style.transform = 'scale(1)'; }, 150);
        
        displayElement.innerText = total;
    }
</script>


</body>
</html>