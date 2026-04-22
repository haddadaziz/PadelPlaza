<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Le Club Nouvelle Génération</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-white text-slate-900">

    <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-xl border-b border-slate-100 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:rotate-6 transition-transform">
                    <i class="fas fa-table-tennis text-white text-lg"></i>
                </div>
                <span class="text-2xl font-[900] text-slate-900 tracking-tight uppercase leading-none">PADEL<span class="text-emerald-500">PLAZA</span></span>
            </div>

            <div class="hidden md:flex items-center gap-10 text-[11px] font-black uppercase tracking-[0.2em] text-slate-500">
                <a href="#concept" class="hover:text-emerald-500 transition-colors">Concept</a>
                <a href="#terrains" class="hover:text-emerald-500 transition-colors">Terrains</a>
                <a href="#avantages" class="hover:text-emerald-500 transition-colors">Avantages</a>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('login') }}"
                    class="text-xs font-black uppercase tracking-tight hover:text-emerald-500 transition-colors">Connexion</a>
                <a href="{{ route('register') }}"
                    class="bg-slate-900 text-white px-7 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] hover:bg-emerald-500 transition-all shadow-xl shadow-slate-200 active:scale-95">
                    S'inscrire
                </a>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-24 px-6 min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://plus.unsplash.com/premium_photo-1708692921020-e58a86c83b5a?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                class="w-full h-full object-cover" alt="Padel Court">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/95 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center relative z-10">
            <div class="fade-in-up">
                <span
                    class="bg-emerald-500 text-white px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-8 inline-block shadow-xl shadow-emerald-100">
                    Luxury Sports Experience
                </span>
                <h2 class="text-5xl md:text-7xl font-[900] text-slate-900 tracking-tight leading-none mb-6">
                    LE PADEL <br>
                    <span class="text-emerald-500">NOUVELLE</span> <br>
                    GÉNÉRATION
                </h2>
                <p class="text-slate-400 text-lg md:text-xl font-medium max-w-lg mb-10 leading-relaxed capitalize">
                    Vivez l'expérience Padel ultime dans un complexe ultra-moderne conçu pour la performance et le plaisir.
                </p>
                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('register') }}"
                        class="bg-emerald-500 text-white px-12 py-5 rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-2xl shadow-emerald-200 text-center flex items-center justify-center gap-3 active:scale-95">
                        Créer mon profil <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="#concept"
                        class="bg-white/80 backdrop-blur-md border-2 border-slate-100 text-slate-900 px-12 py-5 rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-white transition-all text-center active:scale-95">
                        Le Concept
                    </a>
                </div>
            </div>

            <div class="hidden md:flex justify-end fade-in-up" style="animation-delay: 0.2s;">
                <div
                    class="bg-white/10 backdrop-blur-2xl p-10 rounded-[3.5rem] border border-white/30 shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-700">
                    <div class="flex items-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-white/70 uppercase tracking-widest">Membre Elite</p>
                            <p class="text-2xl font-black text-white uppercase tracking-tight">Haddad Aziz</p>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div class="flex justify-between text-[10px] font-black text-white/80 uppercase">
                            <span>Progression Niveau</span>
                            <span>85%</span>
                        </div>
                        <div class="h-2.5 w-full bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-[85%] shadow-[0_0_20px_rgba(52,211,153,0.8)]"></div>
                        </div>
                        <p class="text-white/50 text-[10px] font-bold tracking-widest uppercase text-right">
                            Prochaine récompense : 500 PC</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section id="concept" class="py-32 px-6 bg-[#0B0F19] relative overflow-hidden z-10">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 400 400\' xmlns=\'0 0 24 24\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E');"></div>
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-900/40 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px]"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            
            <div class="grid md:grid-cols-5 gap-12 items-center mb-24">
                <div class="md:col-span-3">
                    <span class="text-emerald-400 text-[11px] font-black uppercase tracking-[0.3em] mb-4 inline-block">L'Écosystème Digital Padel Plaza</span>
                    <h2 class="text-5xl md:text-7xl font-black text-white tracking-tight leading-[0.95] uppercase">
                        Plus qu'un <span class="text-emerald-400">match</span>,<br>une progression.
                    </h2>
                </div>
                <div class="md:col-span-2 text-slate-400 font-bold leading-relaxed text-lg self-end">
                    Nous avons fusionné la passion du Padel avec une technologie de pointe pour créer une expérience de jeu unique et récompensée.
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-16 items-center">
                
                <div class="relative group">
                    <div class="w-full aspect-[4/5] rounded-[3.5rem] bg-slate-800 border-4 border-slate-700/50 overflow-hidden relative shadow-2xl transition-transform duration-700 group-hover:-rotate-1">
                        <img src="https://images.unsplash.com/photo-1646649853703-7645147474ba?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 brightness-75 group-hover:brightness-100" alt="Action Padel Plaza">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0B0F19] via-transparent to-transparent opacity-60"></div>
                    </div>

                    <div class="absolute -top-6 -right-6 bg-white/10 backdrop-blur-2xl p-6 rounded-3xl border border-white/20 shadow-2xl group-hover:-translate-y-4 transition-transform duration-500 z-20">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-white/70 uppercase tracking-widest">Monnaie Virtuelle</p>
                                <p class="text-2xl font-black text-white uppercase tracking-tight">Plaza Coins</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-12">
                    
                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 bg-slate-900 text-emerald-500 rounded-3xl flex items-center justify-center shrink-0 border border-slate-800 transition-all group-hover:bg-emerald-500 group-hover:text-white group-hover:border-emerald-400 group-hover:scale-110 shadow-xl">
                            <i class="fas fa-bolt text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-2 group-hover:text-emerald-400 transition-colors">Réservation Connectée</h3>
                            <p class="text-slate-400 font-bold leading-relaxed text-sm">Vérifiez les disponibilités et réservez votre terrain préféré en quelques secondes, où que vous soyez.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 bg-slate-900 text-blue-400 rounded-3xl flex items-center justify-center shrink-0 border border-slate-800 transition-all group-hover:bg-blue-500 group-hover:text-white group-hover:border-blue-400 group-hover:scale-110 shadow-xl">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-2 group-hover:text-blue-400 transition-colors">Portefeuille Virtuel</h3>
                            <p class="text-slate-400 font-bold leading-relaxed text-sm">Simplifiez vos transactions. Rechargez vos Plaza Coins et gérez vos dépenses sportives sans friction.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 bg-slate-900 text-orange-400 rounded-3xl flex items-center justify-center shrink-0 border border-slate-800 transition-all group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-400 group-hover:scale-110 shadow-xl">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-2 group-hover:text-orange-400 transition-colors">Gamification Elite</h3>
                            <p class="text-slate-400 font-bold leading-relaxed text-sm">Chaque match compte. Gagnez de l'XP, débloquez des badges et obtenez des avantages réservés aux meilleurs joueurs.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<section class="py-24 bg-white" id="terrains">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] mb-4">Nos infrastructures</h2>
            <p class="text-4xl font-black text-slate-900 tracking-tight uppercase">Des courts de classe <span class="text-emerald-500">mondiale</span></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($courts as $court)
            <div class="group bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl hover:shadow-emerald-900/10 transition-all duration-500 hover:-translate-y-2">
                <div class="relative h-72 overflow-hidden bg-slate-100">
