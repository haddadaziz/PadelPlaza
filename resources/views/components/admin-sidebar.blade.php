<aside class="w-64 bg-white border-r border-slate-100 flex flex-col fixed h-full transition-all z-50">
    <div class="p-8">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-11 h-11 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:rotate-6 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M7 15V5c0-1.1.9-2 2-2h4a4 4 0 1 1 0 8H9" stroke-linecap="round" />
                    <circle cx="16" cy="16" r="4" fill="currentColor" fill-opacity="0.2" />
                    <circle cx="16" cy="16" r="1.5" fill="white" />
                </svg>
            </div>
            <span class="text-xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                PADEL<span class="text-emerald-500">PLAZA</span>
            </span>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-2">
        <div class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Menu Principal</div>
        
        <a href="{{ route('home') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->routeIs('home') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('home') ? 'bg-white/20' : 'bg-slate-50 group-hover:bg-white' }}">
                <i class="fas fa-chart-pie text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Vue d'ensemble</span>
        </a>

        <a href="{{ route('admin.reservations') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->routeIs('admin.reservations*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.reservations*') ? 'bg-white/20' : 'bg-slate-50 group-hover:bg-white' }}">
                <i class="fas fa-calendar-check text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Réservations</span>
        </a>

        <a href="{{ route('admin.courts') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->routeIs('admin.courts*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.courts*') ? 'bg-white/20' : 'bg-slate-50 group-hover:bg-white' }}">
                <i class="fas fa-table-tennis-paddle-ball text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Gestion Courts</span>
        </a>

        <a href="{{ route('admin.equipments') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->routeIs('admin.equipments*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.equipments*') ? 'bg-white/20' : 'bg-slate-50 group-hover:bg-white' }}">
                <i class="fas fa-boxes text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Équipements</span>
        </a>

        <a href="{{ route('admin.players') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all group {{ request()->routeIs('admin.players*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.players*') ? 'bg-white/20' : 'bg-slate-50 group-hover:bg-white' }}">
                <i class="fas fa-users text-sm"></i>
            </div>
            <span class="font-bold text-[11px] uppercase tracking-widest italic">Joueurs</span>
        </a>
    </nav>

    <div class="p-6 mt-auto border-t border-slate-50 space-y-3">
        <a href="/profile" class="group block bg-slate-900 rounded-[1.5rem] p-4 flex items-center gap-3 shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 group-hover:bg-white group-hover:text-emerald-600 flex items-center justify-center font-black text-white text-xs shadow-lg transition-colors">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} 
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-white truncate italic uppercase tracking-tight">Mon Compte</p>
                <p class="text-[8px] text-emerald-400 group-hover:text-white uppercase font-black tracking-[0.2em] transition-colors italic">Modifier</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-slate-600 group-hover:text-white text-[10px] transition-colors"></i>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="group w-full flex items-center justify-center gap-3 py-3.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white transition-all duration-300 font-black text-[10px] uppercase tracking-[0.2em] italic">
                <i class="fas fa-power-off group-hover:rotate-12 transition-transform"></i> 
                Déconnexion
            </button>
        </form>
    </div>
</aside>