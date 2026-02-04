<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-[#FF3842] to-red-600 rounded-xl shadow-lg shadow-red-500/30 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
                Gerenciar Agendas
            </h2>
            

        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-6 md:py-10">

            @if(session('success'))
                <div class="mb-8 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-4 py-4 rounded-2xl flex items-center shadow-sm">
                    <div class="bg-emerald-100 dark:bg-emerald-800 p-2 rounded-lg mr-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="md:hidden mb-6">
                <a href="{{ route('admin.agendas.create') }}" class="flex w-full items-center justify-center px-6 py-4 text-sm font-bold text-white transition-all duration-200 bg-[#FF3842] font-pj rounded-2xl shadow-lg shadow-red-500/30 hover:bg-red-700 active:scale-95">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Criar Nova Agenda
                </a>
            </div>

            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card 1: Agendas -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Agendas Ativas</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['active_agendas'] }}</span>
                            <span class="text-sm font-bold text-slate-400">/ {{ $stats['agendas'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Projetos -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 dark:bg-purple-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Base de Projetos</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['projetos'] }}</span>
                        </div>
                        <div class="flex gap-3 mt-2 text-xs font-bold">
                            <span class="text-green-600">{{ $stats['projetos_agendados'] }} Agend.</span>
                            <span class="text-blue-600">{{ $stats['projetos_remanescentes'] }} Reman.</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Votos -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Votos Computados</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $stats['votos'] }}</span>
                                <span class="text-sm font-bold text-slate-400">Votos Totais</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded w-fit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span>{{ $stats['voters'] }} Usuários</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <!-- Filters & Search (Floating Style) -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
                
                <!-- Left: Search & Filter -->
                <form action="{{ route('admin.agendas.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título ou ano..." class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border-transparent focus:border-blue-500 rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-blue-500 dark:text-white transition-all placeholder:text-slate-400">
                    </div>

                    <select name="status" onchange="this.form.submit()" class="w-full md:w-48 bg-white dark:bg-slate-800 border-transparent focus:border-blue-500 rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-blue-500 dark:text-white py-3 px-4 text-slate-600 font-medium">
                        <option value="">Todos os Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Abertas</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Encerradas</option>
                    </select>

                    <button type="submit" class="hidden md:inline-flex px-6 py-3 bg-slate-800 dark:bg-slate-700 text-white font-bold rounded-xl text-sm hover:bg-slate-700 shadow-sm transition-colors">
                        Filtrar
                    </button>
                    
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.agendas.index') }}" class="flex items-center justify-center px-4 py-3 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-xl text-sm hover:bg-slate-50 shadow-sm transition-colors" title="Limpar Filtros">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </form>

                <!-- Right: Actions -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="{{ route('admin.agendas.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-[#FF3842] text-white font-bold rounded-xl text-sm hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        NOVA AGENDA
                    </a>
                </div>

            </div>

            <div class="hidden lg:block bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 text-[11px] uppercase tracking-widest text-slate-400 font-bold">
                            <th class="px-8 py-6 pl-10">Agenda</th>
                            <th class="px-6 py-6 text-center">Status</th>
                            <th class="px-6 py-6">Cronograma</th>
                            <th class="px-6 py-6 text-center">Projetos</th>
                            <th class="px-8 py-6 text-right pr-10">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($agendas as $agenda)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-all duration-200 {{ $agenda->is_main_schedule ? 'bg-amber-50/40 dark:bg-amber-900/10' : '' }}">
                            
                            <td class="px-8 py-6 pl-10">
                                <div class="flex items-start gap-5">
                                    <div class="w-14 h-14 rounded-2xl flex flex-col items-center justify-center font-bold shadow-md shrink-0 
                                        {{ $agenda->is_main_schedule 
                                            ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-orange-500/20' 
                                            : 'bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 text-slate-600 dark:text-slate-300' }}">
                                        <span class="text-[9px] uppercase opacity-70 mb-[-2px]">Ano</span>
                                        <span class="text-lg leading-none tracking-tight">{{ $agenda->year }}</span>
                                    </div>
                                    <div class="pt-1">
                                        <div class="flex items-center gap-3">
                                            <p class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-[#FF3842] transition-colors">
                                                {{ $agenda->title }}
                                            </p>
                                            @if($agenda->is_main_schedule)
                                                <span class="bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400 text-[10px] px-2 py-0.5 rounded-full border border-amber-200 dark:border-amber-700 uppercase font-bold tracking-wide flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    Principal
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 max-w-[280px] leading-relaxed">{{ $agenda->description ?? 'Sem descrição definida.' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-6 text-center">
                                @php $now = now(); $start = $agenda->start_date; $end = $agenda->deadline; @endphp
                                @if($start && $now < $start)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">Agendada</span>
                                @elseif($now <= $end)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span> Aberta
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">Encerrada</span>
                                @endif
                            </td>

                            <td class="px-6 py-6">
                                <div class="flex flex-col gap-2 border-l-2 border-slate-100 dark:border-slate-700 pl-4 py-1">
                                    <div class="flex items-center gap-2 group/date">
                                        <div class="p-1 rounded bg-blue-50 text-blue-500"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg></div>
                                        <div><p class="text-[9px] uppercase font-bold text-slate-400 leading-none">Início</p><p class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $agenda->start_date ? $agenda->start_date->format('d/m/Y H:i') : '--' }}</p></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="p-1 rounded bg-red-50 text-red-500"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                        <div><p class="text-[9px] uppercase font-bold text-[#FF3842] leading-none">Fim Votação</p><p class="text-xs font-bold text-[#FF3842]">{{ $agenda->deadline->format('d/m/Y H:i') }}</p></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="p-1 rounded bg-slate-100 text-slate-500"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                                        <div><p class="text-[9px] uppercase font-bold text-slate-400 leading-none">Resultados</p><p class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ $agenda->results_date ? $agenda->results_date->format('d/m') : '--' }}</p></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-6 text-center align-middle">
                                <div class="flex flex-col items-center">
                                    <span class="text-2xl font-black text-slate-700 dark:text-white leading-none">{{ $agenda->projects_count }}</span>
                                    <span class="text-[9px] uppercase font-bold text-slate-400 mb-2">Total</span>
                                    <div class="flex flex-col gap-1 w-full max-w-[120px]">
                                        <div class="flex justify-between items-center px-2 py-1 rounded bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800">
                                            <span class="text-[9px] font-bold text-green-600 dark:text-green-400">AGENDADOS</span>
                                            <span class="text-[10px] font-black text-green-700 dark:text-green-300">{{ $agenda->apresentados_count }}</span>
                                        </div>
                                        <div class="flex justify-between items-center px-2 py-1 rounded bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                                            <span class="text-[9px] font-bold text-blue-600 dark:text-blue-400">REMANESC.</span>
                                            <span class="text-[10px] font-black text-blue-700 dark:text-blue-300">{{ $agenda->remanescentes_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right pr-10">
                                    <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.agendas.dashboard', $agenda->id) }}" class="flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white hover:shadow-lg transition-all" title="Painel de Monitoramento">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="flex items-center justify-center w-9 h-9 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white hover:shadow-lg transition-all" title="Ver Lista de Projetos">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="flex items-center justify-center w-9 h-9 rounded-xl bg-orange-50 text-orange-600 hover:bg-orange-500 hover:text-white hover:shadow-lg transition-all" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('ATENÇÃO: Apagar esta agenda removerá todos os votos e projetos vinculados.\n\nTem certeza?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-[#FF3842] hover:text-white hover:shadow-lg transition-all" title="Excluir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <div class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4 text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium text-lg">Nenhuma agenda criada ainda.</p>
                                    <a href="{{ route('admin.agendas.create') }}" class="text-[#FF3842] font-bold text-sm mt-2 hover:underline">Criar primeira agenda</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="lg:hidden space-y-4">
                @forelse($agendas as $agenda)
                <div class="bg-white dark:bg-slate-800 rounded-[1.5rem] p-5 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden">
                    
                    @if($agenda->is_main_schedule)
                        <div class="absolute top-0 right-0 bg-gradient-to-l from-amber-400 to-orange-500 text-white text-[9px] font-bold px-3 py-1.5 rounded-bl-xl shadow-sm z-10 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            PRINCIPAL
                        </div>
                    @endif
                    
                    <div class="flex gap-4 mb-4 mt-1">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex flex-col items-center justify-center font-bold border border-slate-200 dark:border-slate-600 shrink-0">
                            <span class="text-[8px] uppercase opacity-60">Ano</span>
                            <span class="text-lg leading-none">{{ $agenda->year }}</span>
                        </div>
                        <div class="pr-2 flex-1">
                            <h3 class="font-bold text-slate-800 dark:text-white text-lg leading-tight mb-1">{{ $agenda->title }}</h3>
                            
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="text-[9px] font-bold bg-green-50 text-green-700 px-2 py-0.5 rounded border border-green-100">
                                    Agend: {{ $agenda->apresentados_count }}
                                </span>
                                <span class="text-[9px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-100">
                                    Reman: {{ $agenda->remanescentes_count }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-3 mb-4 border border-slate-100 dark:border-slate-800 grid grid-cols-3 gap-2 text-center">
                        <div>
                            <p class="text-[8px] uppercase font-bold text-slate-400">Início</p>
                            <p class="text-xs font-bold text-slate-700 dark:text-white">{{ $agenda->start_date ? $agenda->start_date->format('d/m') : '-' }}</p>
                        </div>
                        <div class="border-x border-slate-200 dark:border-slate-700">
                            <p class="text-[8px] uppercase font-bold text-[#FF3842]">Fim</p>
                            <p class="text-xs font-bold text-[#FF3842]">{{ $agenda->deadline->format('d/m') }}</p>
                        </div>
                        <div>
                            <p class="text-[8px] uppercase font-bold text-slate-400">Resultado</p>
                            <p class="text-xs font-bold text-slate-700 dark:text-white">{{ $agenda->results_date ? $agenda->results_date->format('d/m') : '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.agendas.dashboard', $agenda->id) }}" class="flex items-center justify-center py-2.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl text-xs font-bold border border-blue-100 dark:border-blue-900/30">
                            Painel
                        </a>
                        <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="flex items-center justify-center py-2.5 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-xl text-xs font-bold border border-purple-100 dark:border-purple-900/30">
                            Projetos
                        </a>
                        <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="flex items-center justify-center py-2.5 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-xl text-xs font-bold border border-orange-100 dark:border-orange-900/30">
                            Editar
                        </a>
                        <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Excluir?');" class="block w-full">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl text-xs font-bold border border-red-100 dark:border-red-900/30">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-slate-500">Nenhuma agenda.</div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $agendas->links() }}
            </div>

        </div>
    </div>
</x-app-layout>