<aside class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col fixed h-full transition-all z-50">
    <div class="p-8">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-11 h-11 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:rotate-6 transition-transform duration-300">
                <i class="fas fa-table-tennis text-white text-xl"></i>
            </div>
            <span class="text-xl font-black text-white tracking-tighter italic uppercase leading-none">
                PADEL<span class="text-emerald-500">PLAZA</span>
            </span>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-2 mt-4">
        <div class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">Mon Espace</div>
        
        <a href="/player/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->is('player/dashboard','player/recharge') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ request()->is('player/dashboard', 'player/recharge') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <i class="fas fa-home text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Mon Arena</span>
        </a>

        <a href="{{ route('player.reservations.create') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->is('player/reservations*') ? 'bg-emerald-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ request()->is('player/reservations*') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <i class="fas fa-calendar-plus text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Réserver</span>
        </a>

        <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group text-slate-400 hover:bg-slate-800 hover:text-white">
             <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-800 group-hover:bg-slate-700">
                <i class="fas fa-history text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Mes Matchs</span>
        </a>
                <a href="{{ route('player.transactions') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->is('player/transactions*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ request()->is('player/transactions*') ? 'bg-white/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
               <i class="fas fa-receipt text-sm"></i>
           </div>
           <span class="font-bold text-[11px] uppercase tracking-widest italic">Transactions</span>
       </a>

    </nav>

    <div class="p-6 mt-auto border-t border-slate-800 space-y-3">
        <a href="{{ route('profile') }}" class="group block bg-slate-800/50 rounded-[1.5rem] p-4 flex items-center gap-3 shadow-xl border border-white/5 hover:bg-emerald-600 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 group-hover:bg-white group-hover:text-emerald-600 flex items-center justify-center font-black text-white text-xs shadow-lg transition-colors">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} 
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-white truncate italic uppercase tracking-tight">Mon Profil</p>
                <p class="text-[8px] text-emerald-400 group-hover:text-white uppercase font-black tracking-[0.2em] italic">Sécurité</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-slate-600 group-hover:text-white text-[10px] transition-colors"></i>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="group w-full flex items-center justify-center gap-3 py-3.5 rounded-xl bg-slate-800/30 text-slate-500 hover:bg-red-500 hover:text-white transition-all duration-300 font-black text-[10px] uppercase tracking-[0.2em] italic">
                <i class="fas fa-power-off group-hover:rotate-12 transition-transform"></i> 
                Déconnexion
            </button>
        </form>
    </div>
</aside>