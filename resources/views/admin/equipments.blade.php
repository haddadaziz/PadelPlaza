<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Gestion Équipements</title>
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
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">Inventaire Équipements</h2>
                <p class="text-slate-400 font-medium italic text-sm uppercase tracking-tighter">Gérez les raquettes, balles et accessoires en location.</p>
            </div>
            <button class="bg-slate-900 hover:bg-emerald-500 text-white px-8 py-4 rounded-[1.5rem] font-black shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest italic">
                <i class="fas fa-plus"></i> Ajouter un équipement
            </button>
        </div>

        <div class="flex gap-4 mb-8">
            <span class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100 cursor-pointer">Tous</span>
            <span class="px-4 py-2 bg-white text-slate-400 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-emerald-500 transition-all cursor-pointer">Raquettes</span>
            <span class="px-4 py-2 bg-white text-slate-400 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-emerald-500 transition-all cursor-pointer">Accessoires</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="relative h-44 bg-slate-50 flex items-center justify-center p-6">
                    <img src="https://images.unsplash.com/photo-1610444583713-640a6b988f55?q=80&w=400&auto=format&fit=crop" 
                         class="h-full object-contain group-hover:scale-110 transition-transform duration-500" alt="Raquette">
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-slate-900 text-[9px] font-black rounded-lg shadow-sm uppercase tracking-tighter border border-slate-100 italic">
                            Stock: 08
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-black text-slate-900 italic uppercase tracking-tighter text-sm">Raquette Wilson Pro</h3>
                        <span class="text-emerald-500 font-black italic text-sm">50 PC</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-6">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest italic">Disponible</span>
                    </div>

                    <div class="flex gap-2">
<a href="{{ route('admin.equipments.edit', $equipment->id) }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-900 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-center italic">
    Modifier
</a>

                        <button class="w-11 h-11 bg-slate-50 hover:bg-red-50 text-slate-300 hover:text-red-500 rounded-xl transition-all border border-transparent hover:border-red-100">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden opacity-80 grayscale-[0.5]">
                <div class="relative h-44 bg-slate-100 flex items-center justify-center p-6 grayscale">
                     <i class="fas fa-box-open text-slate-300 text-5xl"></i>
                    <div class="absolute inset-0 bg-slate-900/5 flex items-center justify-center">
                        <span class="bg-red-500 text-white px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest rotate-12">Rupture</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-black text-slate-400 italic uppercase text-sm">Balles Wilson (Tube x3)</h3>
                    <div class="mt-4 flex gap-2">
                        <button class="flex-1 bg-slate-100 text-slate-400 py-3 rounded-xl text-[10px] font-black uppercase italic cursor-not-allowed">
                            Réapprovisionner
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-4 border-dashed border-slate-100 rounded-[2.5rem] flex flex-col items-center justify-center p-10 group hover:border-emerald-200 transition-all cursor-pointer">
                <div class="w-14 h-14 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <p class="text-slate-300 font-black uppercase tracking-widest text-[10px] group-hover:text-emerald-500">Nouvel Article</p>
            </div>

        </div>
    </main>

</body>
</html>