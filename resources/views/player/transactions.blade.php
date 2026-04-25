<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Historique des Transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        @media (min-width: 1024px) { body { overflow: hidden; } }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
                /* Styles des filtres sombres */
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
            min-width: 140px;
            transition: all 0.2s;
        }
        .dark-select:focus { border-color: rgba(16,185,129,0.5); box-shadow: 0 0 0 3px rgba(16,185,129,0.08); }
        .dark-select-wrap { position: relative; }
        .dark-select-wrap .icon-chevron {
            position: absolute; right: 0.8rem; top: 50%; transform: translateY(-50%);
            color: #10B981; pointer-events: none; font-size: 8px; z-index: 1;
        }

    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 lg:ml-64 p-6 lg:p-8 mt-16 lg:mt-0 min-h-screen flex flex-col lg:h-screen lg:overflow-hidden">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 shrink-0 gap-6">
            <div>
                <h2 class="text-3xl font-[900] text-slate-900 tracking-tight uppercase leading-none">Flux <span class="text-emerald-500">Financier</span></h2>
                
                <form action="{{ route('player.transactions') }}" method="GET" class="flex flex-wrap items-center gap-3 mt-6">
                    {{-- Type --}}
                    <div class="dark-select-wrap w-full sm:w-auto">
                        <select name="type" onchange="this.form.submit()" class="dark-select w-full sm:w-auto">
                            <option value="">Tous les types</option>
                            <option value="reservation" {{ request('type') == 'reservation' ? 'selected' : '' }}>Réservations</option>
                            <option value="recharge" {{ request('type') == 'recharge' ? 'selected' : '' }}>Recharges</option>
                            <option value="cashback" {{ request('type') == 'cashback' ? 'selected' : '' }}>Bonus Cashback</option>
                        </select>
                        <i class="fas fa-chevron-down icon-chevron"></i>
                    </div>

                    {{-- Mois --}}
                    <div class="dark-select-wrap w-full sm:w-auto">
                        <select name="month" onchange="this.form.submit()" class="dark-select w-full sm:w-auto" style="min-width: 110px;">
                            <option value="">Tous les mois</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down icon-chevron"></i>
                    </div>

                    {{-- Année --}}
                    <div class="dark-select-wrap w-full sm:w-auto">
                        <select name="year" onchange="this.form.submit()" class="dark-select w-full sm:w-auto" style="min-width: 90px;">
                            <option value="">Années</option>
                            @foreach(range(date('Y'), date('Y')-2) as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down icon-chevron"></i>
                    </div>

                    {{-- Reset --}}
                    <a href="{{ route('player.transactions') }}" class="w-10 h-10 bg-slate-900 border border-slate-800 text-emerald-500 rounded-xl flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-lg active:scale-90" title="Réinitialiser">
                        <i class="fas fa-undo-alt text-xs"></i>
                    </a>
                </form>
            </div>
            
            <div class="bg-slate-900 px-6 py-4 rounded-[2rem] shadow-xl border border-slate-800 w-full md:w-auto">
                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-1 text-center">Ton Solde</p>
                <p class="text-2xl font-[900] text-white leading-none text-center">{{ Auth::user()->coins_balance }} <span class="text-xs text-slate-500">PC</span></p>
            </div>
        </div>


        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 flex flex-col min-h-0 overflow-hidden">
            <div class="hidden lg:grid grid-cols-12 px-8 py-6 border-b border-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest shrink-0">
                <div class="col-span-5">Détails de l'opération</div>
                <div class="col-span-3 text-center">Date & Heure</div>
                <div class="col-span-2 text-center">Catégorie</div>
                <div class="col-span-2 text-right pr-4">Montant PC</div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @forelse($transactions as $transaction)
                <div class="flex flex-col lg:grid lg:grid-cols-12 px-6 lg:px-8 py-5 items-center hover:bg-slate-50 transition-all border-b border-slate-50 group gap-4 lg:gap-0">
                    
                    <div class="w-full lg:col-span-5 flex items-center gap-4">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-sm shadow-sm transition-transform group-hover:scale-110 
                            {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'bg-amber-50 text-amber-500' : 'bg-emerald-50 text-emerald-500') : 'bg-slate-100 text-slate-400' }}">
                            <i class="fas {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'fa-gift' : 'fa-plus-circle') : 'fa-table-tennis-paddle-ball' }}"></i>
                        </div>
                        <div>
