<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-lg text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <div class="w-1 h-5 bg-gradient-to-b from-[#FF3842] to-red-600 rounded-full animate-pulse"></div>
            Sala de Votação
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#0f172a] pb-32 transition-colors duration-500 font-sans">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-6 md:py-8">

            <!-- Agenda Header -->
            <div class="mb-8 animate-fade-in-up">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Agenda em Votação</span>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {{ $agenda->title }}
                        </h1>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="hidden md:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 uppercase tracking-wide">
                            Ano {{ $agenda->year }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-800 uppercase tracking-wide">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Fim: {{ \Carbon\Carbon::parse($agenda->deadline)->format('d/m') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- FILTERS BAR -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 mb-8 animate-fade-in-up delay-100">
                <form method="GET" action="{{ route('agenda.vote', $agenda->id) }}">
                    <!-- Flexible Grid: 1 col mobile, 3 tablet, 6 desktop -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 items-center">
                        
                        <!-- 1. Search (Expanded on Mobile/Tablet) -->
                        <div class="col-span-1 md:col-span-3 lg:col-span-1 relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-[#FF3842] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] placeholder-slate-400 transition-all shadow-sm" 
                                   placeholder="Buscar...">
                        </div>

                        <!-- 2. Interesse -->
                        <div class="col-span-1">
                            <select name="interesse" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm appearance-none">
                                <option value="">Interesse</option>
                                @foreach($filters['interesses'] as $opt)
                                    <option value="{{ $opt }}" {{ request('interesse') == $opt ? 'selected' : '' }}>{{ Str::limit($opt, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 3. Tema -->
                        <div class="col-span-1">
                            <select name="tema" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm appearance-none">
                                <option value="">Tema</option>
                                @foreach($filters['temas'] as $tema)
                                    <option value="{{ $tema }}" {{ request('tema') == $tema ? 'selected' : '' }}>{{ Str::limit($tema, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 4. Subtema -->
                        <div class="col-span-1">
                            <select name="subtema" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm appearance-none">
                                <option value="">Subtema</option>
                                @foreach($filters['subtemas'] as $sub)
                                    <option value="{{ $sub }}" {{ request('subtema') == $sub ? 'selected' : '' }}>{{ Str::limit($sub, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 5. Origem -->
                        <div class="col-span-1">
                            <select name="type" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm appearance-none">
                                <option value="">Origem (Todas)</option>
                                <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Agendados</option>
                                <option value="remanescente" {{ request('type') == 'remanescente' ? 'selected' : '' }}>Remanescentes</option>
                            </select>
                        </div>

                        <!-- 6. Status -->
                        <div class="col-span-1">
                            <select name="status" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-1 focus:ring-[#FF3842] focus:border-[#FF3842] cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm appearance-none">
                                <option value="">Status</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                                <option value="votado" {{ request('status') == 'votado' ? 'selected' : '' }}>Votados</option>
                            </select>
                        </div>

                    </div>
                    
                    @if(request()->anyFilled(['search', 'interesse', 'tema', 'subtema', 'type', 'status']))
                        <div class="mt-3 flex justify-end animate-fade-in border-t border-slate-100 pt-3 dark:border-slate-700">
                            <a href="{{ route('agenda.vote', $agenda->id) }}" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-[10px] font-bold uppercase tracking-wide transition-colors flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Limpar Filtros
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- PROJECTS LIST -->
            <div class="space-y-6 animate-fade-in-up delay-200">
                @forelse($projects as $project)
                @php
                    $vote = $project->votes->first();
                    $hasPrio = $vote && $vote->prioridade;
                    $hasPos = $vote && $vote->posicao;
                    
                    if ($hasPrio && $hasPos) {
                        $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                        $statusText = 'VOTADO';
                        $cardBorder = 'border-emerald-500 shadow-md shadow-emerald-500/10';
                    } elseif ($hasPrio || $hasPos) {
                        $statusClass = 'bg-amber-50 text-amber-600 border-amber-100 animate-pulse';
                        $statusText = 'EM ANDAMENTO';
                        $cardBorder = 'border-amber-400 shadow-md shadow-amber-500/10';
                    } else {
                        $statusClass = 'bg-slate-100 text-slate-500 border-slate-200';
                        $statusText = 'PENDENTE';
                        $cardBorder = 'border-slate-100 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600';
                    }
                @endphp

                <!-- Data Storage -->
                <textarea id="data-project-{{ $project->id }}" class="hidden">{!! json_encode($project, JSON_HEX_APOS | JSON_HEX_QUOT) !!}</textarea>

                <div id="card-{{ $project->id }}" class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border {{ $cardBorder }} transition-all duration-300 hover:shadow-lg overflow-hidden group">
                    
                    <div class="p-5 md:p-6 border-b border-slate-50 dark:border-slate-700/50">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <!-- Chips -->
                                <div class="flex flex-wrap items-center gap-2 mb-3 opacity-90">
                                    <span class="bg-slate-800 text-white text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-wider">
                                        {{ $project->codigo }}
                                    </span>
                                    
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border {{ $project->type == 'remanescente' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-green-50 text-green-600 border-green-100' }}">
                                        {{ ucfirst($project->type) }}
                                    </span>

                                    <span id="status-badge-{{ $project->id }}" class="text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border {{ $statusClass }} transition-all">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-[#FF3842] transition-colors">
                                    {{ $project->ementa }}
                                </h3>
                                
                                <div class="flex flex-wrap gap-4 text-xs text-slate-500 dark:text-slate-400 mt-2">
                                    <div class="flex items-center gap-1.5" title="Autor">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="font-semibold">{{ $project->autor }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5" title="Tema">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        <span>{{ $project->tema }}</span>
                                        @if($project->subtema) <span class="text-slate-300">/</span> <span>{{ $project->subtema }}</span> @endif
                                    </div>
                                </div>
                            </div>

                            <button onclick="openDetailsModal({{ $project->id }})" class="flex-shrink-0 bg-slate-50 dark:bg-slate-700/50 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-600 hover:border-[#FF3842] dark:hover:border-[#FF3842] text-slate-500 dark:text-slate-300 hover:text-[#FF3842] font-bold py-2 px-3 rounded-xl text-[10px] uppercase tracking-wide transition-all shadow-sm group/btn">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Ver Detalhes
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="px-5 py-5 bg-[#F8F9FA]/60 dark:bg-slate-900/40">
                        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">
                            
                            <!-- Prioridade -->
                            <div class="w-full lg:w-auto flex-1">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center">
                                        <span class="w-1.5 h-1.5 bg-[#FF3842] rounded-full mr-2"></span>
                                        1. Prioridade
                                    </h4>
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach(['Baixa', 'Média', 'Alta', 'Agenda'] as $prio)
                                        <button type="button" onclick="setPriority({{ $project->id }}, '{{ $prio }}')" id="btn-prio-{{ $project->id }}-{{ $prio }}"
                                                class="px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border
                                                {{ ($vote && $vote->prioridade == $prio) 
                                                    ? 'bg-slate-800 text-white border-slate-800 ring-2 ring-slate-200 dark:bg-white dark:text-slate-900 shadow-md transform scale-105' 
                                                    : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-slate-300 hover:bg-slate-50' }}">
                                            {{ $prio }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Posição (Sem Abstenção) -->
                            <div class="w-full lg:w-auto flex-1">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center">
                                        <span class="w-1.5 h-1.5 bg-[#FF3842] rounded-full mr-2"></span>
                                        2. Posição
                                    </h4>
                                    <!-- Explicit Clear Button placed here for visibility -->
                                    <button onclick="deleteVote({{ $project->id }})" class="text-[9px] font-bold text-slate-400 hover:text-red-500 flex items-center gap-1 transition-colors group/clr">
                                        <span class="hidden group-hover/clr:inline">Limpar Voto</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <!-- ONLY TWO BUTTONS HERE - NO ABSTENTION -->
                                    <button type="button" onclick="setPosition({{ $project->id }}, 'Convergente')" id="btn-pos-{{ $project->id }}-Convergente"
                                            class="px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border
                                            {{ ($vote && $vote->posicao == 'Convergente') 
                                                ? 'bg-emerald-500 text-white border-emerald-500 ring-2 ring-emerald-100 shadow-md transform scale-105' 
                                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-emerald-300 hover:text-emerald-500' }}">
                                        Convergente
                                    </button>
                                    <button type="button" onclick="setPosition({{ $project->id }}, 'Divergente')" id="btn-pos-{{ $project->id }}-Divergente"
                                            class="px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border
                                            {{ ($vote && $vote->posicao == 'Divergente') 
                                                ? 'bg-red-500 text-white border-red-500 ring-2 ring-red-100 shadow-md transform scale-105' 
                                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-red-300 hover:text-red-500' }}">
                                        Divergente
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- Ressalva Area -->
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                            <div class="relative">
                                <input type="text" id="ressalva-{{ $project->id }}" 
                                       value="{{ $vote->ressalva ?? '' }}"
                                       class="w-full pl-3 pr-10 py-2 bg-transparent border-0 border-b border-slate-300 dark:border-slate-600 focus:border-[#FF3842] focus:ring-0 text-sm placeholder-slate-400 transition-colors" 
                                       placeholder="Adicionar nota ou ressalva (opcional)..." 
                                       onblur="saveVote({{ $project->id }})">
                                <svg class="w-4 h-4 text-slate-400 absolute right-2 bottom-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="text-center py-24 bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm animate-fade-in-up">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 dark:bg-slate-900 text-slate-300 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Nada por aqui!</h3>
                    <p class="text-slate-500 font-medium text-sm">Nenhum projeto encontrado com os filtros atuais.</p>
                    <a href="{{ route('agenda.vote', $agenda->id) }}" class="inline-block mt-4 text-[#FF3842] font-bold text-xs hover:underline uppercase tracking-wide">Limpar Filtros</a>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- FLOATING PROGRESS BAR -->
    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40 w-[92%] max-w-[600px] transition-all duration-300 animate-slide-up" id="floating-bar">
        <!-- ... (Keep existing progress bar) ... -->
        <div class="bg-white/90 dark:bg-slate-900/90 text-slate-800 dark:text-white rounded-full shadow-2xl shadow-slate-400/20 dark:shadow-black/50 p-2 pl-6 pr-2 flex items-center justify-between border border-slate-200 dark:border-slate-700 backdrop-blur-xl">
            <div class="flex items-center gap-5 flex-1 mr-4">
                <div class="flex flex-col min-w-[50px]">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Progresso</span>
                    <span class="text-lg font-black text-slate-800 dark:text-white leading-none tracking-tight" id="progress-percent-text">{{ $progressData['percent'] }}%</span>
                </div>
                <div class="flex-1 hidden sm:block">
                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar-fill" class="h-2 rounded-full transition-all duration-1000 bg-gradient-to-r from-[#FF3842] to-orange-500 shadow-sm" style="width: {{ $progressData['percent'] }}%"></div>
                    </div>
                </div>
                <div id="global-save-status" class="hidden md:flex items-center text-emerald-500 text-[10px] font-bold uppercase tracking-widest opacity-0 transition-opacity duration-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Salvo
                </div>
            </div>
            
            <button onclick="attemptConclusion({{ $agenda->id }})" class="px-5 py-2.5 rounded-full bg-[#FF3842] hover:bg-red-600 text-white font-bold transition shadow-lg shadow-red-500/30 text-[10px] uppercase tracking-wide flex items-center gap-2 transform active:scale-95">
                Concluir
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </div>
    </div>

    <!-- DETAILS MODAL (Include modal code - reuse existing) -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDetailsModal()"></div>
        <div class="absolute inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2rem] bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-2xl border border-slate-100 dark:border-slate-700 animate-scale-in">
                    <!-- Modal Header -->
                    <div class="bg-[#F8F9FA] dark:bg-slate-900/50 px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-start">
                        <div>
                            <span id="md_codigo" class="bg-slate-800 text-white text-[9px] font-black px-2 py-0.5 rounded mb-1.5 inline-block tracking-wider uppercase"></span>
                            <h3 id="md_ementa" class="text-lg font-bold text-slate-800 dark:text-white leading-tight"></h3>
                        </div>
                        <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-[#FF3842] transition p-1 bg-white dark:bg-slate-800 rounded-full shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700 pb-1">Autoria</h4>
                                <div><span class="text-slate-400 block text-[10px] uppercase">Autor</span> <span id="md_autor" class="font-bold text-slate-800 dark:text-white text-sm"></span></div>
                                <div><span class="text-slate-400 block text-[10px] uppercase">Partido/UF</span> <span id="md_partido_uf" class="font-bold text-slate-800 dark:text-white text-sm"></span></div>
                            </div>
                            <div class="space-y-4">
                                <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700 pb-1">Situação</h4>
                                <div><span class="text-slate-400 block text-[10px] uppercase">Local</span> <span id="md_local" class="font-bold text-slate-800 dark:text-white text-sm"></span></div>
                                <div><span class="text-slate-400 block text-[10px] uppercase">Status</span> <span id="md_situacao" class="font-bold text-slate-800 dark:text-white text-sm"></span></div>
                            </div>
                        </div>
                        
                        <div class="bg-indigo-50 dark:bg-indigo-900/10 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-900/30 mb-6">
                            <h4 class="text-[9px] font-bold text-indigo-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Foco do Projeto
                            </h4>
                            <div id="md_foco" class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed text-justify"></div>
                        </div>
                        
                        <div class="text-center">
                            <a id="md_link" href="#" target="_blank" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition uppercase tracking-wide">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Abrir PDF Original
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        let votesState = {};

        // --- CORE VOTING FUNCTIONS ---

        function setPriority(id, val) {
            initVoteState(id);
            votesState[id].prioridade = val;
            updateUI(id);
            saveVote(id);
        }

        function setPosition(id, val) {
            initVoteState(id);
            votesState[id].posicao = val;
            updateUI(id);
            saveVote(id);
        }

        function deleteVote(id) {
            Swal.fire({
                title: 'Deseja Limpar o Voto?',
                text: "O voto será apagado e a prioridade/posição resetadas.",
                icon: 'warning',
                iconColor: '#FF3842',
                showCancelButton: true,
                confirmButtonColor: '#FF3842',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Sim, limpar',
                cancelButtonText: 'Cancelar',
                width: 320,
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e293b',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call Destroy Route Logic
                    fetch("{{ route('vote.destroy') }}", {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ project_id: id })
                    })
                    .then(res => res.json())
                    .then(data => {
                         if(data.success) {
                            // 1. Reset State
                            votesState[id] = { prioridade: null, posicao: null };
                            document.getElementById(`ressalva-${id}`).value = '';

                            // 2. Reset UI Buttons (Remove active classes)
                            ['Baixa', 'Média', 'Alta', 'Agenda'].forEach(p => {
                                const btn = document.getElementById(`btn-prio-${id}-${p}`);
                                if(btn) btn.className = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-slate-300 hover:bg-slate-50";
                            });

                            const btnConv = document.getElementById(`btn-pos-${id}-Convergente`);
                            const btnDiv = document.getElementById(`btn-pos-${id}-Divergente`);
                            const baseClass = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600";
                            
                            btnConv.className = baseClass + " hover:border-emerald-300 hover:text-emerald-500";
                            btnDiv.className = baseClass + " hover:border-red-300 hover:text-red-500";

                            // 3. Reset Badge & Card
                            const badge = document.getElementById(`status-badge-${id}`);
                            badge.innerText = "PENDENTE";
                            badge.className = "text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border transition-all bg-slate-100 text-slate-500 border-slate-200";

                            const card = document.getElementById(`card-${id}`);
                            card.className = "bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300 hover:shadow-lg overflow-hidden group";

                            // 4. Update Progress
                            updateProgress(data.newPercent);
                            showSaveIndicator();
                        }
                    });
                }
            })
        }

        function saveVote(id) {
            initVoteState(id);
            const ressalva = document.getElementById(`ressalva-${id}`).value;

            const payload = { 
                project_id: id, 
                prioridade: votesState[id].prioridade ?? null, 
                posicao: votesState[id].posicao ?? null,        
                ressalva: ressalva 
            };

            fetch("{{ route('vote.store') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                   updateProgress(data.newPercent);
                   if(payload.prioridade || payload.posicao) {
                       showSaveIndicator();
                       // Update Badge based on server response status
                       const badge = document.getElementById(`status-badge-${id}`);
                       badge.className = "text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border transition-all";
                       
                       const card = document.getElementById(`card-${id}`);
                       // Reset basic card classes but keep base ones
                       let cardBase = "bg-white dark:bg-slate-800 rounded-3xl shadow-sm transition-all duration-300 hover:shadow-lg overflow-hidden group border ";

                       if(data.status === 'complete') {
                            badge.innerText = "VOTADO";
                            badge.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                            card.className = cardBase + "border-emerald-500 shadow-md shadow-emerald-500/10";
                       } else {
                            badge.innerText = "EM ANDAMENTO";
                            badge.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-100', 'animate-pulse');
                            card.className = cardBase + "border-amber-400 shadow-md shadow-amber-500/10";
                       }
                   }
                }
            });
        }

        // --- UI HELPERS ---

        function initVoteState(id) {
            if(!votesState[id]) votesState[id] = { prioridade: null, posicao: null };
        }

        function updateUI(id) {
            const state = votesState[id];

            // 1. Update Priority Buttons
            ['Baixa', 'Média', 'Alta', 'Agenda'].forEach(p => {
                const btn = document.getElementById(`btn-prio-${id}-${p}`);
                if(btn) {
                    if(state.prioridade == p) {
                         btn.className = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-md transform scale-105 border bg-slate-800 text-white border-slate-800 ring-2 ring-slate-200 dark:bg-white dark:text-slate-900";
                    } else {
                         btn.className = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-slate-300 hover:bg-slate-50";
                    }
                }
            });

            // 2. Update Position Buttons
            const btnConv = document.getElementById(`btn-pos-${id}-Convergente`);
            const btnDiv = document.getElementById(`btn-pos-${id}-Divergente`);
            const baseClass = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-sm border bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600";
            
            // Reset
            btnConv.className = baseClass + " hover:border-emerald-300 hover:text-emerald-500";
            btnDiv.className = baseClass + " hover:border-red-300 hover:text-red-500";
            
            if(state.posicao === 'Convergente') {
                btnConv.className = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-md transform scale-105 border bg-emerald-500 text-white border-emerald-500 ring-2 ring-emerald-100";
            } else if(state.posicao === 'Divergente') {
                btnDiv.className = "px-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wide transition-all shadow-md transform scale-105 border bg-red-500 text-white border-red-500 ring-2 ring-red-100";
            }
        }

        function updateProgress(percent) {
            document.getElementById('progress-percent-text').innerText = percent + '%';
            document.getElementById('progress-bar-fill').style.width = percent + '%';
        }

        function showSaveIndicator() {
            const el = document.getElementById('global-save-status');
            el.classList.remove('opacity-0');
            setTimeout(() => el.classList.add('opacity-0'), 2000);
        }

        // --- MODAL & INIT ---
        function openDetailsModal(id) {
            const jsonText = document.getElementById('data-project-' + id).value;
            const p = JSON.parse(jsonText);
            const v = (val) => val ? val : '-';
            
            document.getElementById('md_codigo').innerText = v(p.codigo);
            document.getElementById('md_ementa').innerText = v(p.ementa);
            document.getElementById('md_autor').innerText = v(p.autor);
            document.getElementById('md_partido_uf').innerText = v(p.partido) + ' / ' + v(p.uf);
            document.getElementById('md_local').innerText = v(p.localizacao_atual);
            document.getElementById('md_situacao').innerText = v(p.situacao);
            document.getElementById('md_foco').innerText = v(p.foco);
            
            const link = document.getElementById('md_link');
            if(p.link_pdf) { link.href = p.link_pdf; link.classList.remove('hidden'); } 
            else { link.classList.add('hidden'); }
            
            document.getElementById('detailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function attemptConclusion(agendaId) {
            Swal.fire({
                title: 'Concluir Votação?',
                text: "Você será redirecionado ao painel principal.",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#FF3842',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Sim, concluir',
                cancelButtonText: 'Continuar votando',
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e293b',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
             // Init votes state
             @foreach($projects as $p)
                @if($p->votes->first())
                    votesState[{{ $p->id }}] = { 
                        prioridade: "{{ $p->votes->first()->prioridade }}", 
                        posicao: "{{ $p->votes->first()->posicao }}" 
                    };
                @endif
            @endforeach
        });
    </script>
    
    <style>
        @keyframes fade-in-up { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
        
        @keyframes scale-in { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }
        .animate-scale-in { animation: scale-in 0.3s ease-out forwards; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</x-app-layout>