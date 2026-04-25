<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Gestion des Terrains</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .sidebar-item-active { background-color: #F0FDF4; color: #10B981; border-right: 4px solid #10B981; }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')


    <main class="flex-1 lg:ml-64 p-6 lg:p-10 mt-16 lg:mt-0">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Configuration des Courts</h2>
                <p class="text-slate-400 font-medium">Gérez la disponibilité et les tarifs de vos terrains.</p>
            </div>
            <a href="{{ route('admin.courts.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-4 rounded-[1.5rem] font-black shadow-xl shadow-emerald-100 transition-all active:scale-95 flex items-center gap-3 uppercase text-sm tracking-tight">
                <i class="fas fa-plus"></i> Ajouter un terrain
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @foreach($courts as $court)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300">
                <div class="relative h-48 bg-slate-100 overflow-hidden">
                    
                    <!-- L'IMAGE REELLE OU LE BLOC VERT -->
                    @if($court->image)
                        <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-700">
                            <i class="fas fa-table-tennis-paddle-ball text-white/20 text-7xl rotate-12"></i>
                        </div>
                    @endif

                    
<div class="absolute top-5 right-5">
    <form action="{{ route('admin.courts.toggle-status', $court->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest {{ $court->is_active ? 'bg-white text-emerald-600' : 'bg-red-500 text-white' }} shadow-lg transition-transform active:scale-95">
            {{ $court->is_active ? '● Actif' : '● Maintenance' }}
        </button>
    </form>
</div>

                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $court->name }}</h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Court {{ $court->type ?? 'Indoor' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black text-emerald-500 leading-none">{{ $court->price_coins }}</p>
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Coins / Heure</p>
                        </div>
                    </div>

                    <div class="h-px bg-slate-50 w-full my-6"></div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('admin.courts.edit', $court->id) }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-600 font-black py-3 rounded-xl text-[11px] uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Modifier
                        </a>

                        <button type="button" onclick="openDeleteModal('{{ route('admin.courts.destroy', $court->id) }}')" class="w-12 h-12 flex items-center justify-center border-2 border-slate-50 rounded-xl text-slate-300 hover:text-red-500 hover:border-red-50 transition-all focus:outline-none">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </div>
            </div>
            @endforeach

            <a href="{{ route('admin.courts.create') }}" class="border-4 border-dashed border-slate-100 rounded-[2.5rem] flex flex-col items-center justify-center p-10 group hover:border-emerald-200 transition-all min-h-[400px]">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-all shadow-inner">
                    <i class="fas fa-plus text-2xl"></i>
                </div>
                <p class="text-slate-400 font-black uppercase tracking-widest text-[11px] group-hover:text-emerald-500 transition-colors">Nouveau Terrain</p>
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
            <p class="text-slate-400 text-xs font-bold text-center mb-8 px-4">Êtes-vous sûr de vouloir supprimer ce terrain ? L'action est irréversible.</p>
            
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
            
            form.action = url; // On donne la bonne URL de suppression au formulaire
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => { // Petit délai pour fluidifier l'animation (Fade In)
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => { // On attend la fin du Fade Out
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    </script>

</body>
</html>