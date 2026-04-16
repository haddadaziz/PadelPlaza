    <aside class="w-64 bg-white border-r border-slate-100 flex flex-col fixed h-full transition-all">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M7 15V5c0-1.1.9-2 2-2h4a4 4 0 1 1 0 8H9" stroke-linecap="round" />
                        <circle cx="16" cy="16" r="4" fill="currentColor" fill-opacity="0.2" />
                        <circle cx="16" cy="16" r="1.5" fill="white" />
                    </svg>
                </div>
                <span class="text-xl font-black text-slate-900 tracking-tighter italic">PADEL<span
                        class="text-emerald-500">PLAZA</span></span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1">
            <div class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu</div>
            
            <!-- Lien vers le Dashboard -->
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-4 py-3 rounded-lg font-bold transition-all">
                <i class="fas fa-chart-pie text-lg"></i> Vue d'ensemble
            </a>
            
            <!-- Lien vers les Réservations -->
            <a href="{{ route('admin.reservations') }}" class="{{ request()->routeIs('admin.reservations') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-4 py-3 rounded-lg font-bold transition-all">
                <i class="fas fa-calendar-check text-lg"></i> Réservations
            </a>
            
            <!-- Lien vers la gestion des Courts -->
            <a href="{{ route('admin.courts') }}" class="{{ request()->routeIs('admin.courts') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-4 py-3 rounded-lg font-bold transition-all">
                <i class="fas fa-table-tennis-paddle-ball text-lg"></i> Gestion Courts
            </a>

                            <a href="{{ route('admin.equipments') }}" class="flex items-center gap-4 px-6 py-4 text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 transition-all group {{ request()->routeIs('admin.equipments') ? 'sidebar-item-active' : '' }}">
                    <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center group-hover:bg-white transition-colors {{ request()->routeIs('admin.equipments') ? 'bg-white' : '' }}">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span class="font-black text-[11px] uppercase tracking-widest italic mt-1">Équipements</span>
                </a>

            <!-- Lien vers la liste des Joueurs -->
            <a href="{{ route('admin.players') }}" class="{{ request()->routeIs('admin.players') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-4 py-3 rounded-lg font-bold transition-all">
                <i class="fas fa-users text-lg"></i> Joueurs
            </a>
        </nav>


        <!-- NOUVEAU : Profil Laravel Dynamique & Déconnexion -->
        <div class="p-6 space-y-3">
            <div class="bg-slate-900 rounded-2xl p-4 flex items-center gap-3 shadow-xl shadow-slate-200">
                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-white text-xs uppercase">
                    <!-- Prend les deux premières lettres du Nom -->
                    {{ substr(Auth::user()->name, 0, 2) }} 
                </div>
                <div class="overflow-hidden">
                    <p class="text-[12px] font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-emerald-400 uppercase font-black tracking-widest">{{ Auth::user()->role }}</p>
                </div>
            </div>

            <!-- Formulaire de Déconnexion -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors font-bold text-xs uppercase tracking-widest">
                    <i class="fas fa-power-off"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>