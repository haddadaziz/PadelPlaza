<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Communauté</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .sidebar-item-active { background-color: #F0FDF4; color: #10B981; border-right: 4px solid #10B981; }
        .lvl-badge { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')


    <main class="flex-1 ml-64 p-10">
        
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">Membres du Club</h2>
                <p class="text-slate-400 font-medium">Gérez les comptes, les niveaux et les Plaza Coins.</p>
            </div>
            <div class="flex gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Rechercher un joueur..." class="pl-12 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-emerald-500 transition-all w-64 shadow-sm">
                </div>
                <button class="bg-slate-900 text-white px-6 py-3.5 rounded-2xl font-black text-xs uppercase italic tracking-widest hover:bg-emerald-600 transition-all">
                    Exporter CSV
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] bg-slate-50/50">
                        <th class="px-8 py-5">Joueur</th>
                        <th class="px-8 py-5">Niveau & XP</th>
                        <th class="px-8 py-5 text-center">Solde Coins</th>
                        <th class="px-8 py-5">Dernière activité</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                                <tbody class="divide-y divide-slate-50">
                    @forelse($players as $player)
                    <tr class="group hover:bg-slate-50/50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
<!-- Photo ou Initiales -->
<div class="w-12 h-12 rounded-full bg-emerald-100 border-2 border-white shadow-sm flex items-center justify-center font-black text-emerald-600 uppercase overflow-hidden">
    @if($player->profile_image)
        <img src="{{ asset('storage/' . $player->profile_image) }}" alt="Photo de {{ $player->name }}" class="w-full h-full object-cover">
    @else
        {{ substr($player->name, 0, 2) }}
    @endif
</div>

                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5">
                                <span class="px-3 py-1 lvl-badge text-white text-[9px] font-black rounded-full uppercase w-fit shadow-md shadow-emerald-100 italic">
                                    <!-- Affiche le nom du niveau si relié, sinon "Débutant" -->
                                    {{ $player->level ? $player->level->level_name : 'Débutant' }}
                                </span>
                                <p class="text-[10px] font-bold text-slate-400 tracking-tighter uppercase italic">{{ $player->xp_points }} XP</p>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="font-black text-emerald-500 text-lg tracking-tighter italic">{{ $player->coins_balance }} <span class="text-[10px] text-slate-300">PC</span></span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-500 italic">Il y a {{ $player->updated_at->diffForHumans(null, true) }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
<a href="{{ route('admin.players.recharge', ['id' => $player->id]) }}" title="Créditer Coins" class="w-9 h-9 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all">
       <i class="fas fa-plus-circle"></i>
</a>

                                <button title="Editer Profil" class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                                    <i class="fas fa-user-edit"></i>
                                </button>
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
    <p class="text-xs font-bold text-slate-400 italic uppercase">
        Page {{ $players->currentPage() }} • {{ $players->total() }} Joueurs au total dans le club
    </p>


    <!-- La magie Laravel génère les flèches et les numéros toute seule ! -->
    <div class="mt-4 md:mt-0">
        {{ $players->links() }}
    </div>
</div>


    </main>
    @include('components.notif')

</body>
</html>