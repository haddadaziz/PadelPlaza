<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Padel Plaza | Mon Espace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 p-10 font-sans">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <!-- Message de bienvenue dynamique -->
        <h1 class="text-3xl font-black text-slate-900 mb-2">Salut, <span class="text-emerald-500">{{ Auth::user()->name }}</span> ! 🎾</h1>
        <p class="text-slate-500 font-medium mb-8">Bienvenue dans ton espace joueur.</p>

        <!-- Affichage des infos de compte -->
        <div class="flex gap-4">
            <div class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl font-bold">
                Solde : {{ Auth::user()->coins_balance }} Padel Coins
            </div>
            <div class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl font-bold">
                XP : {{ Auth::user()->xp_points }}
            </div>
        </div>

        <!-- Bouton Déconnexion (Pour tester la boucle) -->
        <form action="{{ route('logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm underline">Me déconnecter</button>
        </form>
    </div>

</body>
</html>
