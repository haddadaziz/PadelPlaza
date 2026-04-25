<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Paramètres</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .locked-input { background-color: #F1F5F9; cursor: not-allowed; border-color: transparent !important; }
    </style>
</head>
<body class="flex min-h-screen">

    @if(Auth::user()->role === 'admin')
        @include('components.admin-sidebar')
    @else
        @include('components.player-sidebar')
    @endif

    <main class="flex-1 lg:ml-64 p-6 lg:p-10 mt-16 lg:mt-0">
        <div class="mb-10">
            <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4 gap-2">
                <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Accueil</a>
                <span>/</span>
                <span class="text-slate-900">Paramètres Profil</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Configuration Compte</h2>
            <p class="text-slate-400 font-bold text-sm">Gérez vos accès et votre sécurité Plaza.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="bg-slate-900 rounded-[3rem] p-10 text-center flex flex-col items-center justify-center shadow-2xl shadow-slate-200 relative overflow-hidden h-fit">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                
                <form action="{{ route('profile.image') }}" method="POST" enctype="multipart/form-data" class="relative group z-10 mb-6">
                    @csrf
                    @method('PATCH')
                    <div class="w-32 h-32 rounded-[2.5rem] bg-emerald-500 overflow-hidden shadow-2xl border-4 border-slate-800 relative transition-transform group-hover:scale-105 duration-500">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white text-4xl font-black">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        
                        @if(Auth::user()->role === 'player')
                            <label for="profile_image" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                <i class="fas fa-camera text-white text-xl"></i>
                            </label>
                        @endif
                    </div>
                    
                    <input type="file" name="image" id="profile_image" class="hidden" onchange="this.form.submit()">
                    
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-2xl shadow-lg flex items-center justify-center text-slate-900 border-4 border-slate-900 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-pen text-xs"></i>
                    </div>
                </form>
                
                <h3 class="text-xl font-black text-white uppercase tracking-tight z-10">{{ Auth::user()->name }}</h3>
                <p class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.3em] mt-2 z-10">{{ Auth::user()->role }}</p>
                
                <div class="mt-8 pt-8 border-t border-white/5 w-full grid grid-cols-2 gap-4 z-10">
                    <div class="text-left">
                        <p class="text-slate-500 text-[9px] font-black uppercase">Solde</p>
                        <p class="text-white font-black text-lg tracking-tight">{{ Auth::user()->coins_balance ?? 0 }} <span class="text-emerald-500 text-[10px]">PC</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-500 text-[9px] font-black uppercase">Membre depuis</p>
                        <p class="text-white font-bold text-sm">{{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm group">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Informations fixes</h4>
                        </div>
                        @if(Auth::user()->role !== 'admin')
                            <span class="text-[8px] font-black text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase">Lecture seule</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nom Complet</label>
                            <input type="text" value="{{ Auth::user()->name }}" {{ Auth::user()->role !== 'admin' ? 'readonly' : '' }} class="w-full mt-2 px-6 py-4 rounded-2xl font-bold outline-none transition-all {{ Auth::user()->role !== 'admin' ? 'locked-input text-slate-400' : 'bg-slate-50 focus:bg-white border-2 border-transparent focus:border-emerald-500' }}">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" {{ Auth::user()->role !== 'admin' ? 'readonly' : '' }} class="w-full mt-2 px-6 py-4 rounded-2xl font-bold outline-none transition-all {{ Auth::user()->role !== 'admin' ? 'locked-input text-slate-400' : 'bg-slate-50 focus:bg-white border-2 border-transparent focus:border-emerald-500' }}">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-xl shadow-emerald-900/5 group">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Changer le mot de passe</h4>
                    </div>

                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full mt-2 px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirmer nouveau</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full mt-2 px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none">
                            </div>
                        </div>
                        <button type="submit" class="bg-slate-900 hover:bg-emerald-500 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('components.notif')

    <script>
        document.querySelector('form[action="{{ route("profile.password") }}"]').addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Mise à jour...';
        });
    </script>
</body>
</html>