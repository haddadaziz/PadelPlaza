<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Mon Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .input-locked { background-color: #F8FAFC; cursor: not-allowed; border-color: transparent !important; color: #94A3B8; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-10">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase leading-none">Paramètres Compte</h2>
                <p class="text-slate-400 font-medium italic text-sm mt-2 uppercase tracking-tighter">Gérez vos accès et informations personnelles.</p>
            </div>
            @if(Auth::user()->role !== 'admin')
                <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full uppercase italic border border-emerald-100">Compte Joueur Vérifié</span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="bg-slate-900 rounded-[3rem] p-10 text-center flex flex-col items-center justify-center shadow-2xl shadow-slate-200 relative overflow-hidden h-fit">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                
                <div class="w-24 h-24 rounded-[2rem] bg-emerald-500 flex items-center justify-center text-white text-3xl font-black shadow-2xl shadow-emerald-500/20 mb-6 border-4 border-slate-800">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                
                <h3 class="text-xl font-black text-white italic uppercase tracking-tighter leading-none">{{ Auth::user()->name }}</h3>
                <p class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic">{{ Auth::user()->role }}</p>
                
                <div class="mt-8 pt-8 border-t border-white/5 w-full flex justify-between items-center px-2">
                    <div class="text-left">
                        <p class="text-slate-500 text-[9px] font-black uppercase italic">Solde Actuel</p>
                        <p class="text-white font-black text-lg italic tracking-tighter">{{ Auth::user()->coins ?? 0 }} <span class="text-emerald-500 text-xs">PC</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-500 text-[9px] font-black uppercase italic">Inscrit en</p>
                        <p class="text-white font-bold text-sm italic">{{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Informations du profil</h4>
                    </div>

                    <form action="{{ route('admin.profile.info') }}" method="POST" class="space-y-6">
                        @csrf
                         @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 flex justify-between">
                                    Nom Complet
                                    @if(Auth::user()->role !== 'admin') <i class="fas fa-lock text-[8px] mt-0.5"></i> @endif
                                </label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" 
                                    {{ Auth::user()->role !== 'admin' ? 'readonly' : '' }}
                                    class="w-full mt-2 px-6 py-4 rounded-2xl font-bold italic outline-none transition-all border-2 border-transparent {{ Auth::user()->role !== 'admin' ? 'input-locked' : 'bg-slate-50 focus:bg-white focus:border-emerald-500' }}">
                            </div>

                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 flex justify-between">
                                    Email
                                    @if(Auth::user()->role !== 'admin') <i class="fas fa-lock text-[8px] mt-0.5"></i> @endif
                                </label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" 
                                    {{ Auth::user()->role !== 'admin' ? 'readonly' : '' }}
                                    class="w-full mt-2 px-6 py-4 rounded-2xl font-bold italic outline-none transition-all border-2 border-transparent {{ Auth::user()->role !== 'admin' ? 'input-locked' : 'bg-slate-50 focus:bg-white focus:border-emerald-500' }}">
                            </div>
                        </div>
                        
                        @if(Auth::user()->role === 'admin')
                        <button type="submit" class="bg-slate-900 hover:bg-emerald-500 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase italic tracking-[0.2em] transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Sauvegarder les changements
                        </button>
                        @endif
                    </form>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm group">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-400 group-hover:bg-red-500 group-hover:text-white transition-all">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Sécurité & Mot de passe</h4>
                    </div>

                    <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full mt-2 px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div class="group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirmation</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full mt-2 px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none">
                            </div>
                        </div>
                        <button type="submit" class="bg-slate-900 hover:bg-emerald-500 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase italic tracking-[0.2em] transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Changer mon mot de passe
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </main>
    @include('components.notif')
</body>
</html>