@php
    $courtName = $transaction->reservation?->court?->name ?? 'Transaction';
    $matchDate = $transaction->reservation?->start_time
                    ? \Carbon\Carbon::parse($transaction->reservation->start_time)->format('d/m/Y à H:i')
                    : null;
@endphp


                            <p class="text-sm font-black text-slate-900 uppercase tracking-tight">
                                @if(str_contains($transaction->type, 'recharge')) Recharge de compte
                                @elseif($transaction->type == 'reservation') {{ $courtName }}
                                @elseif($transaction->type == 'cashback') Bonus Fidélité
                                @endif
                            </p>
@if($transaction->type == 'reservation' && $matchDate)
    <p class="text-[10px] text-slate-400 font-bold">Match le {{ $matchDate }}</p>
@elseif($transaction->type == 'cashback')
    <p class="text-[10px] text-slate-300 font-bold">Suite à une réservation</p>
@elseif($transaction->type == 'recharge_admin')
    <p class="text-[10px] text-slate-300 font-bold">Par l'administration</p>
@elseif($transaction->type == 'recharge_stripe')
    <p class="text-[10px] text-slate-300 font-bold">Via Stripe</p>
@else
    <p class="text-[10px] text-slate-300 font-bold">—</p>
@endif

                        </div>
                    </div>

                    <div class="w-full lg:col-span-3 flex justify-between lg:justify-center items-center">
                        <span class="lg:hidden text-[9px] font-black text-slate-400 uppercase tracking-widest">Date</span>
                        <p class="text-xs font-black text-slate-600 uppercase leading-none">{{ $transaction->created_at->format('d M Y') }}</p>
<p class="text-[9px] text-slate-300 font-bold mt-1 uppercase">
    @if(str_contains($transaction->type, 'recharge'))
        Crédité à {{ $transaction->created_at->format('H:i') }}
    @elseif($transaction->type == 'cashback')
        Obtenu à {{ $transaction->created_at->format('H:i') }}
    @else
        Réservé à {{ $transaction->created_at->format('H:i') }}
    @endif
</p>
                    </div>

                    <div class="w-full lg:col-span-2 flex justify-between lg:justify-center items-center">
                        <span class="lg:hidden text-[9px] font-black text-slate-400 uppercase tracking-widest">Type</span>
                        <span class="px-4 py-1.5 rounded-full text-[8px] font-black uppercase tracking-widest
                            {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'bg-amber-500/10 text-amber-600' : 'bg-emerald-500/10 text-emerald-600') : 'bg-slate-100 text-slate-500' }}">
                            @if(str_contains($transaction->type, 'recharge')) RECHARGE
                            @else {{ strtoupper($transaction->type) }}
                            @endif
                        </span>
                    </div>

                    <div class="w-full lg:col-span-2 flex justify-between lg:justify-end items-center lg:pr-4">
                        <span class="lg:hidden text-[9px] font-black text-slate-400 uppercase tracking-widest">Montant</span>
                        <p class="text-base font-[900] leading-none {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'text-amber-500' : 'text-emerald-500') : 'text-slate-900' }}">
                            {{ $transaction->amount > 0 ? '+' : '' }}{{ $transaction->amount }} <span class="text-[10px]">PC</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-center py-10">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-4">
                        <i class="fas fa-receipt text-3xl"></i>
                    </div>
                    <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Aucune transaction trouvée</p>
                </div>
                @endforelse
            </div>

            <div class="p-6 border-t border-slate-50 bg-slate-50/30 shrink-0">
                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span>Affichage de {{ $transactions->count() }} opérations</span>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
