<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Modifier Équipement</title>
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
        <div class="mb-10">
            <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4 gap-2">
                <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Accueil</a>
                <span>/</span>
                <a href="/admin/equipments" class="hover:text-emerald-500 transition-colors">Équipements</a>
                <span>/</span>
                <span class="text-slate-900">Éditer l'article</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Modifier l'équipement</h2>
        </div>

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.equipments.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3">
                    
                    <div class="p-10 border-r border-slate-50 bg-slate-50/30">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Visuel Produit</label>
                        
                        <div class="relative group cursor-pointer">
                            <div class="w-full aspect-square rounded-[2rem] bg-white overflow-hidden relative border-4 border-white shadow-xl flex items-center justify-center p-4">
                                <img id="preview" src="{{ $equipment->image ? asset('storage/'.$equipment->image) : 'https://images.unsplash.com/photo-1610444583713-640a6b988f55?q=80&w=400' }}" 
                                     class="max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                                    <i class="fas fa-sync-alt text-2xl mb-2"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Remplacer</span>
                                </div>
                            </div>
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                        </div>
                    </div>

                    <div class="md:col-span-2 p-10 space-y-8">
                        
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nom de l'article</label>
                            <input type="text" name="name" value="{{ old('name', $equipment->name) }}" 
                                class="w-full px-6 py-4 bg-slate-50 border-2 @error('name') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm text-lg uppercase tracking-tight">
                            @error('name')
                                <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Prix de location</label>
                                <div class="relative">
                                    <input type="number" name="price_coins" value="{{ old('price_coins', $equipment->price_coins) }}" 
                                        class="w-full pl-6 pr-14 py-4 bg-slate-50 border-2 @error('price_coins') border-red-500 @else border-transparent @enderror rounded-2xl text-emerald-600 font-black focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm text-xl tracking-tight">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 font-black text-xs uppercase">PC</span>
                                </div>
                                @error('price_coins')
                                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Stock Total</label>
                                <div class="relative">
                                    <input type="number" name="stock" value="{{ old('stock', $equipment->stock) }}" 
                                        class="w-full pl-6 pr-14 py-4 bg-slate-50 border-2 @error('stock') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-black focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm text-xl tracking-tight">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 font-black text-xs uppercase text-center"><i class="fas fa-boxes"></i></span>
                                </div>
                                @error('stock')
                                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-blue-50 border border-blue-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-blue-900 uppercase leading-none">État du parc</h4>
                                <p class="text-[10px] text-blue-600 font-bold mt-1">Actuellement : 4 en location / 8 disponibles au club.</p>
                            </div>
                        </div>

                        <div class="pt-6 flex gap-4">
                            <button type="submit" class="flex-1 bg-slate-900 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-slate-200 uppercase tracking-widest text-sm flex items-center justify-center gap-3">
                                <i class="fas fa-save"></i> Mettre à jour l'inventaire
                            </button>
                            <a href="/admin/equipments" class="px-8 py-4 bg-slate-50 text-slate-400 font-black rounded-2xl hover:text-red-500 transition-all uppercase text-[10px] flex items-center justify-center">
                                Annuler
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
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Mise à jour...';
        });
    </script>

</body>
</html>