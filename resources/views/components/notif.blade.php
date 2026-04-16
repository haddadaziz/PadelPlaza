@if(session('success') || $errors->any())
    <!-- La Notification -->
    <div id="notif-box" class="fixed top-8 left-1/2 -translate-x-1/2 z-50 px-8 py-4 rounded-2xl font-black text-sm text-white shadow-2xl transition-all duration-500 transform -translate-y-20 opacity-0 {{ session('success') ? 'bg-emerald-500' : 'bg-red-500' }}">
        {{ session('success') ?? $errors->first() }}
    </div>
    
    <!-- Le script qui anime -->
    <script>
        let notif = document.getElementById('notif-box');
        if (notif) {
            setTimeout(() => {
                notif.classList.remove('-translate-y-20', 'opacity-0');
                notif.classList.add('translate-y-0', 'opacity-100');
            }, 100);

            setTimeout(() => {
                notif.classList.remove('translate-y-0', 'opacity-100');
                notif.classList.add('-translate-y-20', 'opacity-0'); 
                setTimeout(() => notif.remove(), 500); 
            }, 4000);
        }
    </script>
@endif
