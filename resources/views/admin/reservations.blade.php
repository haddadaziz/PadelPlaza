<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Plaza | Admin Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; overflow-x: hidden; }
        .arena-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }

        /* DARK SELECT THEME ( Flatpickr)*/
        .dark-select {
            background: #0F172A;
            color: white;
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 1.5rem;
            padding: 1rem 2.5rem 1rem 3rem;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .dark-select:focus {
            border-color: rgba(16,185,129,0.5);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.08), 0 4px 20px rgba(0,0,0,0.2);
        }
        .dark-select:hover { border-color: rgba(16,185,129,0.35); }
        .dark-select option {
            background: #1e293b;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            padding: 8px;
        }
        .dark-select-wrap { position: relative; }
        .dark-select-wrap .icon-left {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #10B981;
            pointer-events: none;
            font-size: 13px;
            z-index: 1;
        }
        .dark-select-wrap .icon-chevron {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #10B981;
            pointer-events: none;
            font-size: 9px;
            z-index: 1;
        }

        /* ===== FLATPICKR CUSTOM THEME ===== */
        .flatpickr-calendar {
            background: #0F172A !important;
            border: 1px solid rgba(16,185,129,0.15) !important;
            border-radius: 1.75rem !important;
            box-shadow: 0 30px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(16,185,129,0.1) !important;
            font-family: 'Inter', sans-serif !important;
            padding: 1.25rem !important;
            width: 320px !important;
        }
        .flatpickr-calendar::before, .flatpickr-calendar::after { display: none !important; }

        .flatpickr-months {
            padding: 0 0 0.75rem 0 !important;
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            margin-bottom: 0.75rem !important;
            align-items: center !important;
        }
        .flatpickr-month { color: white !important; fill: white !important; height: 36px !important; }
        .flatpickr-current-month {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            padding: 0 !important;
        }
        .flatpickr-monthDropdown-months {
            background: #1e293b !important;
            color: white !important;
            border: 1px solid rgba(16,185,129,0.3) !important;
            border-radius: 0.75rem !important;
            padding: 0.4rem 0.75rem !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            outline: none !important;
            cursor: pointer !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }
        .flatpickr-monthDropdown-months:hover { border-color: #10B981 !important; }
        .flatpickr-monthDropdown-months option { background: #0F172A !important; }

        .numInputWrapper { flex-shrink: 0 !important; }
        .numInputWrapper input.cur-year {
            background: #1e293b !important;
            color: white !important;
            border: 1px solid rgba(16,185,129,0.3) !important;
            border-radius: 0.75rem !important;
            padding: 0.4rem 0.75rem !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            font-weight: 900 !important;
            width: 80px !important;
            outline: none !important;
        }
        .numInputWrapper input.cur-year:focus { border-color: #10B981 !important; }
        .numInputWrapper .arrowUp, .numInputWrapper .arrowDown { display: none !important; }

        .flatpickr-prev-month, .flatpickr-next-month {
            color: #10B981 !important; fill: #10B981 !important;
            padding: 6px 10px !important;
            border-radius: 0.75rem !important;
            transition: all 0.2s !important;
            height: 36px !important;
            display: flex !important;
            align-items: center !important;
        }
        .flatpickr-prev-month:hover, .flatpickr-next-month:hover {
            background: #1e293b !important; color: white !important; fill: white !important;
        }
        .flatpickr-prev-month svg, .flatpickr-next-month svg { width: 14px !important; height: 14px !important; }

        .flatpickr-weekdays { margin-bottom: 0.25rem !important; }
        .flatpickr-weekday {
            color: #10B981 !important; font-weight: 900 !important;
            font-size: 10px !important; text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
        }
        .flatpickr-day {
            color: #94a3b8 !important; border-radius: 0.75rem !important;
            font-weight: 700 !important; font-size: 12px !important;
            height: 36px !important; line-height: 36px !important;
            max-width: 36px !important; margin: 2px auto !important;
            border-color: transparent !important; transition: all 0.15s !important;
        }
        .flatpickr-day:hover { background: #1e293b !important; color: white !important; border-color: transparent !important; }
        .flatpickr-day.selected {
            background: #10B981 !important; border-color: #10B981 !important;
            color: white !important; font-weight: 900 !important;
            box-shadow: 0 4px 15px rgba(16,185,129,0.5) !important;
        }
        .flatpickr-day.today { border: 2px solid #10B981 !important; color: #10B981 !important; font-weight: 900 !important; }
        .flatpickr-day.today.selected { color: white !important; }
        .flatpickr-day.flatpickr-disabled, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
            color: #1e293b !important; background: transparent !important;
        }
    </style>
</head>
<body class="flex min-h-screen">

    @include('components.admin-sidebar')

    <main class="flex-1 lg:ml-64 p-6 lg:p-8 mt-16 lg:mt-0 flex flex-col h-screen lg:overflow-hidden">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 shrink-0 gap-6">
            <div>
                <h2 class="text-3xl lg:text-4xl font-[900] text-slate-900 tracking-tight uppercase leading-none">Planning <span class="text-emerald-500">Global</span></h2>
                <p class="text-slate-400 font-bold text-sm mt-2">Supervision et gestion des créneaux de l'Arena.</p>
            </div>
            
            <a href="{{ route('admin.reservations.create') }}" class="arena-gradient text-white px-8 py-4 rounded-[2rem] font-black shadow-2xl shadow-slate-300 transition-all hover:scale-105 active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest w-full sm:w-auto justify-center">
                <i class="fas fa-plus-circle"></i> Ajouter un Match
            </a>
        </div>

        <form action="{{ route('admin.reservations') }}" method="GET" class="bg-white p-6 lg:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm mb-8 flex flex-col md:flex-row md:items-end gap-4 shrink-0">
            
            <div class="w-full md:flex-1 flex flex-col gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Jour de Match</label>
                <div class="dark-select-wrap">
                    <i class="fas fa-calendar-day icon-left"></i>
                    <input type="hidden" name="date" id="date-hidden" value="{{ request('date', date('Y-m-d')) }}">
                    <div id="date-display" class="dark-select cursor-pointer select-none flex items-center">
                        &nbsp;
                    </div>
                    <i class="fas fa-chevron-down icon-chevron"></i>
                </div>
            </div>

            <div class="w-full md:flex-1 flex flex-col gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Sélection Terrain</label>
                <div class="dark-select-wrap">
                    <i class="fas fa-table-tennis-paddle-ball icon-left"></i>
                    <select name="court_id" class="dark-select">
                        <option value="">Tous les terrains</option>
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}" {{ request('court_id') == $court->id ? 'selected' : '' }}>{{ $court->name }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down icon-chevron"></i>
                </div>
            </div>

            <div class="w-full md:flex-1 flex flex-col gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Tranche Horaire</label>
                <div class="dark-select-wrap">
                    <i class="fas fa-clock icon-left"></i>
                    <select name="time_slot" class="dark-select">
                        <option value="">Toute la journée</option>
                        <option value="00-08" {{ request('time_slot') == '00-08' ? 'selected' : '' }}>00H à 08H</option>
                        <option value="08-16" {{ request('time_slot') == '08-16' ? 'selected' : '' }}>08H à 16H</option>
                        <option value="16-00" {{ request('time_slot') == '16-00' ? 'selected' : '' }}>16H à 00H</option>
                    </select>
                    <i class="fas fa-chevron-down icon-chevron"></i>
                </div>
            </div>

            <div class="w-full md:w-auto flex gap-2">
                <a href="{{ route('admin.reservations') }}" class="flex-1 md:w-14 h-14 bg-slate-50 border-2 border-slate-100 text-slate-400 rounded-[1.5rem] flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all" title="Réinitialiser">
                    <i class="fas fa-undo-alt text-sm"></i>
                </a>

                <button type="submit" class="flex-[2] md:px-10 h-14 bg-slate-900 text-white rounded-[1.5rem] font-black text-[11px] uppercase tracking-widest hover:bg-emerald-500 transition-all flex items-center justify-center gap-3">
                    <span>Filtrer</span>
                    <i class="fas fa-filter text-[10px]"></i>
                </button>
            </div>
        </form>

        <div class="flex-1 overflow-y-auto custom-scrollbar pr-4 space-y-4">
            @forelse($reservations as $reservation)
            <div class="group bg-white rounded-[3rem] p-6 lg:p-8 border border-slate-100 hover:border-emerald-200 transition-all duration-500 flex flex-col lg:flex-row items-center gap-6 lg:gap-8 shadow-sm hover:shadow-xl">
                
                <div class="w-full lg:w-36 flex lg:flex-col items-center justify-between lg:justify-center lg:border-r border-slate-50 lg:px-4 gap-1 py-4 lg:py-0 border-b lg:border-b-0">
                    <span class="text-2xl font-[900] text-slate-900 leading-none">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($reservation->start_time)->translatedFormat('d M Y') }}</span>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">{{ $reservation->court->name }}</span>
                </div>

                <div class="w-full lg:flex-1 flex items-center gap-5">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-[1.5rem] lg:rounded-[1.8rem] bg-slate-900 border-4 border-white shadow-xl flex items-center justify-center text-white font-[900] text-lg lg:text-xl overflow-hidden shrink-0">
                        @if($reservation->user->profile_image)
                            <img src="{{ str_contains($reservation->user->profile_image, 'http') ? $reservation->user->profile_image : asset('storage/' . $reservation->user->profile_image) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($reservation->user->name, 0, 2)) }}
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-lg lg:text-xl font-[900] text-slate-900 uppercase tracking-tight leading-none truncate">{{ $reservation->user->name }}</h4>
                        <p class="text-[10px] font-black text-slate-400 uppercase mt-1">SOLDE : {{ $reservation->user->coins_balance }} PPC</p>
                    </div>
                </div>

                <div class="w-full lg:flex-[0.8] border-t lg:border-t-0 pt-4 lg:pt-0">
                    <div class="flex flex-wrap gap-1 mb-2">
                        @forelse($reservation->equipments_info ?? [] as $item)
                            <span class="bg-slate-50 text-slate-500 text-[8px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter border border-slate-100">
                                {{ $item['qty'] }}x {{ $item['name'] }}
                            </span>
                        @empty
                            <span class="text-[10px] font-bold text-slate-200 uppercase">Sans équipement</span>
                        @endforelse
                    </div>
                    <p class="text-sm font-[900] text-slate-900">{{ $reservation->total_price }} <span class="text-[10px] text-slate-400">PC</span></p>
                </div>

                <div class="w-full lg:w-auto flex justify-end lg:items-center pt-4 lg:pt-0 border-t lg:border-t-0">
                    <button class="w-full lg:w-12 h-12 rounded-2xl bg-white border border-slate-100 text-red-400 hover:bg-red-500 hover:text-white transition-all shadow-sm flex items-center justify-center gap-2" title="Annuler la réservation">
                        <i class="fas fa-trash-alt text-sm"></i>
                        <span class="lg:hidden text-[10px] font-black uppercase tracking-widest">Supprimer</span>
                    </button>
                </div>

            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center py-20 opacity-40">
                <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mb-4 border border-dashed border-slate-300">
                    <i class="fas fa-calendar-times text-3xl text-slate-300"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Aucun match trouvé</p>
            </div>
            @endforelse
        </div>
    </main>

    @include('components.notif')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
    <script>
        const display = document.getElementById('date-display');
        const hiddenInput = document.getElementById('date-hidden');

        const cal = flatpickr(display, {
            locale: "fr",
            dateFormat: "Y-m-d",
            defaultDate: hiddenInput.value || new Date(),
            disableMobile: true,
            onReady: function(selectedDates) {
                if (selectedDates.length > 0) {
                    display.textContent = selectedDates[0].toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' }).toUpperCase();
                }
            },
            onChange: function(selectedDates, dateStr) {
                hiddenInput.value = dateStr;
                display.textContent = selectedDates[0].toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' }).toUpperCase();
            }
        });
        display.addEventListener('click', () => cal.open());
    </script>
</body>
</html>