<img src="{{ $court->image ? asset('storage/' . $court->image) : 'https://images.unsplash.com/photo-1626224580175-340ad0e3a761?q=80&w=800' }}" alt="{{ $court->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute top-6 right-6">
                        <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-xl">
                            {{ $court->type ?? 'Outdoor' }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-2">{{ $court->name }}</h3>
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-emerald-500 font-black text-xl">{{ $court->price_coins }} <span class="text-[10px] uppercase tracking-normal">PC /h</span></span>
                        <div class="h-4 w-px bg-slate-200"></div>
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Éclairage LED</span>
                    </div>

                    {{-- LOGIQUE D'ACCÈS --}}
                    @auth
                        <a href="/booking/{{ $court->id }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white text-center font-black py-4 rounded-2xl transition-all shadow-lg shadow-emerald-100 uppercase tracking-tight">
                            Réserver maintenant
                        </a>
                    @endauth

                    @guest
                        <a href="/login" class="block w-full bg-slate-900 hover:bg-emerald-500 text-white text-center font-black py-4 rounded-2xl transition-all shadow-xl shadow-slate-200 uppercase tracking-tight">
                            Se connecter pour réserver
                        </a>
                    @endguest
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="avantages" class="py-32 px-6 bg-white relative">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col items-center text-center mb-20">
                <span class="text-emerald-500 text-[11px] font-black uppercase tracking-[0.3em] mb-4">Privilèges Membres</span>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight uppercase">
                    L'expérience <span class="text-emerald-500">Premium</span>
                </h2>
                <div class="h-1.5 w-20 bg-emerald-500 mt-6 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                
                <div class="group p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-emerald-900/5 transition-all duration-500">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-map-marker-alt text-emerald-500"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-900 uppercase mb-3 leading-tight">Terrains<br>Panoramiques</h4>
                    <p class="text-slate-400 text-xs font-bold leading-relaxed">Jouez sur les meilleurs terrains du Maroc avec une visibilité totale et un revêtement WPT.</p>
                </div>

                <div class="group p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-emerald-900/5 transition-all duration-500">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-graduation-cap text-blue-500"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-900 uppercase mb-3 leading-tight">Coaching<br>Elite</h4>
                    <p class="text-slate-400 text-xs font-bold leading-relaxed">Améliorez votre technique avec nos coachs certifiés pour passer du rang Bronze à Elite.</p>
                </div>

                <div class="group p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-emerald-900/5 transition-all duration-500">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-orange-500"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-900 uppercase mb-3 leading-tight">Matchmaking<br>Intelligent</h4>
                    <p class="text-slate-400 text-xs font-bold leading-relaxed">Trouvez des partenaires de votre niveau grâce à notre algorithme de classement XP.</p>
                </div>

                <div class="group p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-emerald-900/5 transition-all duration-500">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-shopping-bag text-purple-500"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-900 uppercase mb-3 leading-tight">Plaza<br>Store</h4>
                    <p class="text-slate-400 text-xs font-bold leading-relaxed">Utilisez vos Plaza Coins accumulés pour louer du matériel pro ou acheter des boissons.</p>
                </div>

            </div>

            <div class="mt-20 bg-slate-900 rounded-[3rem] p-12 overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/20 rounded-full blur-[80px] -mr-32 -mt-32"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <h3 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tight">Prêt à entrer sur le terrain ?</h3>
                        <p class="text-slate-400 font-bold mt-2">Rejoignez plus de 1,200 joueurs passionnés dès aujourd'hui.</p>
                    </div>
                    <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-white hover:text-emerald-600 transition-all shadow-xl shadow-emerald-500/20 whitespace-nowrap">
                        Créer mon compte gratuitement
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white py-12 px-6 border-t border-slate-100">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">© 2026 Padel Plaza Club</p>
            <div class="flex gap-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <a href="#" class="hover:text-emerald-500 transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-emerald-500 transition-colors">Mentions Légales</a>
            </div>
        </div>
    </footer>

    @include('components.notif')
</body>

</html>