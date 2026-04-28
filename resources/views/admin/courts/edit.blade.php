<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Modifier Terrain</title>
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
                <a href="/admin/courts" class="hover:text-emerald-500 transition-colors">Terrains</a>
                <span>/</span>
                <span class="text-slate-900">Modifier {{ $court->name }}</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Édition du Court</h2>
        </div>

        <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <form action="{{route('admin.courts.update', $court->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3">
                    
                    <div class="p-10 border-r border-slate-50 bg-slate-50/30">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Image du Terrain</label>
                        
                        <div class="relative group cursor-pointer">
                            <div class="w-full aspect-square rounded-[2rem] bg-slate-100 overflow-hidden relative border-4 border-white shadow-lg flex items-center justify-center">
                                @if($court->image)
                                    <img id="preview" src="{{ asset('storage/'.$court->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div id="placeholder" class="flex flex-col items-center text-slate-300">
                                        <i class="fas fa-image text-4xl mb-2"></i>
                                        <span class="text-[8px] font-black uppercase tracking-widest">Aucune image</span>
                                    </div>
                                    <img id="preview" src="" class="hidden w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                                
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                                    <i class="fas fa-camera text-2xl mb-2"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Changer</span>
                                </div>
                            </div>
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold mt-4 text-center">Format recommandé : JPG ou PNG (Max 2MB)</p>
                    </div>

                    <div class="md:col-span-2 p-10 space-y-8">
                        
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Désignation du Court</label>
                            <input type="text" name="name" value="{{ old('name', $court->name) }}" 
                                class="w-full px-6 py-4 bg-slate-50 border-2 @error('name') border-red-500 @else border-transparent @enderror rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm">
                            @error('name')
                                <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Tarif (Coins/h)</label>
                                <div class="relative">
                                    <input type="number" name="price_coins" value="{{ old('price_coins', $court->price_coins) }}" 
                                        class="w-full pl-6 pr-14 py-4 bg-slate-50 border-2 @error('price_coins') border-red-500 @else border-transparent @enderror rounded-2xl text-emerald-600 font-black focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm text-xl tracking-tight">
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 font-black text-xs uppercase">PC</span>
                                </div>
                                @error('price_coins')
                                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Statut Opérationnel</label>
                                <select name="is_active" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-emerald-500 transition-all outline-none shadow-sm appearance-none cursor-pointer">
                                    <option value="1" {{ old('is_active', $court->is_active) == '1' ? 'selected' : '' }}>● Actif / Ouvert</option>
                                    <option value="0" {{ old('is_active', $court->is_active) == '0' ? 'selected' : '' }}>● En Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 flex gap-4">
                             <button type="submit" class="flex-1 bg-slate-900 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-slate-200 uppercase tracking-widest text-sm flex items-center justify-center gap-3">
                                <i class="fas fa-check-circle"></i> Enregistrer les modifications
                            </button>
                            <a href="/admin/courts" class="px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl hover:bg-red-50 hover:text-red-500 transition-all uppercase text-[10px] flex items-center justify-center">
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
                const placeholder = document.getElementById('placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Enregistrement...';
        });
    </script>

</body>
</html>