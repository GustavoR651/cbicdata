<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <x-slot name="header">
        <div class="flex items-center gap-4">
             <span class="flex items-center justify-center w-12 h-12 bg-[#FF3842] text-white rounded-2xl shadow-lg shadow-red-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </span>
            <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                <span class="block text-xs text-slate-400 font-bold uppercase tracking-wider">Agenda {{ $agenda->year }}</span>
                Base de Projetos
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-6 md:py-10">
            
            <!-- Main Content Card -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                
                <!-- Filters Header -->
                <div class="p-8 border-b border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-900">
                   <form method="GET" action="{{ route('admin.agendas.show', $agenda->id) }}" class="flex flex-col gap-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                            <!-- Search -->
                            <div class="md:col-span-3">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 block tracking-wider">Pesquisa</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none icon-transition"><svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#FF3842] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-[#FF3842] focus:border-[#FF3842] dark:text-white transition-all" placeholder="Código, Palavra-chave...">
                                </div>
                            </div>
                            
                            <!-- Selects -->
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 block tracking-wider">Origem</label>
                                <select name="type" onchange="this.form.submit()" class="block w-full py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-[#FF3842] focus:border-[#FF3842] dark:text-white text-slate-600">
                                    <option value="all">Todas</option>
                                    <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Apresentados</option>
                                    <option value="remanescente" {{ request('type') == 'remanescente' ? 'selected' : '' }}>Remanescentes</option>
                                </select>
                            </div>

                            <div class="md:col-span-3">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 block tracking-wider">Interesse</label>
                                <select name="interesse" onchange="this.form.submit()" class="block w-full py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-[#FF3842] focus:border-[#FF3842] dark:text-white text-slate-600">
                                    <option value="all">Todos os Interesses</option>
                                    @foreach($interesses as $i) @if($i) <option value="{{ $i }}" {{ request('interesse') == $i ? 'selected' : '' }}>{{ Str::limit($i, 25) }}</option> @endif @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 block tracking-wider">Tema</label>
                                <select name="tema" onchange="this.form.submit()" class="block w-full py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-[#FF3842] focus:border-[#FF3842] dark:text-white text-slate-600">
                                    <option value="all">Todos</option>
                                    @foreach($temas as $t) <option value="{{ $t }}" {{ request('tema') == $t ? 'selected' : '' }}>{{ Str::limit($t, 15) }}</option> @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 block tracking-wider">Subtema</label>
                                <select name="subtema" onchange="this.form.submit()" class="block w-full py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-[#FF3842] focus:border-[#FF3842] dark:text-white text-slate-600">
                                    <option value="all">Todos</option>
                                    @foreach($subtemas as $st) @if($st) <option value="{{ $st }}" {{ request('subtema') == $st ? 'selected' : '' }}>{{ Str::limit($st, 15) }}</option> @endif @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Info Bar -->
                         <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-3">
                                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $projects->total() }} Projetos Listados</span>
                            </div>

                            @if(request()->anyFilled(['search', 'type', 'tema', 'subtema', 'interesse']) && request('type') != 'all')
                                <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="text-xs font-bold text-red-500 hover:text-white hover:bg-red-500 border border-red-100 flex items-center px-4 py-2 rounded-lg transition-all shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> 
                                    LIMPAR FILTROS
                                </a>
                            @endif
                        </div>
                   </form>
                </div>

                <!-- Projects Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                             <tr class="bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700 text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                                <th class="px-8 py-5 w-24">Código</th>
                                <th class="px-4 py-5 w-[40%]">Detalhes do Projeto</th>
                                <th class="px-4 py-5">Autoria</th>
                                <th class="px-4 py-5 text-center">Classificação</th>
                                <th class="px-4 py-5 text-center">Votos</th>
                                <th class="px-8 py-5 text-right w-20"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @forelse($projects as $project)
                                @php
                                    $projectData = $project->toArray();
                                    $projectData['stats'] = [
                                        'Agenda' => $project->votes->where('prioridade', 'Agenda')->count(),
                                        'Alta'   => $project->votes->where('prioridade', 'Alta')->count(),
                                        'Média'  => $project->votes->where('prioridade', 'Média')->count(),
                                        'Baixa'  => $project->votes->where('prioridade', 'Baixa')->count(),
                                        'Convergente' => $project->votes->where('posicao', 'Convergente')->count(),
                                        'Divergente'  => $project->votes->where('posicao', 'Divergente')->count(),
                                     ];
                                    $projectData['ressalvas_list'] = $project->votes->filter(fn($v) => !empty($v->ressalva))->map(function($v){
                                        $empresa = $v->user->associacao ?? 'Empresa'; // Assumindo campo 'associacao' ou placeholder
                                        return ['empresa' => $empresa, 'texto' => $v->ressalva];
                                    })->values();
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-200 group cursor-pointer" onclick='openModal(@json($projectData))'>
                                    <td class="px-8 py-5 align-middle">
                                        <span class="font-mono font-bold text-slate-400 text-xs">#{{ $project->codigo }}</span>
                                    </td>
                                    <td class="px-4 py-5 align-middle">
                                        <div class="flex items-center gap-3 mb-2">
                                             @if($project->type == 'remanescente')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-100">Reman.</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-green-50 text-green-600 border border-green-100">Agendado</span>
                                            @endif
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ Str::limit($project->orgao_origem, 20) }}</span>
                                        </div>
                                        <p class="text-base font-bold text-slate-700 dark:text-white line-clamp-2 leading-snug group-hover:text-[#FF3842] transition-colors">
                                            {{ $project->ementa }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-5 align-middle">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">{{ substr($project->autor, 0, 1) }}</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $project->autor }}</p>
                                                <p class="text-[10px] text-slate-400">{{ $project->partido }} / {{ $project->uf }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 align-middle text-center">
                                         <div class="inline-flex flex-col items-center">
                                            <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300 bg-slate-100 px-2 py-1 rounded-lg mb-1">{{ Str::limit($project->tema, 15) }}</span>
                                            <span class="text-[9px] text-slate-400">{{ Str::limit($project->celula_tematica, 15) }}</span>
                                         </div>
                                    </td>
                                    <td class="px-4 py-5 align-middle text-center">
                                        @if($project->votes->count() > 0)
                                            <span class="inline-flex items-center justify-center h-6 px-2.5 rounded-full bg-slate-800 text-white text-xs font-bold shadow-sm">{{ $project->votes->count() }}</span>
                                        @else
                                            <span class="text-xs text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 align-middle text-right">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-transparent group-hover:bg-white text-slate-300 group-hover:text-[#FF3842] group-hover:shadow-sm transition-all">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 font-bold">Nenhum projeto encontrado.</h3>
                                        <p class="text-slate-400 text-sm mt-1">Tente ajustar seus filtros de pesquisa.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 border-b-0 rounded-b-[2.5rem]">
                    {{ $projects->links() }}
                </div>
            </div>

        </div>
    </div>

    <div id="projectModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white dark:bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-5xl sm:w-full border border-slate-200 dark:border-slate-700">
                <div id="modalContent" class="bg-white dark:bg-slate-800 p-8 md:p-10">
                    
                    <div class="border-b border-slate-100 dark:border-slate-700 pb-6 mb-6">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span id="md_codigo" class="bg-[#FF3842] text-white text-lg font-bold px-3 py-1 rounded-lg shadow-md shadow-red-500/20"></span>
                            <span id="md_posicao_top" class="bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-bold px-3 py-1 rounded-full border border-slate-200 dark:border-slate-600"></span>
                        </div>
                        <h3 id="md_ementa" class="text-xl md:text-2xl font-black text-slate-900 dark:text-white leading-snug"></h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 text-sm text-slate-600 dark:text-slate-300">
                        <div class="space-y-4">
                            <h4 class="font-bold text-[#FF3842] border-b border-red-100 dark:border-red-900/50 pb-1 uppercase text-xs tracking-wider">Origem & Autoria</h4>
                            <div><span class="text-slate-400 block text-xs uppercase">Autor</span> <span id="md_autor" class="font-bold text-slate-800 dark:text-white"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Partido / UF</span> <span id="md_partido_uf" class="font-bold text-slate-800 dark:text-white"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Órgão Origem</span> <span id="md_orgao_origem" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                        </div>
                        <div class="space-y-4">
                            <h4 class="font-bold text-[#FF3842] border-b border-red-100 dark:border-red-900/50 pb-1 uppercase text-xs tracking-wider">Classificação</h4>
                            <div><span class="text-slate-400 block text-xs uppercase">Tema</span> <span id="md_tema" class="font-bold text-[#FF3842]"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Subtema</span> <span id="md_subtema" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Célula Temática</span> <span id="md_celula" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                        </div>
                        <div class="space-y-4">
                            <h4 class="font-bold text-[#FF3842] border-b border-red-100 dark:border-red-900/50 pb-1 uppercase text-xs tracking-wider">Tramitação</h4>
                            <div><span class="text-slate-400 block text-xs uppercase">Regime</span> <span id="md_regime" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Local Atual</span> <span id="md_local_atual" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                            <div><span class="text-slate-400 block text-xs uppercase">Situação</span> <span id="md_situacao" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                        </div>
                    </div>

                    <div class="mb-6 bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2 flex items-center"><svg class="w-4 h-4 mr-2 text-[#FF3842]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Foco do Projeto</h4>
                        <p id="md_foco" class="text-slate-700 dark:text-slate-400 text-justify leading-relaxed"></p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs text-slate-600 dark:text-slate-300 mb-8">
                        <div><span class="block text-slate-400 uppercase">Posição Recente</span> <span id="md_posicao" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Tipo Resultado</span> <span id="md_tipo_resultado" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Ref. Posição</span> <span id="md_ref_posicao" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Link PDF</span> <a id="md_link" href="#" target="_blank" class="text-[#FF3842] underline font-bold">Abrir Documento</a></div>
                    </div>

                    <div class="mb-8">
                         <h4 class="text-sm font-bold text-slate-400 uppercase mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Prévia de Votação
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prioridade (Table Style) -->
                        <div>
                            <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 h-full">
                                <h4 class="text-xs font-bold text-center text-slate-400 uppercase mb-4 bg-slate-100 dark:bg-slate-800 py-1.5 rounded-lg tracking-wider">Prioridade</h4>
                                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">
                                    <table class="w-full text-sm">
                                        <tr class="bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                                            <td class="py-3 pl-4 font-bold text-purple-600 dark:text-purple-400">Agenda</td>
                                            <td id="v_agenda" class="py-3 pr-4 text-right font-black text-slate-800 dark:text-white text-lg">0</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                                            <td class="py-3 pl-4 font-bold text-red-600 dark:text-red-400">Alta</td>
                                            <td id="v_alta" class="py-3 pr-4 text-right font-black text-slate-800 dark:text-white text-lg">0</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                                            <td class="py-3 pl-4 font-bold text-orange-600 dark:text-orange-400">Média</td>
                                            <td id="v_media" class="py-3 pr-4 text-right font-black text-slate-800 dark:text-white text-lg">0</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-slate-800">
                                            <td class="py-3 pl-4 font-bold text-green-600 dark:text-green-400">Baixa</td>
                                            <td id="v_baixa" class="py-3 pr-4 text-right font-black text-slate-800 dark:text-white text-lg">0</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Posição (Block Style) -->
                        <div>
                            <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 h-full flex flex-col">
                                <h4 class="text-xs font-bold text-center text-slate-400 uppercase mb-4 bg-slate-100 dark:bg-slate-800 py-1.5 rounded-lg tracking-wider">Posição</h4>
                                <div class="grid grid-cols-2 gap-4 flex-1">
                                    <div class="rounded-xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/20 dark:border-emerald-800 flex flex-col items-center justify-center p-4">
                                        <span id="v_convergente" class="block text-3xl font-black text-emerald-600 dark:text-emerald-400 mb-1">0</span>
                                        <span class="text-[10px] uppercase font-bold text-emerald-700 dark:text-emerald-300 tracking-wider">Convergente</span>
                                    </div>
                                    <div class="rounded-xl bg-red-50 border border-red-100 dark:bg-red-900/20 dark:border-red-800 flex flex-col items-center justify-center p-4">
                                        <span id="v_divergente" class="block text-3xl font-black text-red-600 dark:text-red-400 mb-1">0</span>
                                        <span class="text-[10px] uppercase font-bold text-red-700 dark:text-red-300 tracking-wider">Divergente</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="ressalvas_container" class="mb-2 hidden">
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-3 border-b border-slate-100 dark:border-slate-700 pb-2">Ressalvas & Comentários</h4>
                        <div id="ressalvas_list" class="space-y-3 max-h-40 overflow-y-auto custom-scrollbar pr-2">
                            </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-700 text-center text-xs text-slate-400 hidden print-show">Relatório gerado via CBIC AGENDA em {{ date('d/m/Y') }}</div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-900 px-8 py-5 flex flex-row-reverse gap-3 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition">Fechar</button>
                    <button type="button" onclick="generatePDF()" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold hover:bg-orange-700 transition flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Salvar PDF</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TEMPLATE EXECUTIVO PDF (Oculto) -->
    <div id="pdf-template" class="hidden text-slate-900 bg-white p-8 max-w-[800px] mx-auto font-sans">
        <!-- Header -->
        <div class="flex justify-between items-center border-b-2 border-red-600 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-black uppercase text-slate-800">Relatório Executivo</h1>
                <p class="text-sm text-slate-500">Agenda Legislativa da Indústria da Construção • {{ $agenda->year }}</p>
            </div>
            <div class="text-right">
                <div class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded inline-block mb-1">PROJETO DE LEI</div>
                <div id="pdf_codigo" class="text-xl font-black text-slate-800"></div>
            </div>
        </div>

        <!-- Ementa -->
        <div class="mb-8">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Ementa do Projeto</h2>
            <p id="pdf_ementa" class="text-lg font-serif italic text-slate-700 leading-relaxed border-l-4 border-slate-200 pl-4 py-1"></p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-sm font-bold text-red-600 uppercase border-b border-slate-200 pb-1 mb-3">Origem & Autoria</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Autor:</span> <span id="pdf_autor" class="font-bold"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Partido/UF:</span> <span id="pdf_partido_uf" class="font-bold"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Origem:</span> <span id="pdf_orgao_origem"></span></div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-600 uppercase border-b border-slate-200 pb-1 mb-3">Classificação</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Tema:</span> <span id="pdf_tema" class="font-bold"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Subtema:</span> <span id="pdf_subtema"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Regime:</span> <span id="pdf_regime"></span></div>
                </div>
            </div>
        </div>

        <!-- Foco -->
        <div class="mb-8 bg-slate-50 p-4 rounded-lg border border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase mb-2">Foco do Projeto</h3>
            <p id="pdf_foco" class="text-sm text-justify text-slate-700 leading-relaxed"></p>
        </div>

        <!-- Votação -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-800 uppercase mb-4 flex items-center gap-2">
                <span class="w-1 h-6 bg-red-600 rounded-full"></span>
                Resultado da Votação
            </h3>
            
            <div class="grid grid-cols-2 gap-8 mb-6">
                <!-- Prioridade Table -->
                <div>
                    <h4 class="text-xs font-bold text-center uppercase mb-2 bg-slate-100 py-1 rounded">Prioridade</h4>
                    <table class="w-full text-sm">
                        <tr class="border-b border-slate-100"><td class="py-2 pl-2 text-purple-700 font-bold">Agenda</td><td id="pdf_agenda" class="text-right pr-2 font-black"></td></tr>
                        <tr class="border-b border-slate-100"><td class="py-2 pl-2 text-red-700 font-bold">Alta</td><td id="pdf_alta" class="text-right pr-2 font-black"></td></tr>
                        <tr class="border-b border-slate-100"><td class="py-2 pl-2 text-orange-700 font-bold">Média</td><td id="pdf_media" class="text-right pr-2 font-black"></td></tr>
                        <tr><td class="py-2 pl-2 text-green-700 font-bold">Baixa</td><td id="pdf_baixa" class="text-right pr-2 font-black"></td></tr>
                    </table>
                </div>
                <!-- Posição Table -->
                <div>
                    <h4 class="text-xs font-bold text-center uppercase mb-2 bg-slate-100 py-1 rounded">Posição</h4>
                    <div class="flex gap-4 h-full items-center justify-center">
                        <div class="text-center rounded-lg bg-emerald-50 border border-emerald-100 p-3 w-1/2">
                            <div id="pdf_convergente" class="text-2xl font-black text-emerald-600"></div>
                            <div class="text-[10px] uppercase font-bold text-emerald-800">Convergente</div>
                        </div>
                        <div class="text-center rounded-lg bg-red-50 border border-red-100 p-3 w-1/2">
                            <div id="pdf_divergente" class="text-2xl font-black text-red-600"></div>
                            <div class="text-[10px] uppercase font-bold text-red-800">Divergente</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ressalvas -->
        <div id="pdf_ressalvas_container" class="mb-6">
             <h3 class="text-sm font-bold text-slate-800 uppercase border-b border-slate-200 pb-2 mb-4">Ressalvas</h3>
             <div id="pdf_ressalvas_list" class="space-y-4"></div>
        </div>

        <!-- Footer -->
        <div class="mt-auto pt-4 border-t border-slate-200 flex justify-between text-[10px] text-slate-400 uppercase font-bold">
            <span>Sistema CBIC Agenda</span>
            <span>Gerado em {{ date('d/m/Y H:i') }}</span>
        </div>
    </div>

    <script>
        function openModal(data) {
            const val = (v) => v ? v : '-';

            document.getElementById('md_codigo').innerText = val(data.codigo);
            document.getElementById('md_posicao_top').innerText = val(data.posicao_recente);
            document.getElementById('md_ementa').innerText = val(data.ementa);
            document.getElementById('md_autor').innerText = val(data.autor);
            document.getElementById('md_partido_uf').innerText = val(data.partido) + ' / ' + val(data.uf);
            document.getElementById('md_orgao_origem').innerText = val(data.orgao_origem);
            document.getElementById('md_tema').innerText = val(data.tema);
            document.getElementById('md_subtema').innerText = val(data.subtema);
            document.getElementById('md_celula').innerText = val(data.celula_tematica);
            document.getElementById('md_regime').innerText = val(data.regime_tramitacao);
            document.getElementById('md_local_atual').innerText = val(data.localizacao_atual) + ' (' + val(data.orgao_localizacao) + ')';
            document.getElementById('md_situacao').innerText = val(data.situacao);
            document.getElementById('md_foco').innerText = val(data.foco);
            document.getElementById('md_posicao').innerText = val(data.posicao_recente);
            document.getElementById('md_tipo_resultado').innerText = val(data.tipo_resultado);
            document.getElementById('md_ref_posicao').innerText = val(data.referencia_posicao);
            
            // --- ESTATÍSTICAS ---
            if(data.stats) {
                // Prioridade
                document.getElementById('v_agenda').innerText = data.stats.Agenda || 0;
                document.getElementById('v_alta').innerText = data.stats.Alta || 0;
                document.getElementById('v_media').innerText = data.stats.Média || 0;
                document.getElementById('v_baixa').innerText = data.stats.Baixa || 0;

                // Posição
                document.getElementById('v_convergente').innerText = data.stats.Convergente || 0;
                document.getElementById('v_divergente').innerText = data.stats.Divergente || 0;
            }

            // --- RESSALVAS ---
            const ressalvasContainer = document.getElementById('ressalvas_container');
            const ressalvasList = document.getElementById('ressalvas_list');
            ressalvasList.innerHTML = ''; 

            if(data.ressalvas_list && data.ressalvas_list.length > 0) {
                data.ressalvas_list.forEach(item => {
                    const el = document.createElement('div');
                    el.className = 'bg-yellow-50 dark:bg-yellow-900/10 border-l-4 border-yellow-400 p-3 rounded text-sm text-slate-700 dark:text-slate-300';
                    // Format: (Empresa) - Ressalva
                    el.innerHTML = `<span class="font-bold text-slate-900 dark:text-white">(${item.empresa})</span> - ${item.texto}`;
                    ressalvasList.appendChild(el);
                });
                ressalvasContainer.classList.remove('hidden');
            } else {
                ressalvasContainer.classList.add('hidden');
            }

            // --- POPULATE PDF TEMPLATE ---
            document.getElementById('pdf_codigo').innerText = val(data.codigo);
            document.getElementById('pdf_ementa').innerText = val(data.ementa);
            document.getElementById('pdf_autor').innerText = val(data.autor);
            document.getElementById('pdf_partido_uf').innerText = val(data.partido) + ' / ' + val(data.uf);
            document.getElementById('pdf_orgao_origem').innerText = val(data.orgao_origem);
            document.getElementById('pdf_tema').innerText = val(data.tema);
            document.getElementById('pdf_subtema').innerText = val(data.subtema);
            document.getElementById('pdf_regime').innerText = val(data.regime_tramitacao);
            document.getElementById('pdf_foco').innerText = val(data.foco);

            if(data.stats) {
                document.getElementById('pdf_agenda').innerText = data.stats.Agenda || 0;
                document.getElementById('pdf_alta').innerText = data.stats.Alta || 0;
                document.getElementById('pdf_media').innerText = data.stats.Média || 0;
                document.getElementById('pdf_baixa').innerText = data.stats.Baixa || 0;
                document.getElementById('pdf_convergente').innerText = data.stats.Convergente || 0;
                document.getElementById('pdf_divergente').innerText = data.stats.Divergente || 0;
            }

             // --- PDF RESSALVAS ---
            const pdfRessalvasList = document.getElementById('pdf_ressalvas_list');
            const pdfRessalvasContainer = document.getElementById('pdf_ressalvas_container');
            pdfRessalvasList.innerHTML = ''; 

            if(data.ressalvas_list && data.ressalvas_list.length > 0) {
                data.ressalvas_list.forEach(item => {
                    const el = document.createElement('div');
                    el.className = 'text-xs text-slate-600 border-l-2 border-red-300 pl-2 bg-slate-50 p-2 italic';
                    el.innerHTML = `<strong class="text-slate-900 not-italic block mb-1">${item.empresa}</strong>${item.texto}`;
                    pdfRessalvasList.appendChild(el);
                });
                pdfRessalvasContainer.classList.remove('hidden');
            } else {
                pdfRessalvasContainer.classList.add('hidden');
            }

            document.getElementById('projectModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('projectModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function generatePDF() {
            // Target the specialized Executive Template
            const element = document.getElementById('pdf-template');
            element.classList.remove('hidden'); // Show temporarily for rendering

            const code = document.getElementById('pdf_codigo').innerText;
            const opt = {
                margin: [0.4, 0.4], // 0.4 inch margin
                filename: `Relatorio_Executivo_${code}.pdf`,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 2, useCORS: true }, // Higher scale for clarity
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().set(opt).from(element).save().then(() => {
                 element.classList.add('hidden'); // Hide again
            });
        }
    </script>


    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
        
        /* PDF Specific Condensing */
        .pdf-mode { padding: 20px !important; }
        .pdf-mode h3 { font-size: 18px !important; margin-bottom: 0.5rem !important; }
        .pdf-mode .grid { gap: 0.5rem !important; margin-bottom: 1rem !important; }
        .pdf-mode .p-6, .pdf-mode .p-5, .pdf-mode .p-4 { padding: 0.75rem !important; }
        .pdf-mode .text-xl { font-size: 1rem !important; }
        .pdf-mode .text-2xl { font-size: 1.25rem !important; }
    </style>
</x-app-layout>