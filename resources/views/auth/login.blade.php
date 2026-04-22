<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; overflow: hidden; }
        .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#F0FDF4] flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[440px] fade-in-up">

        <!-- Affichage des erreurs de connexion -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-2xl text-sm font-bold mb-4 border border-red-200">
                {{ $errors->first('email') }}
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-emerald-100 p-8 md:p-10">
            
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-200 mb-4 transition-transform hover:rotate-3">
                    <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M7 15V5c0-1.1.9-2 2-2h4a4 4 0 1 1 0 8H9" stroke-linecap="round"/>
                        <circle cx="16" cy="16" r="4" fill="currentColor" fill-opacity="0.2"/>
                        <circle cx="16" cy="16" r="1.5" fill="white"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-[900] text-slate-900 tracking-tight uppercase leading-none">PADEL<span class="text-emerald-500">PLAZA</span></h1>
            </div>

            <!-- Ajout de l'Action et du paramètre Method -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                <!-- LE TOKEN CSRF EST OBLIGATOIRE -->
                @csrf 

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Admin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <!-- Ajout du "name" -->
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="aziz@padelplaza.ma" 
                            class="w-full pl-14 pr-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none placeholder:text-slate-300 shadow-sm">
                    </div>
                </div>
                
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <!-- Ajout du "name" -->
                        <input type="password" name="password" placeholder="••••••••••••" 
                            class="w-full pl-14 pr-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-semibold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500/20">
                        <span class="text-xs text-slate-500 font-bold group-hover:text-slate-800 transition-colors">Rester connecté</span>
                    </label>
                    <a href="#" class="text-xs text-emerald-600 font-extrabold">Oublié ?</a>
                </div>

                <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-slate-200 active:scale-95 flex items-center justify-center gap-2 text-lg uppercase tracking-tight">
                    Entrer au Club
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-400 font-bold tracking-tight uppercase">
                Nouveau au Club ? 
                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 underline underline-offset-4 font-black">
                    Créer un compte
                </a>
            </p>
        </div>

        </div>
        
        <p class="text-center text-slate-400 text-[9px] mt-8 font-black uppercase tracking-[0.3em]">Padel Plaza</p>
    </div>
        @include('components.notif')

</body>
</html>
