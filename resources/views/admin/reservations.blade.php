<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Gestion des Réservations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-10">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">Planning des Matchs</h2>
                <p class="text-slate-400 font-medium italic">Gérez les créneaux et les présences des joueurs.</p>
            </div>
            <a href="{{ route('admin.reservations.create') }}" class="bg-slate-900 hover:bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center gap-2 uppercase text-sm tracking-tighter italic">
                <i class="fas fa-plus-circle"></i> Ajouter manuellement
            </a>
        </div>

        <!-- BARRE DE FILTRES -->
        <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm mb-8 flex flex-wrap items-center gap-6">
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Terrain</label>
                <select class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none appearance-none pr-10">
                    <option>Tous les terrains</option>
                    <!-- On pourra boucler dynamiquement sur les terrains plus tard ici -->
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Statut</label>
                <select class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none appearance-none pr-10">
                    <option>Tous les statuts</option>
                    <option>Confirmé</option>
                    <option>En attente</option>
                    <option>Annulé</option>
                </select>
            </div>

            <button class="mt-5 ml-auto bg-emerald-50 text-emerald-600 px-6 py-2.5 rounded-xl font-black text-xs uppercase hover:bg-emerald-100 transition-colors">
                <i class="fas fa-filter mr-2"></i> Appliquer les filtres
            </button>
        </div>

        <!-- TABLEAU DYNAMIQUE DES RÉSERVATIONS -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] bg-slate-50/50">
                        <th class="px-8 py-5">Joueur</th>
                        <th class="px-8 py-5">Terrain & Heure</th>
                        <th class="px-8 py-5">Détails Financiers</th>
                        <th class="px-8 py-5 text-center">Statut</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    
                    @forelse($reservations as $reservation)
                    <tr class="group hover:bg-slate-50/50 transition-all">
                        
                        <!-- JOUEUR -->
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-slate-900 border-2 border-slate-100 shadow-sm flex items-center justify-center font-black text-emerald-400 uppercase overflow-hidden">
    @if($reservation->user->profile_image)
        <img src="{{ asset('storage/' . $reservation->user->profile_image) }}" alt="Photo" class="w-full h-full object-cover">
    @else
        {{ substr($reservation->user->name, 0, 2) }}
    @endif
</div>

                                <div>
                                    <p class="font-bold text-slate-900 italic text-base">{{ $reservation->user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-0.5">#RSV-{{ $reservation->id }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- TERRAIN & HEURE -->
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5">
                                <span class="font-black text-slate-900 italic uppercase text-xs">{{ $reservation->court->name }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-2.5 py-1 rounded-md">
                                        <i class="far fa-calendar-alt text-emerald-500 mr-1"></i> {{ \Carbon\Carbon::parse($reservation->start_time)->format('d M') }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-2.5 py-1 rounded-md">
                                        <i class="far fa-clock text-emerald-500 mr-1"></i> {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- DÉTAILS FINANCIERS + MATÉRIEL JSON -->
                        <td class="px-8 py-6">
                            <p class="font-black text-slate-900 italic">{{ $reservation->total_price }} <span class="text-[10px]">PC</span></p>
                            
                            @if($reservation->equipments_info && count($reservation->equipments_info) > 0)
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach($reservation->equipments_info as $item)
                                        <span class="inline-block bg-slate-100 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-widest">
                                            {{ $item['qty'] }}x {{ $item['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-[9px] text-slate-300 font-bold uppercase tracking-widest">Sans équipement</span>
                            @endif
                        </td>

                        <!-- STATUT -->
                        <td class="px-8 py-6 text-center">
                            @if($reservation->status == 'confirmed')
                                <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-full uppercase tracking-widest border border-emerald-100"><i class="fas fa-check mr-1"></i> Confirmé</span>
                            @elseif($reservation->status == 'pending')
                                <span class="px-4 py-1.5 bg-amber-50 text-amber-600 text-[9px] font-black rounded-full uppercase tracking-widest border border-amber-100"><i class="fas fa-clock mr-1"></i> À régler</span>
                            @else
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-[9px] font-black rounded-full uppercase tracking-widest border border-slate-200">Annulé</span>
                            @endif
                        </td>

                        <!-- ACTIONS -->
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                @if($reservation->status == 'pending')
                                <button title="Valider le paiement sur place" class="w-9 h-9 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-check-double"></i>
                                </button>
                                @endif
                                <button title="Annuler le match" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    @empty
                    <!-- LE "VIDE" DE TA MAQUETTE -->
                    <tr>
                        <td colspan="5" class="p-0">
                            <div class="min-h-[400px] flex flex-col items-center justify-center p-10 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 border border-dashed border-slate-200">
                                    <i class="fas fa-calendar-times text-slate-200 text-4xl"></i>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 italic uppercase tracking-tighter">Aucune réservation</h3>
                                <p class="text-slate-400 font-medium max-w-xs mt-2 text-xs">
                                    Il n'y a pas encore de matchs prévus pour l'instant.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>

    </main>
    @include('components.notif')
</body>
</html>
