<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Communauté</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .sidebar-item-active { background-color: #F0FDF4; color: #10B981; border-right: 4px solid #10B981; }
        .lvl-badge { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')


    <main class="flex-1 lg:ml-64 p-6 lg:p-10 mt-16 lg:mt-0">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Membres du Club</h2>
                <p class="text-slate-400 font-medium">Gérez les comptes, les niveaux et les Plaza Coins.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="relative w-full">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="player-search" placeholder="Recherche..." 
                           class="pl-12 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-emerald-500 transition-all w-full md:w-64 shadow-sm">
                </div>

                <button class="bg-slate-900 text-white px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all w-full sm:w-auto">
                    Export
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] bg-slate-50/50">
                        <th class="px-4 lg:px-8 py-5">Joueur</th>
                        <th class="px-4 lg:px-8 py-5 hidden sm:table-cell">Niveau & XP</th>
                        <th class="px-4 lg:px-8 py-5 text-center">Solde</th>
                        <th class="px-4 lg:px-8 py-5 hidden lg:table-cell">Activité</th>
                        <th class="px-4 lg:px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="player-table-body" class="divide-y divide-slate-50">
                    @forelse($players as $player)
                    <tr class="player-row group hover:bg-slate-50/50 transition-all {{ $player->is_blocked ? 'opacity-60' : '' }}" data-name="{{ strtolower($player->name) }}">
                        <td class="px-4 lg:px-8 py-4 lg:py-6">
                            <div class="flex items-center gap-3 lg:gap-4">
                                <!-- Photo ou Initiales -->
                                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-emerald-100 border-2 border-white shadow-sm flex items-center justify-center font-black text-emerald-600 uppercase overflow-hidden shrink-0">
                                    @if($player->profile_image)
<img src="{{ Str::startsWith($player->profile_image, 'http') ? $player->profile_image : asset('storage/' . $player->profile_image) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($player->name, 0, 2) }}
                                    @endif
                                </div>
                                <div class="min-w-0 leading-tight">
                                    <p class="player-name font-bold text-slate-900 text-xs lg:text-base break-words">{{ $player->name }}</p>
                                    @if($player->is_blocked)
                                        <span class="text-[8px] font-black text-red-500 uppercase tracking-widest bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                            <i class="fas fa-ban mr-1"></i> Bloqué
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 hidden sm:table-cell">
                            <div class="flex flex-col gap-1.5">
                                <span class="px-3 py-1 lvl-badge text-white text-[9px] font-black rounded-full uppercase w-fit shadow-md shadow-emerald-100">
                                    {{ $player->level ? $player->level->level_name : 'Débutant' }}
                                </span>
                                <p class="text-[10px] font-bold text-slate-400 tracking-tight uppercase">{{ $player->xp_points }} XP</p>
                            </div>
                        </td>
                        <td class="px-4 lg:px-8 py-4 lg:py-6 text-center">
                            <span class="font-black text-emerald-500 text-base lg:text-lg tracking-tight">{{ $player->coins_balance }} <span class="text-[10px] text-slate-300">PC</span></span>
                        </td>
                        <td class="px-8 py-6 hidden lg:table-cell">
                            <span class="text-xs font-bold text-slate-500">Il y a {{ $player->updated_at->diffForHumans(null, true) }}</span>
                        </td>
                        <td class="px-4 lg:px-8 py-4 lg:py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.players.recharge', ['id' => $player->id]) }}" title="Créditer Coins" class="w-9 h-9 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all">
                                    <i class="fas fa-plus-circle"></i>
                                </a>

                                <form action="{{ route('admin.players.block', $player->id) }}" method="POST" onsubmit="return confirm('{{ $player->is_blocked ? 'Débloquer ce joueur ?' : 'Bloquer ce joueur ?' }}')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="{{ $player->is_blocked ? 'Débloquer' : 'Bloquer' }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl transition-all
                                            {{ $player->is_blocked
                                                ? 'bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white'
                                                : 'bg-red-50 text-red-400 hover:bg-red-500 hover:text-white' }}">
                                        <i class="fas {{ $player->is_blocked ? 'fa-lock-open' : 'fa-ban' }} text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center font-bold text-slate-400">
                            Aucun joueur inscrit pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-8 flex flex-col md:flex-row justify-between items-center px-4 gap-4">
            <p class="text-xs font-bold text-slate-400 uppercase">
                Page {{ $players->currentPage() }} • {{ $players->total() }} Joueurs au total dans le club
            </p>

            <div class="mt-4 md:mt-0">
                {{ $players->links() }}
            </div>
        </div>


    </main>
    @include('components.notif')

    <script>
        document.getElementById('player-search').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.player-row');
            
            rows.forEach(row => {
                let name = row.getAttribute('data-name');
                if (name.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>

</body>
</html>