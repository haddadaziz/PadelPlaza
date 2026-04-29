<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Rejoindre le Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#F0FDF4] flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[500px] fade-in-up">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-emerald-100 p-8 md:p-10">
            
            <div class="flex flex-col items-center mb-6">
                <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-200 mb-4 transition-transform hover:rotate-3">
                    <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M7 15V5c0-1.1.9-2 2-2h4a4 4 0 1 1 0 8H9" stroke-linecap="round"/>
                        <circle cx="16" cy="16" r="4" fill="currentColor" fill-opacity="0.2"/>
                        <circle cx="16" cy="16" r="1.5" fill="white"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-[900] text-slate-900 tracking-tight leading-none uppercase text-center">Créer un <span class="text-emerald-500">compte</span></h1>
            </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- NOM -->
            <div class="group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Nom Complet</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Aziz Haddad" 
                    class="w-full px-5 py-3 bg-slate-50 border-2 @error('name') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm" required>
                @error('name')
                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- EMAIL -->
            <div class="group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Email Personnel</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="aziz@example.com" 
                        class="w-full pl-14 pr-5 py-3 bg-slate-50 border-2 @error('email') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- MOT DE PASSE -->
            <div class="grid grid-cols-2 gap-4">
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" 
                        class="w-full px-5 py-3 bg-slate-50 border-2 @error('password') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm" required>
                    @error('password')
                        <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Confirmation</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" 
                        class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm" required>
                </div>
            </div>

            <!-- CONDITIONS -->
            <div class="px-1 py-1">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="terms" class="mt-1 w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500/20" required>
                    <span class="text-[10px] text-slate-400 font-bold leading-tight group-hover:text-slate-800 transition-colors">
                        J'accepte les conditions d'utilisation et la politique de confidentialité.
                    </span>
                </label>
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-slate-200 active:scale-95 flex items-center justify-center gap-2 text-lg uppercase tracking-tight">
                Rejoindre le Club
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-slate-400 font-bold tracking-tight">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 underline underline-offset-4 font-black">Connexion</a>
            </p>
        </div>
    </div>
    
    <p class="text-center text-slate-400 text-[9px] mt-8 font-black uppercase tracking-[0.3em]">NEW MEMBER ACCESS • 2026</p>
</div>
    @include('components.notif')
</body>
</html>
