<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-[#FF3842] transition-colors" title="Voltar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div class="h-6 w-px bg-slate-300 mx-2"></div>
                <span class="truncate max-w-[300px]">{{ $agenda->title }}</span>
            </h2>
            
            <div class="flex items-center gap-3">
                <span class="hidden md:inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    Ano {{ $agenda->year }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Fim: {{ \Carbon\Carbon::parse($agenda->deadline)->format('d/m') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-32 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-8">

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 mb-8 sticky top-4 z-30">
                <form method="GET" action="{{ route('agenda.vote', $agenda->id) }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                        
                        <div class="lg:col-span-3 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842] placeholder-slate-400" 
                                   placeholder="Pesquisar código/ementa...">
                        </div>

                        <div class="lg:col-span-2">
                            <select name="interesse" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 focus:ring-[#FF3842]">
                                <option value="">Interesse (Todos)</option>
                                @foreach($filters['interesses'] as $opt)
                                    <option value="{{ $opt }}" {{ request('interesse') == $opt ? 'selected' : '' }}>{{ Str::limit($opt, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-2">
                            <select name="tema" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 focus:ring-[#FF3842]">
                                <option value="">Tema (Todos)</option>
                                @foreach($filters['temas'] as $tema)
                                    <option value="{{ $tema }}" {{ request('tema') == $tema ? 'selected' : '' }}>{{ Str::limit($tema, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-2">
                            <select name="subtema" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 focus:ring-[#FF3842]">
                                <option value="">Subtema (Todos)</option>
                                @foreach($filters['subtemas'] as $sub)
                                    <option value="{{ $sub }}" {{ request('subtema') == $sub ? 'selected' : '' }}>{{ Str::limit($sub, 20) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-2">
                            <select name="type" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 focus:ring-[#FF3842]">
                                <option value="">Origem (Todas)</option>
                                <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Agendados</option>
                                <option value="remanescente" {{ request('type') == 'remanescente' ? 'selected' : '' }}>Remanescentes</option>
                            </select>
                        </div>

                        <div class="lg:col-span-1">
                            <select name="status" onchange="this.form.submit()" class="w-full py-2 px-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 focus:ring-[#FF3842]">
                                <option value="">Status</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                                <option value="votado" {{ request('status') == 'votado' ? 'selected' : '' }}>Votados</option>
                            </select>
                        </div>

                    </div>
                    
                    @if(request()->anyFilled(['search', 'interesse', 'tema', 'subtema', 'type', 'status']))
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('agenda.vote', $agenda->id) }}" class="text-[10px] font-bold text-red-500 hover:text-red-700 hover:underline flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Limpar Todos os Filtros
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="space-y-8">
                @forelse($projects as $project)
                @php
                    $vote = $project->votes->first();
                    $hasPrio = $vote && $vote->prioridade;
                    $hasPos = $vote && $vote->posicao;
                    
                    if ($hasPrio && $hasPos) {
                        $statusClass = 'bg-green-100 text-green-800 border-green-200';
                        $statusText = 'VOTADO';
                        $cardBorder = 'border-green-500';
                    } elseif ($hasPrio || $hasPos) {
                        $statusClass = 'bg-amber-100 text-amber-800 border-amber-200 animate-pulse';
                        $statusText = 'EM ANDAMENTO';
                        $cardBorder = 'border-amber-500';
                    } else {
                        $statusClass = 'bg-slate-100 text-slate-500 border-slate-200';
                        $statusText = 'PENDENTE';
                        $cardBorder = 'border-slate-200 dark:border-slate-700';
                    }
                @endphp

                <textarea id="data-project-{{ $project->id }}" class="hidden">{!! json_encode($project, JSON_HEX_APOS | JSON_HEX_QUOT) !!}</textarea>

                <div id="card-{{ $project->id }}" class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border {{ $cardBorder }} p-0 transition-all duration-300 hover:shadow-lg overflow-hidden group">
                    
                    <div class="p-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="bg-slate-800 text-white text-[10px] font-black px-2 py-1 rounded uppercase tracking-wider">
                                        {{ $project->codigo }}
                                    </span>
                                    
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider border {{ $project->type == 'remanescente' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-green-50 text-green-600 border-green-100' }}">
                                        {{ ucfirst($project->type) }}
                                    </span>
                                    @if($project->interesse)
                                        <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider border bg-purple-50 text-purple-600 border-purple-100">
                                            {{ $project->interesse }}
                                        </span>
                                    @endif

                                    <span id="status-badge-{{ $project->id }}" class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider border {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-[#FF3842] transition-colors">
                                    {{ $project->ementa }}
                                </h3>
                                
                                <div class="flex flex-wrap gap-4 text-xs text-slate-500 dark:text-slate-400 mt-3">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="font-semibold">{{ $project->autor }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M10 13a4 4 0 014 4m4 0v.01M6 21v.01"></path></svg>
                                        <span>{{ $project->tema }}</span>
                                        @if($project->subtema) <span class="text-slate-300">/</span> <span>{{ $project->subtema }}</span> @endif
                                    </div>
                                </div>
                            </div>

                            <button onclick="openDetailsModal({{ $project->id }})" class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-500 dark:text-slate-300 hover:text-[#FF3842] hover:border-[#FF3842] font-bold py-2 px-4 rounded-xl text-xs transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Detalhes
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 bg-slate-50/50 dark:bg-slate-900/30">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-6">
                            
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase mb-3 flex items-center tracking-widest">
                                    <span class="bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 w-5 h-5 rounded-full flex items-center justify-center mr-2">1</span>
                                    Prioridade
                                    <span class="text-red-500 ml-1 text-lg leading-none">*</span>
                                </h4>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach(['Baixa', 'Média', 'Alta', 'Agenda'] as $prio)
                                        <button type="button" onclick="setPriority({{ $project->id }}, '{{ $prio }}')" id="btn-prio-{{ $project->id }}-{{ $prio }}"
                                                class="px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95
                                                {{ ($vote && $vote->prioridade == $prio) 
                                                    ? 'bg-slate-800 text-white border-slate-800 ring-2 ring-slate-200 dark:bg-white dark:text-slate-900' 
                                                    : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                                            {{ $prio }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase mb-3 flex items-center tracking-widest">
                                    <span class="bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 w-5 h-5 rounded-full flex items-center justify-center mr-2">2</span>
                                    Posição
                                    <span class="text-red-500 ml-1 text-lg leading-none">*</span>
                                </h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" onclick="setPosition({{ $project->id }}, 'Convergente')" id="btn-pos-{{ $project->id }}-Convergente"
                                            class="px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95
                                            {{ ($vote && $vote->posicao == 'Convergente') 
                                                ? 'bg-green-600 text-white border-green-600 ring-2 ring-green-100' 
                                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-green-400 hover:text-green-600' }}">
                                        Convergente
                                    </button>
                                    <button type="button" onclick="setPosition({{ $project->id }}, 'Divergente')" id="btn-pos-{{ $project->id }}-Divergente"
                                            class="px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95
                                            {{ ($vote && $vote->posicao == 'Divergente') 
                                                ? 'bg-red-600 text-white border-red-600 ring-2 ring-red-100' 
                                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:border-red-400 hover:text-red-600' }}">
                                        Divergente
                                    </button>
                                    <button type="button" onclick="setPosition({{ $project->id }}, 'Abstenção')" id="btn-pos-{{ $project->id }}-Abstenção"
                                            class="px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95
                                            {{ ($vote && $vote->posicao == 'Abstenção') 
                                                ? 'bg-slate-500 text-white border-slate-500 ring-2 ring-slate-200' 
                                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                                        Abstenção
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="absolute -top-2 left-3 bg-slate-50 dark:bg-slate-900 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                Comentários / Ressalvas (Opcional)
                            </label>
                            <div class="absolute top-2 right-3">
                                <button onclick="clearProjectVote({{ $project->id }})" class="text-[10px] font-bold text-slate-300 hover:text-red-500 transition" title="Limpar Voto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <textarea id="ressalva-{{ $project->id }}" rows="1" 
                                      class="w-full text-sm border-slate-200 dark:border-slate-600 rounded-xl focus:ring-[#FF3842] focus:border-[#FF3842] bg-white dark:bg-slate-800 dark:text-white placeholder-slate-400 pt-3" 
                                      placeholder="Escreva aqui..." 
                                      onblur="saveVote({{ $project->id }})">{{ $vote->ressalva ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-900 text-slate-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Nenhum projeto encontrado.</p>
                    <a href="{{ route('agenda.vote', $agenda->id) }}" class="text-[#FF3842] font-bold text-sm hover:underline mt-2 inline-block">Limpar Filtros</a>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40 w-[92%] max-w-[700px] transition-all duration-300" id="floating-bar">
        <div class="bg-[#1e293b] dark:bg-black/90 text-white rounded-full shadow-2xl shadow-slate-900/50 p-2 pl-6 pr-2 flex items-center justify-between border border-slate-700 backdrop-blur-md">
            <div class="flex items-center gap-6 flex-1 mr-4">
                <div class="flex flex-col min-w-[60px]">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Progresso</span>
                    <span class="text-lg font-black text-white leading-none tracking-tight" id="progress-percent-text">{{ $progressData['percent'] }}%</span>
                </div>
                <div class="flex-1 max-w-xs hidden sm:block">
                    <div class="w-full bg-slate-700 rounded-full h-1.5 overflow-hidden">
                        <div id="progress-bar-fill" class="h-1.5 rounded-full transition-all duration-1000 bg-gradient-to-r from-[#FF3842] to-orange-500" style="width: {{ $progressData['percent'] }}%"></div>
                    </div>
                </div>
                <div id="global-save-status" class="hidden md:flex items-center text-emerald-400 text-[10px] font-bold uppercase tracking-widest opacity-0 transition-opacity duration-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Salvo
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="attemptConclusion({{ $agenda->id }})" class="px-6 py-3 rounded-full bg-[#FF3842] hover:bg-red-600 text-white font-bold transition shadow-lg shadow-red-900/50 text-xs uppercase tracking-wide flex items-center gap-2 transform active:scale-95">
                    Concluir
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="detailsModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDetailsModal()"></div>
        <div class="absolute inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-2xl border border-slate-200 dark:border-slate-700">
                    <div class="bg-slate-50 dark:bg-slate-900 px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-start">
                        <div>
                            <span id="md_codigo" class="bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded mb-2 inline-block tracking-wider"></span>
                            <h3 id="md_ementa" class="text-lg font-bold text-slate-900 dark:text-white leading-snug"></h3>
                        </div>
                        <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-[#FF3842] transition p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4 text-sm">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">Autoria</h4>
                                <div><span class="text-slate-500 dark:text-slate-400 block text-xs">Autor</span> <span id="md_autor" class="font-bold text-slate-800 dark:text-white"></span></div>
                                <div><span class="text-slate-500 dark:text-slate-400 block text-xs">Partido/UF</span> <span id="md_partido_uf" class="font-bold text-slate-800 dark:text-white"></span></div>
                            </div>
                            <div class="space-y-4 text-sm">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">Situação</h4>
                                <div><span class="text-slate-500 dark:text-slate-400 block text-xs">Local</span> <span id="md_local" class="font-bold text-slate-800 dark:text-white"></span></div>
                                <div><span class="text-slate-500 dark:text-slate-400 block text-xs">Status</span> <span id="md_situacao" class="font-bold text-slate-800 dark:text-white"></span></div>
                            </div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-5 rounded-xl border border-blue-100 dark:border-blue-900/50 mb-6">
                            <h4 class="text-[10px] font-bold text-blue-800 dark:text-blue-400 uppercase tracking-widest mb-2">Foco do Projeto</h4>
                            <div id="md_foco" class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed text-justify"></div>
                        </div>
                        <div class="text-center">
                            <a id="md_link" href="#" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Abrir PDF Original
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let votesState = {};

        function setPriority(id, val) {
            if(!votesState[id]) votesState[id] = {};
            votesState[id].prioridade = val;
            
            ['Baixa', 'Média', 'Alta', 'Agenda'].forEach(p => {
                const btn = document.getElementById(`btn-prio-${id}-${p}`);
                if(btn) btn.className = `px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700`;
            });
            const active = document.getElementById(`btn-prio-${id}-${val}`);
            if(active) active.className = `px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-slate-800 text-white border-slate-800 ring-2 ring-slate-200 dark:bg-white dark:text-slate-900`;
            saveVote(id);
        }

        function setPosition(id, val) {
            if(!votesState[id]) votesState[id] = {};
            votesState[id].posicao = val;
            
            const btnConv = document.getElementById(`btn-pos-${id}-Convergente`);
            const btnDiv = document.getElementById(`btn-pos-${id}-Divergente`);
            const btnAbs = document.getElementById(`btn-pos-${id}-Abstenção`);
            
            const baseClass = "px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600";
            
            btnConv.className = baseClass + " hover:border-green-400 hover:text-green-600";
            btnDiv.className = baseClass + " hover:border-red-400 hover:text-red-600";
            btnAbs.className = baseClass + " hover:bg-slate-100";

            if(val === 'Convergente') btnConv.className = "px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-green-600 text-white border-green-600 ring-2 ring-green-100";
            else if(val === 'Divergente') btnDiv.className = "px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-red-600 text-white border-red-600 ring-2 ring-red-100";
            else if(val === 'Abstenção') btnAbs.className = "px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-slate-500 text-white border-slate-500 ring-2 ring-slate-200";
            
            saveVote(id);
        }

        function clearProjectVote(id) {
            if(!votesState[id]) votesState[id] = {};
            votesState[id].prioridade = null;
            votesState[id].posicao = null;
            
            // Reset Visual
            ['Baixa', 'Média', 'Alta', 'Agenda'].forEach(p => {
                const btn = document.getElementById(`btn-prio-${id}-${p}`);
                if(btn) btn.className = `px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700`;
            });
            const baseClass = "px-2 py-3 border rounded-xl text-xs font-bold transition-all shadow-sm transform active:scale-95 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-600";
            document.getElementById(`btn-pos-${id}-Convergente`).className = baseClass + " hover:border-green-400 hover:text-green-600";
            document.getElementById(`btn-pos-${id}-Divergente`).className = baseClass + " hover:border-red-400 hover:text-red-600";
            document.getElementById(`btn-pos-${id}-Abstenção`).className = baseClass + " hover:bg-slate-100";
            
            saveVote(id);
        }

        function saveVote(id) {
            if(!votesState[id]) votesState[id] = {};
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
                    const badge = document.getElementById(`status-badge-${id}`);
                    const card = document.getElementById(`card-${id}`);
                    
                    // Reset Classes
                    badge.className = "text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider border transition-colors";
                    card.classList.remove('border-green-500', 'border-amber-500', 'border-slate-200', 'dark:border-slate-700');

                    if(data.status === 'complete' || (payload.prioridade && payload.posicao)) { 
                        badge.innerText = "VOTADO";
                        badge.classList.add('bg-green-100', 'text-green-800', 'border-green-200');
                        card.classList.add('border-green-500');
                    } else if (payload.prioridade || payload.posicao) {
                        badge.innerText = "EM ANDAMENTO";
                        badge.classList.add('bg-amber-100', 'text-amber-800', 'border-amber-200', 'animate-pulse');
                        card.classList.add('border-amber-500');
                    } else {
                        badge.innerText = "PENDENTE";
                        badge.classList.add('bg-slate-100', 'text-slate-500', 'border-slate-200');
                        card.classList.add('border-slate-200', 'dark:border-slate-700');
                    }

                    document.getElementById('progress-percent-text').innerText = data.newPercent + '%';
                    document.getElementById('progress-bar-fill').style.width = data.newPercent + '%';
                    
                    const globalMsg = document.getElementById('global-save-status');
                    globalMsg.classList.remove('opacity-0');
                    setTimeout(() => globalMsg.classList.add('opacity-0'), 2000);
                }
            });
        }

        // --- MODAL ---
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
            fetch(`/agenda/${agendaId}/check-completion`) // Opcional
            .catch(() => {
                Swal.fire({
                    icon: 'question',
                    title: 'Finalizar Votação?',
                    text: 'Você será redirecionado ao painel.',
                    confirmButtonColor: '#FF3842',
                    confirmButtonText: 'Sim, finalizar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('dashboard') }}";
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
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
</x-app-layout>