<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Nouvel Équipement</title>
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
        <div class="mb-10">
            <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4 gap-2">
                <a href="/admin/equipments" class="hover:text-emerald-500 transition-colors">Équipements</a>
                <span>/</span>
                <span class="text-slate-900">Ajouter au catalogue</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">Nouvel Article</h2>
        </div>

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.equipments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3">
                    
                    <div class="p-10 border-r border-slate-50 bg-slate-50/30 flex flex-col items-center">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 self-start italic">Image Produit</label>
                        
                        <div class="relative group cursor-pointer w-full">
                            <div class="w-full aspect-square rounded-[2rem] bg-white overflow-hidden relative border-4 border-dashed border-slate-200 flex flex-col items-center justify-center transition-all group-hover:border-emerald-500 shadow-inner">
                                <img id="preview" src="" class="hidden w-full h-full object-contain p-4 transition-transform duration-500 hover:scale-105">
                                
                                <div id="placeholder" class="text-center p-6">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-50 transition-colors">
                                        <i class="fas fa-plus text-slate-200 text-2xl group-hover:text-emerald-500"></i>
                                    </div>
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] group-hover:text-emerald-500">Importer photo</p>
                                </div>
                            </div>
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold italic mt-6 text-center leading-relaxed">Préférez un fond blanc ou transparent pour un rendu optimal dans le store.</p>
                    </div>

                    <div class="md:col-span-2 p-10 space-y-8">
                        
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Désignation</label>
                            <input type="text" name="name" placeholder="Ex: Raquette Head Gravity Pro" 
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm italic placeholder:text-slate-300">
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Prix de location</label>
                                <div class="relative">
                                    <input type="number" name="price_coins" placeholder="0" 
                                        class="w-full pl-6 pr-14 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-emerald-600 font-black focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm italic text-xl tracking-tighter">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 font-black italic text-xs uppercase">PC</span>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Stock Initial</label>
                                <div class="relative">
                                    <input type="number" name="stock" placeholder="10" 
                                        class="w-full pl-6 pr-14 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-black focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm italic text-xl tracking-tighter">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 font-black italic text-xs"><i class="fas fa-boxes"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Catégorie d'article</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="raquette" class="sr-only peer" checked>
                                    <div class="py-3 text-center rounded-xl bg-slate-50 border-2 border-transparent text-slate-400 font-black text-[10px] uppercase tracking-widest italic peer-checked:bg-emerald-500 peer-checked:text-white transition-all">Raquettes</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="balles" class="sr-only peer">
                                    <div class="py-3 text-center rounded-xl bg-slate-50 border-2 border-transparent text-slate-400 font-black text-[10px] uppercase tracking-widest italic peer-checked:bg-emerald-500 peer-checked:text-white transition-all">Balles</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="accessoires" class="sr-only peer">
                                    <div class="py-3 text-center rounded-xl bg-slate-50 border-2 border-transparent text-slate-400 font-black text-[10px] uppercase tracking-widest italic peer-checked:bg-emerald-500 peer-checked:text-white transition-all">Autres</div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6 flex gap-4">
                            <button type="submit" class="flex-1 bg-slate-900 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-slate-200 uppercase italic tracking-widest text-sm flex items-center justify-center gap-3">
                                <i class="fas fa-plus-circle"></i> Ajouter au catalogue
                            </button>
                            <a href="/admin/equipments" class="px-8 py-4 text-slate-400 font-black rounded-2xl hover:text-slate-900 transition-all uppercase text-[10px] flex items-center justify-center italic">
                                Retour
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                const placeholder = document.getElementById('placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>
</html>