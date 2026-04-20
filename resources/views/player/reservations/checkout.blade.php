<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Finaliser le paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        
        .payment-card { border: 2px solid transparent; transition: all 0.3s ease; }
        input[type="radio"]:checked + .payment-card { 
            border-color: #10B981 !important; 
            background-color: #F0FDF4 !important; 
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1);
        }
        input[type="radio"]:checked + .payment-card .check-icon { 
            background-color: #10B981; 
            color: white; 
            border-color: #10B981; 
        }
        input[type="radio"]:checked + .payment-card .check-icon i { display: block; }

        /* Scrollbar discrète pour la zone de paiement */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="flex min-h-screen">
    @include('components.notif')

    @include('components.player-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen overflow-hidden flex flex-col">
        
        <div class="flex items-center gap-4 mb-8 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-black italic border border-emerald-200"><i class="fas fa-check"></i></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Terrain</span>
            </div>
            <div class="h-px w-12 bg-emerald-200"></div>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-black italic border border-emerald-200"><i class="fas fa-check"></i></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Options</span>
            </div>
            <div class="h-px w-12 bg-emerald-200"></div>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-black italic shadow-lg shadow-emerald-200">03</span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900 italic">Paiement</span>
            </div>
        </div>

        <form action="{{ route('player.reservations.process') }}" method="POST" id="payment-form" class="grid grid-cols-12 gap-10 flex-1 min-h-0">
            @csrf
            <input type="hidden" name="court_id" value="{{ $court->id }}">
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="time_slot" value="{{ $time_slot }}">
            @foreach($selectedEquipments as $id => $data)
                <input type="hidden" name="equipments[{{ $id }}]" value="{{ $data['qty'] }}">
            @endforeach

            <div class="col-span-5 flex flex-col min-h-0">
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-6 shrink-0">Récapitulatif</h3>
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 flex-1 overflow-y-auto space-y-8 custom-scrollbar">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-500 shadow-sm">
                                <i class="fas fa-table-tennis"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Terrain</p>
                                <p class="text-sm font-black italic text-slate-900 uppercase tracking-tight">{{ $court->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-500 shadow-sm">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Date & Heure</p>
                                <p class="text-sm font-black italic text-slate-900 uppercase tracking-tight">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} • {{ $time_slot }}</p>
                            </div>
                        </div>
                    </div>

                    @if(count($selectedEquipments) > 0)
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Options & Matériel</p>
                        <div class="space-y-3">
                            @foreach($selectedEquipments as $data)
                            <div class="flex justify-between items-center px-2">
                                <span class="text-xs font-bold text-slate-600 italic">{{ $data['qty'] }}x {{ $data['item']->name }}</span>
                                <span class="text-xs font-black text-slate-900 italic">
                                    <span class="item-price" data-base="{{ $data['item']->price_coins * $data['qty'] }}">{{ $data['item']->price_coins * $data['qty'] }}</span> 
                                    <span class="currency-label">PC</span>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="h-px bg-slate-100 w-full"></div>

                    <div class="flex justify-between items-end">
                        <p class="text-sm font-black text-slate-900 uppercase italic">Total à payer</p>
                        <div class="text-right">
                            <p class="text-4xl font-[900] text-emerald-500 italic leading-none tracking-tighter">
                                <span id="display-total" data-base="{{ $totalPrice }}">{{ $totalPrice }}</span> 
                                <span class="currency-label text-xs uppercase">PC</span>
                            </p>
                            <p id="promo-text" class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic transition-all">
                                5% de CashBack si vous réservez avec vos PPC !
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-7 flex flex-col min-h-0">
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-6 shrink-0">Méthode de paiement</h3>
                
                <div class="flex-1 overflow-y-auto pr-4 space-y-4 custom-scrollbar pb-6">
                    <label class="relative block cursor-pointer group">
                        <input type="radio" name="payment_method" value="coins" class="peer sr-only" checked onchange="updateUI('coins')">
                        <div class="payment-card bg-white p-6 rounded-[2.5rem] shadow-sm hover:shadow-md flex items-center gap-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg shadow-emerald-200 shrink-0">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-black text-slate-900 italic uppercase leading-none mb-1">Plaza Coins</h4>
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Solde : <span class="text-emerald-500">{{ Auth::user()->_balance }} PC</span></p>
                            </div>
                            <div class="check-icon w-6 h-6 rounded-full border-2 border-slate-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[10px] hidden"></i>
                            </div>
                        </div>
                    </label>

                    <label class="relative block cursor-pointer group">
                        <input type="radio" name="payment_method" value="stripe" class="peer sr-only" onchange="updateUI('stripe')">
                        <div class="payment-card bg-white p-6 rounded-[2.5rem] shadow-sm hover:shadow-md flex items-center gap-6">
                            <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg shrink-0">
                                <i class="fab fa-stripe"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-black text-slate-900 italic uppercase leading-none mb-1">Carte Bancaire</h4>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight italic">Paiement via Stripe Sécurisé</p>
                            </div>
                            <div class="check-icon w-6 h-6 rounded-full border-2 border-slate-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[10px] hidden"></i>
                            </div>
                        </div>
                    </label>

                    <div id="stripe-element-container" class="hidden animate-in fade-in zoom-in duration-300 p-6 bg-slate-900 rounded-[2.5rem] border border-slate-800 shadow-2xl shrink-0">
                         <div id="card-element" class="p-2"></div>
                         <div id="card-errors" role="alert" class="text-red-400 text-[10px] font-bold mt-2 italic px-2"></div>
                    </div>
                </div>

                <button type="submit" id="submit-button" class="mt-4 bg-emerald-500 text-white w-full py-5 rounded-[1.8rem] font-[900] uppercase italic tracking-widest hover:bg-slate-900 transition-all shadow-2xl shadow-emerald-200 flex items-center justify-center gap-3 shrink-0 active:scale-95">
                    Confirmer la réservation
                </button>
            </div>
        </form>
    </main>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function updateUI(method) {
            const stripeDiv = document.getElementById('stripe-element-container');
            const currencyLabels = document.querySelectorAll('.currency-label');
            const promoText = document.getElementById('promo-text');

            if (method === 'stripe') {
                stripeDiv.classList.remove('hidden');
                currencyLabels.forEach(el => el.innerText = 'DH');
                promoText.classList.add('opacity-0');
            } else {
                stripeDiv.classList.add('hidden');
                currencyLabels.forEach(el => el.innerText = 'PC');
                promoText.classList.remove('opacity-0');
            }
        }

        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements({
            clientSecret: '{{ $clientSecret }}',
            appearance: {
                theme: 'night',
                variables: { colorPrimary: '#10B981', fontFamily: 'Plus Jakarta Sans' }
            }
        });

        const paymentElement = elements.create('payment');
        paymentElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Traitement...';

            if (method === 'stripe') {
                const {error} = await stripe.confirmPayment({
                    elements,
                    confirmParams: { return_url: window.location.origin + '/player/reservation/success' },
                    redirect: 'if_required'
                });
                if (error) {
                    document.getElementById('card-errors').innerText = error.message;
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Confirmer la réservation <i class="fas fa-shield-alt text-[10px]"></i>';
                } else {
                    form.submit();
                }
            } else {
                form.submit();
            }
        });
    </script>
</body>
</html>