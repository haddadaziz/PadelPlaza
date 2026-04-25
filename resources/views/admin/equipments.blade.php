<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Gestion Équipements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 lg:ml-64 p-6 lg:p-10 mt-16 lg:mt-0">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Inventaire Équipements</h2>
                <p class="text-slate-400 font-medium text-sm uppercase tracking-tight">Gérez les raquettes, balles et accessoires en location.</p>
            </div>
            <a href="{{ route('admin.equipments.create') }}" class="bg-slate-900 hover:bg-emerald-500 text-white px-8 py-4 rounded-[1.5rem] font-black shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest">
                <i class="fas fa-plus"></i> Ajouter un équipement
            </a>

        </div>

<div class="flex flex-wrap gap-3 mb-8">
    <!-- TOUS -->
    <a href="{{ route('admin.equipments') }}" 
       class="flex-1 sm:flex-none text-center px-5 py-3 transition-all rounded-xl text-[10px] font-black uppercase tracking-widest {{ !request('type') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-white text-slate-400 border border-slate-100 hover:text-emerald-500' }}">
        Tous
    </a>
    
    <!-- RAQUETTES -->
    <a href="{{ route('admin.equipments', ['type' => 'raquette']) }}" 
       class="flex-1 sm:flex-none text-center px-5 py-3 transition-all rounded-xl text-[10px] font-black uppercase tracking-widest {{ request('type') == 'raquette' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-white text-slate-400 border border-slate-100 hover:text-emerald-500' }}">
        Raquettes
    </a>
    
    <!-- BALLES -->
    <a href="{{ route('admin.equipments', ['type' => 'balles']) }}" 
       class="flex-1 sm:flex-none text-center px-5 py-3 transition-all rounded-xl text-[10px] font-black uppercase tracking-widest {{ request('type') == 'balles' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-white text-slate-400 border border-slate-100 hover:text-emerald-500' }}">
        Balles
    </a>

    <!-- ACCESSOIRES -->
    <a href="{{ route('admin.equipments', ['type' => 'accessoires']) }}" 
       class="flex-1 sm:flex-none text-center px-5 py-3 transition-all rounded-xl text-[10px] font-black uppercase tracking-widest {{ request('type') == 'accessoires' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-white text-slate-400 border border-slate-100 hover:text-emerald-500' }}">
        Access.
    </a>
</div>



        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- LA BOUCLE MAGIQUE -->
            @foreach($equipments as $equipment)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="relative h-44 bg-slate-50 flex items-center justify-center p-6">
                    <img src="{{ $equipment->image ? asset('storage/'.$equipment->image) : 'https://images.unsplash.com/photo-1610444583713-640a6b988f55?q=80&w=400' }}" 
                         class="h-full object-contain group-hover:scale-110 transition-transform duration-500" alt="{{ $equipment->name }}">
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-slate-900 text-[9px] font-black rounded-lg shadow-sm uppercase tracking-tight border border-slate-100">
                            Stock: {{ str_pad($equipment->stock, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-black text-slate-900 uppercase tracking-tight text-sm">{{ $equipment->name }}</h3>
                        <span class="text-emerald-500 font-black text-sm">{{ $equipment->price_coins }} PC</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-6">
                        <!-- PETITE LOGIQUE POUR LE STOCK ! -->
                        @if($equipment->stock > 0)
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Disponible</span>
                        @else
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-[9px] font-black text-red-600 uppercase tracking-widest">Rupture</span>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.equipments.edit', $equipment->id) }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-900 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-center">
                            Modifier
                        </a>
                        <!-- Bouton Supprimer qui ouvre la Modale -->
                        <button type="button" onclick="openDeleteModal('{{ route('admin.equipments.destroy', $equipment->id) }}')" class="w-11 h-11 bg-slate-50 hover:bg-red-50 text-slate-300 hover:text-red-500 rounded-xl transition-all border border-transparent hover:border-red-100">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </div>
            </div>
            @endforeach
            <!-- FIN DE LA BOUCLE -->

            <a href="{{ route('admin.equipments.create') }}" class="border-4 border-dashed border-slate-100 rounded-[2.5rem] flex flex-col items-center justify-center p-10 group hover:border-emerald-200 transition-all min-h-[400px]">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-all shadow-inner">
                    <i class="fas fa-plus text-2xl"></i>
                </div>
                <p class="text-slate-400 font-black uppercase tracking-widest text-[11px] group-hover:text-emerald-500 transition-colors">Nouvel Equipement</p>
            </a>

        </div>

    </main>
    @include('components.notif')

    <!-- LA MODALE DE SUPPRESSION (Cachée par défaut) -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-[2.5rem] p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300" id="deleteModalContent">
            
            <div class="w-16 h-16 bg-red-50 border-4 border-white shadow-lg text-red-500 rounded-[1.5rem] flex items-center justify-center text-2xl mx-auto mb-6 -mt-12">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            
            <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight text-center mb-2">Attention !</h3>
            <p class="text-slate-400 text-xs font-bold text-center mb-8 px-4">Êtes-vous sûr de vouloir retirer cet article du catalogue ? L'action est irréversible.</p>
            
            <div class="flex gap-4">
                <button onclick="closeDeleteModal()" class="flex-1 py-4 bg-slate-50 hover:bg-slate-100 text-slate-400 font-black rounded-2xl uppercase text-[10px] tracking-widest transition-all">
                    Annuler
                </button>
                <form id="confirmDeleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-red-500 hover:bg-red-600 text-white font-black rounded-2xl uppercase text-[10px] tracking-widest transition-all shadow-xl shadow-red-500/20">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- LE JAVASCRIPT POUR ANIMER LA MODALE -->
    <script>
        function openDeleteModal(url) {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            const form = document.getElementById('confirmDeleteForm');
            
            form.action = url;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    </script>

</body>
</html>