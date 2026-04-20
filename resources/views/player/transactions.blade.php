<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Historique des Transactions</title>
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
                <h2 class="text-3xl font-[900] text-slate-900 tracking-tighter italic uppercase">Flux Financier</h2>
                <p class="text-slate-400 font-bold italic text-sm mt-1">Historique complet de vos Plaza Coins (PC).</p>
            </div>
            
            <div class="bg-slate-900 px-6 py-4 rounded-[2rem] shadow-xl border border-slate-800">
                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-1 italic text-center">Ton Solde</p>
                <p class="text-2xl font-[900] text-white italic leading-none">{{ Auth::user()->coins_balance }} <span class="text-xs text-slate-500">PC</span></p>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm flex-1 flex flex-col min-h-0 overflow-hidden">
            <div class="grid grid-cols-12 px-8 py-6 border-b border-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest italic shrink-0">
                <div class="col-span-5">Détails de l'opération</div>
                <div class="col-span-3 text-center">Date & Heure</div>
                <div class="col-span-2 text-center">Catégorie</div>
                <div class="col-span-2 text-right pr-4">Montant PC</div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @forelse($transactions as $transaction)
                <div class="grid grid-cols-12 px-8 py-5 items-center hover:bg-slate-50 transition-all border-b border-slate-50 group">
                    
                    <div class="col-span-5 flex items-center gap-4">
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


                            <p class="text-sm font-black text-slate-900 uppercase italic tracking-tight">
                                @if(str_contains($transaction->type, 'recharge')) Recharge de compte
                                @elseif($transaction->type == 'reservation') {{ $courtName }}
                                @elseif($transaction->type == 'cashback') Bonus Fidélité
                                @endif
                            </p>
@if($transaction->type == 'reservation' && $matchDate)
    <p class="text-[10px] text-slate-400 font-bold italic">Match le {{ $matchDate }}</p>
@elseif($transaction->type == 'cashback')
    <p class="text-[10px] text-slate-300 font-bold italic">Suite à une réservation</p>
@elseif($transaction->type == 'recharge_admin')
    <p class="text-[10px] text-slate-300 font-bold italic">Par l'administration</p>
@elseif($transaction->type == 'recharge_stripe')
    <p class="text-[10px] text-slate-300 font-bold italic">Via Stripe</p>
@else
    <p class="text-[10px] text-slate-300 font-bold italic">—</p>
@endif

                        </div>
                    </div>

                    <div class="col-span-3 text-center">
                        <p class="text-xs font-black text-slate-600 italic uppercase leading-none">{{ $transaction->created_at->format('d M Y') }}</p>
                        <p class="text-[9px] text-slate-300 font-bold mt-1">Réservé à {{ $transaction->created_at->format('H:i') }}</p>
                    </div>

                    <div class="col-span-2 flex justify-center">
                        <span class="px-4 py-1.5 rounded-full text-[8px] font-black uppercase tracking-widest italic
                            {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'bg-amber-500/10 text-amber-600' : 'bg-emerald-500/10 text-emerald-600') : 'bg-slate-100 text-slate-500' }}">
                            @if(str_contains($transaction->type, 'recharge')) RECHARGE
                            @else {{ strtoupper($transaction->type) }}
                            @endif
                        </span>
                    </div>

                    <div class="col-span-2 text-right pr-4">
                        <p class="text-base font-[900] italic leading-none {{ $transaction->amount > 0 ? ($transaction->type == 'cashback' ? 'text-amber-500' : 'text-emerald-500') : 'text-slate-900' }}">
                            {{ $transaction->amount > 0 ? '+' : '' }}{{ $transaction->amount }} <span class="text-[10px]">PC</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-center py-10">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-4">
                        <i class="fas fa-receipt text-3xl"></i>
                    </div>
                    <p class="text-slate-400 font-black uppercase italic tracking-widest text-xs">Aucune transaction trouvée</p>
                </div>
                @endforelse
            </div>

            <div class="p-6 border-t border-slate-50 bg-slate-50/30 shrink-0">
                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase italic tracking-widest">
                    <span>Affichage de {{ $transactions->count() }} opérations</span>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
