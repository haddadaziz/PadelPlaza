<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }

        .sidebar-item-active {
            background-color: #F0FDF4;
            color: #10B981;
            border-right: 4px solid #10B981;
        }
    </style>
</head>

<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 lg:ml-64 p-6 lg:p-10 mt-16 lg:mt-0">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Tableau de bord</h2>
                <p class="text-slate-400 font-medium">Suivez l'activité de votre club en temps réel.</p>
            </div>
<a href="{{ route('admin.courts.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-100 transition-all flex items-center gap-2 active:scale-95">
    <i class="fas fa-plus-circle"></i> Nouveau Terrain
</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- [TES 4 CARTES DE STATISTIQUES SONT GARDÉES EXACTEMENT PAREIL ICI] -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Chiffre d'affaire</p>
<h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($chiffreAffaire, 0, ',', ' ') }} <span class="text-xs font-medium text-slate-400">PPC</span></h3>
            </div>

<div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
    <div class="flex justify-between items-start mb-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
            <i class="fas fa-trophy text-xl"></i>
        </div>
    </div>
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Matchs disputés</p>
    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $matchsDisputes }} <span class="text-xs font-medium text-slate-400">Matchs</span></h3>
</div>


<!-- Carte 3 : Réservations à venir -->
<div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
    <div class="flex justify-between items-start mb-4">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
            <i class="fas fa-calendar-day text-xl"></i>
        </div>
    </div>
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Réservations à venir</p>
<h3 class="text-2xl font-black text-slate-900 mt-1">{{ $reservationsAVenir }} <span class="text-xs font-medium text-slate-400">Réservation</span></h3>
</div>

<!-- Carte 4 : PPC en circulation -->
<div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
    <div class="flex justify-between items-start mb-4">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
            <i class="fas fa-coins text-xl"></i>
        </div>
    </div>
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">PPC en circulation</p>
<h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($ppcCirculation, 0, ',', ' ') }} <span class="text-xs font-medium text-slate-400">PPC</span></h3>
</div>

        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
                <h4 class="text-lg font-black text-slate-900 uppercase tracking-tight">Gestion des Terrains</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] bg-slate-50/50">
                            <th class="px-8 py-4">Terrain</th>
                            <th class="px-8 py-4 hidden sm:table-cell">Type</th>
                            <th class="px-8 py-4 text-center">Tarif</th>
                            <th class="px-8 py-4 hidden md:table-cell">Statut</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($courts as $court)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-900 text-base">{{ $court->name }}</span>
                            </td>
                            <td class="px-8 py-5 hidden sm:table-cell">
                                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black text-slate-500 uppercase tracking-tight">
                                    {{ $court->type ?? 'Indoor' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="font-black text-emerald-500 tracking-tight">{{ $court->price_coins }} PC</span>
                            </td>
<td class="px-8 py-5 hidden md:table-cell">
    <div class="flex items-center gap-2 {{ $court->is_active ? 'text-emerald-500' : 'text-red-400' }} font-bold text-[11px] uppercase tracking-tight">
        <span class="w-2 h-2 {{ $court->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-red-400' }} rounded-full"></span>
        {{ $court->is_active ? 'Actif' : 'Mainten.' }}
    </div>
</td>

<td class="px-8 py-5 text-right flex justify-end gap-2">
    <!-- Bouton Modifier -->
    <a href="{{ route('admin.courts.edit', $court->id) }}" class="p-2 text-slate-400 hover:text-emerald-500 transition-colors">
        <i class="fas fa-edit"></i>
    </a>

    <!-- Bouton Supprimer -->
    <form action="{{ route('admin.courts.destroy', $court->id) }}" method="POST" onsubmit="return confirm('Es-tu sûr de vouloir supprimer ce terrain ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
        @include('components.notif')

</body>

</html>
