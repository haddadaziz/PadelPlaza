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
        .sidebar-item-active { background-color: #F0FDF4; color: #10B981; border-right: 4px solid #10B981; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 ml-64 p-10">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Planning des Réservations</h2>
                <p class="text-slate-400 font-medium italic">Gérez les créneaux et les présences des joueurs.</p>
            </div>
            <button class="bg-slate-900 hover:bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center gap-2 uppercase text-sm tracking-tighter italic">
                <i class="fas fa-plus-circle"></i> Ajouter manuellement
            </button>
        </div>

        <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm mb-8 flex flex-wrap items-center gap-6">
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date du jour</label>
                <input type="date" value="2026-04-15" class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Terrain</label>
                <select class="bg-slate-50 border-none rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none appearance-none pr-10">
                    <option>Tous les terrains</option>
                    <option>Court Central</option>
                    <option>Padel Indoor 1</option>
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

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden min-h-[400px] flex flex-col items-center justify-center p-10 text-center">
            
            <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mb-6 border border-dashed border-slate-200">
                <i class="fas fa-calendar-times text-slate-200 text-5xl"></i>
            </div>
            
            <h3 class="text-xl font-black text-slate-900 italic uppercase tracking-tighter">Aucune réservation trouvée</h3>
            <p class="text-slate-400 font-medium max-w-xs mt-2">
                Il n'y a pas encore de matchs prévus pour cette date ou avec ces critères de recherche.
            </p>
            
            <div class="mt-8 flex gap-4">
                <button class="px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-emerald-100 transition-all">
                    Changer de date
                </button>
                <button class="px-6 py-3 border border-slate-100 text-slate-400 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-50 transition-all">
                    Réinitialiser
                </button>
            </div>
        </div>

    </main>
    @include('components.notif')
</body>
</html>