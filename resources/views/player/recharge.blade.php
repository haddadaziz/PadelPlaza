<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Recharger mon solde</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; overflow: hidden; }
        
        /* Design des cartes non-sélectionnées */
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
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.1);
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
            font-size: 1.2rem;
        }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.player-sidebar')

    <main class="flex-1 ml-64 p-8 h-screen overflow-hidden flex flex-col">
        
        <div class="mb-8 shrink-0">
            <h2 class="text-3xl font-[900] text-slate-900 tracking-tight uppercase">Recharger mes Crédits</h2>
            <p class="text-slate-400 font-bold text-sm mt-1">Obtenez des Plaza Coins pour réserver vos terrains instantanément.</p>
        </div>

        <form action="{{ route('player.recharge.process') }}" method="POST" id="recharge-form" class="grid grid-cols-12 gap-10 flex-1 min-h-0">
            @csrf
            
            <div class="col-span-7 flex flex-col min-h-0">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 shrink-0">Sélectionnez un Pack de Coins</h3>
                
                <div class="grid grid-cols-2 gap-4 overflow-y-auto pr-4 pt-6 pb-10 custom-scrollbar">
                    
                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="100" class="peer sr-only" checked onchange="updateTotal(100)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 mb-4">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <h4 class="text-2xl font-[900] text-slate-900 tracking-tight uppercase">100 PC</h4>
                            <p class="text-slate-500 font-black text-xs mt-2 uppercase tracking-widest">100 DH</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="500" class="peer sr-only" onchange="updateTotal(500)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center group">
                            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-bolt text-xl"></i>
                            </div>
                            <h4 class="text-2xl font-[900] text-slate-900 tracking-tight uppercase">500 PC</h4>
                            <p class="text-emerald-600 font-black text-xs mt-2 uppercase tracking-widest">450 DH <span class="text-[10px] text-slate-300 line-through ml-1">500</span></p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="amount" value="1200" class="peer sr-only" onchange="updateTotal(1200)">
                        <div class="pack-card bg-white p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-500 mb-4">
                                <i class="fas fa-crown text-xl"></i>
                            </div>
                            <h4 class="text-2xl font-[900] text-slate-900 tracking-tight uppercase">1200 PC</h4>
                            <p class="text-slate-500 font-black text-xs mt-2 uppercase tracking-widest">1000 DH</p>
                            <span class="mt-2 text-[8px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase">+200 PC Offerts</span>
                        </div>
                    </label>

                    <div class="bg-white p-8 rounded-[2.5rem] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 group hover:border-emerald-500 transition-all">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Saisie Libre</p>
                        <input type="number" id="custom-amount" placeholder="Coins..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-center font-black text-slate-900 focus:ring-2 focus:ring-emerald-500 transition-all outline-none" oninput="selectCustom()">
                    </div>
                </div>
            </div>

            <div class="col-span-5 flex flex-col min-h-0">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 shrink-0 text-right">Confirmation & Paiement</h3>
                
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-8 flex flex-col flex-1 min-h-0">
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 mb-8 text-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
                        <p class="text-[10px] font-black text-slate-500 uppercase mb-3 tracking-widest">Montant à régler</p>
                        <div class="flex items-center justify-center gap-2 relative z-10">
                            <span id="display-amount" class="text-6xl font-[900] text-white tracking-tight">100</span>
                            <span class="text-2xl font-black text-emerald-500 uppercase">DH</span>
                        </div>
                    </div>

                    <div class="flex-1 space-y-6 overflow-y-auto custom-scrollbar pr-2">
                        <div class="p-6 bg-slate-900 rounded-[2.5rem] border border-slate-800 shadow-xl">
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-4 block">Informations de carte</label>
                            <div id="card-element" class="p-2"></div>
                            <div id="card-errors" role="alert" class="text-red-400 text-[10px] font-bold mt-2"></div>
                        </div>

                        <div class="flex items-center gap-3 px-4">
                            <i class="fas fa-shield-check text-emerald-500 text-xl"></i>
                            <p class="text-[9px] text-slate-400 font-bold leading-relaxed uppercase">Paiement 100% sécurisé via Stripe. Vos Plaza Coins seront crédités instantanément.</p>
                        </div>
                    </div>

                    <button type="submit" id="submit-button" class="mt-8 bg-emerald-500 text-white w-full py-5 rounded-[1.8rem] font-[900] uppercase tracking-widest hover:bg-slate-900 transition-all shadow-2xl shadow-emerald-200 flex items-center justify-center gap-3">
                        Payer maintenant <i class="fas fa-rocket text-[10px]"></i>
                    </button>
                </div>
            </div>
        </form>
    </main>

        <script src="https://js.stripe.com/v3/"></script>
    <script>
        function updateTotal(val) {
            document.getElementById('display-amount').innerText = val;
            document.getElementById('custom-amount').value = '';
        }

        function selectCustom() {
            const val = document.getElementById('custom-amount').value;
            document.querySelectorAll('input[name="amount"]').forEach(r => r.checked = false);
            document.getElementById('display-amount').innerText = val || 0;
        }

        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements({
            appearance: {
                theme: 'night',
                variables: { colorPrimary: '#10B981', fontFamily: 'Inter' }
            }
        });

        const cardElement = elements.create('card', { hidePostalCode: true });
        cardElement.mount('#card-element');

        const form = document.getElementById('recharge-form');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // 1. On repère ce que le joueur a sélectionné comme montant
            let requestedPC = 0;
            const customInput = document.getElementById('custom-amount').value;
            const selectedRadio = document.querySelector('input[name="amount"]:checked');

            if (customInput) {
                requestedPC = customInput;
            } else {
                requestedPC = selectedRadio.value;
            }

            const submitBtn = document.getElementById('submit-button');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Liaison bancaire...';

            try {
                // 2. Sécurité : On demande le vrai prix à NOTRE Serveur !
                const response = await fetch('/api/create-recharge-intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount_pc: requestedPC })
                });
                
                const data = await response.json();
                
                if (data.error) {
                    document.getElementById('card-errors').innerText = data.error;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Payer maintenant';
                    return;
                }

                // 3. Paiement validé par Stripe
                const {error, paymentIntent} = await stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: { card: cardElement }
                });

                if (error) {
                    document.getElementById('card-errors').innerText = error.message;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Payer maintenant';
                } else if (paymentIntent.status === 'succeeded') {
                    // 4. Succès magique ! On greffe la somme validée pour la route PHP !
                    form.insertAdjacentHTML('beforeend', `<input type="hidden" name="verified_pc" value="${data.pc}">`);
                    form.submit();
                }

            } catch (err) {
                document.getElementById('card-errors').innerText = "Erreur réseau. Veuillez réessayer.";
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Payer maintenant';
            }
        });
    </script>

</body>
</html>