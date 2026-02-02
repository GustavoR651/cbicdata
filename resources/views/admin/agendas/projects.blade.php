<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
                <div>
                    <span class="block text-xs text-slate-400 font-bold uppercase">Agenda {{ $agenda->year }}</span>
                    Base de Projetos
                </div>
            </h2>
            <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar ao Painel
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">

            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 mb-6">
                <form method="GET" action="{{ route('admin.agendas.projects', $agenda->id) }}">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Pesquisa</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842]" placeholder="Código, Ementa...">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Origem</label>
                            <select name="type" onchange="this.form.submit()" class="block w-full py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842]">
                                <option value="all">Todas</option>
                                <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Apresentados</option>
                                <option value="remanescente" {{ request('type') == 'remanescente' ? 'selected' : '' }}>Remanescentes</option>
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Interesse</label>
                            <select name="interesse" onchange="this.form.submit()" class="block w-full py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842]">
                                <option value="all">Todos os Interesses</option>
                                @foreach($interesses as $i) 
                                    @if($i) <option value="{{ $i }}" {{ request('interesse') == $i ? 'selected' : '' }}>{{ Str::limit($i, 35) }}</option> @endif 
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Tema</label>
                            <select name="tema" onchange="this.form.submit()" class="block w-full py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842]">
                                <option value="all">Todos</option>
                                @foreach($temas as $t) <option value="{{ $t }}" {{ request('tema') == $t ? 'selected' : '' }}>{{ Str::limit($t, 20) }}</option> @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Subtema</label>
                            <select name="subtema" onchange="this.form.submit()" class="block w-full py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-[#FF3842] focus:border-[#FF3842]">
                                <option value="all">Todos</option>
                                @foreach($subtemas as $st) @if($st) <option value="{{ $st }}" {{ request('subtema') == $st ? 'selected' : '' }}>{{ Str::limit($st, 20) }}</option> @endif @endforeach
                            </select>
                        </div>
                    </div>

                    @if(request()->has('search') || (request()->has('type') && request('type') != 'all') || (request()->has('tema') && request('tema') != 'all') || (request()->has('subtema') && request('subtema') != 'all') || (request()->has('interesse') && request('interesse') != 'all'))
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('admin.agendas.projects', $agenda->id) }}" class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center bg-red-50 px-3 py-1.5 rounded-lg transition">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> 
                                Limpar Filtros
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="space-y-4">
                @forelse($projects as $project)
                
                @php
                    // --- CÁLCULO DA PRÉVIA DE VOTOS (AGENDA, ALTA, MÉDIA, BAIXA) ---
                    $votes = $project->votes;
                    
                    $stats = [
                        'Agenda' => $votes->where('vote_value', 'Agenda')->count(),
                        'Alta'   => $votes->where('vote_value', 'Alta')->count(),
                        'Média'  => $votes->where('vote_value', 'Média')->count(),
                        'Baixa'  => $votes->where('vote_value', 'Baixa')->count(),
                        'total'  => $votes->count()
                    ];

                    $ressalvas = $votes->filter(fn($v) => !empty($v->comment))->map(function($v){
                        return [
                            'empresa' => $v->user->associacao ?? 'Empresa não informada',
                            'texto'   => $v->comment
                        ];
                    })->values();

                    $projectData = $project->toArray();
                    $projectData['stats'] = $stats;
                    $projectData['ressalvas_list'] = $ressalvas;
                @endphp

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-[#FF3842] hover:shadow-md transition-all group">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center flex-wrap gap-2 mb-2">
                                <span class="bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-2 py-1 rounded text-xs font-bold font-mono border border-slate-200 dark:border-slate-600">{{ $project->codigo }}</span>
                                @if($project->type == 'remanescente')
                                    <span class="text-[10px] font-bold uppercase text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">Remanescente</span>
                                @else
                                    <span class="text-[10px] font-bold uppercase text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">Agendado</span>
                                @endif
                                @if($project->votes->count() > 0)
                                    <span class="text-[10px] font-bold text-white bg-slate-800 px-2 py-1 rounded-full ml-2">{{ $project->votes->count() }} Votos</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 group-hover:text-[#FF3842] transition-colors">{{ $project->ementa }}</h3>
                            <div class="flex flex-wrap gap-4 text-xs text-slate-500">
                                <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $project->autor }} ({{ $project->partido }}/{{ $project->uf }})</span>
                                <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> {{ Str::limit($project->tema, 30) }}</span>
                            </div>
                        </div>
                        <button onclick='openModal(@json($projectData))' class="whitespace-nowrap px-5 py-2.5 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-sm rounded-xl border border-slate-200 dark:border-slate-600 hover:bg-[#FF3842] hover:text-white hover:border-[#FF3842] transition-all shadow-sm">Ver Detalhes</button>
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 mb-4 text-slate-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                    <h3 class="text-lg font-bold text-slate-600 dark:text-slate-300">Nenhum projeto encontrado</h3>
                </div>
                @endforelse
            </div>
            <div class="mt-8">{{ $projects->links() }}</div>
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

                    <div class="mb-8 bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-700">
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Prévia de Votação (Prioridade)
                        </h4>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="p-3 rounded-xl bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-900/20 dark:border-purple-800 dark:text-purple-300">
                                <span id="v_agenda" class="block text-2xl font-black">0</span>
                                <span class="text-[10px] uppercase font-bold tracking-wider">Agenda</span>
                            </div>
                            <div class="p-3 rounded-xl bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300">
                                <span id="v_alta" class="block text-2xl font-black">0</span>
                                <span class="text-[10px] uppercase font-bold tracking-wider">Alta</span>
                            </div>
                            <div class="p-3 rounded-xl bg-orange-50 text-orange-700 border border-orange-200 dark:bg-orange-900/20 dark:border-orange-800 dark:text-orange-300">
                                <span id="v_media" class="block text-2xl font-black">0</span>
                                <span class="text-[10px] uppercase font-bold tracking-wider">Média</span>
                            </div>
                            <div class="p-3 rounded-xl bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300">
                                <span id="v_baixa" class="block text-2xl font-black">0</span>
                                <span class="text-[10px] uppercase font-bold tracking-wider">Baixa</span>
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
                document.getElementById('v_agenda').innerText = data.stats.Agenda || 0;
                document.getElementById('v_alta').innerText = data.stats.Alta || 0;
                document.getElementById('v_media').innerText = data.stats.Média || 0;
                document.getElementById('v_baixa').innerText = data.stats.Baixa || 0;
            }

            // --- RESSALVAS ---
            const ressalvasContainer = document.getElementById('ressalvas_container');
            const ressalvasList = document.getElementById('ressalvas_list');
            ressalvasList.innerHTML = ''; 

            if(data.ressalvas_list && data.ressalvas_list.length > 0) {
                data.ressalvas_list.forEach(item => {
                    const el = document.createElement('div');
                    el.className = 'bg-yellow-50 dark:bg-yellow-900/10 border-l-4 border-yellow-400 p-3 rounded text-sm text-slate-700 dark:text-slate-300';
                    el.innerHTML = `<span class="font-bold text-slate-900 dark:text-white block mb-1">${item.empresa}</span>${item.texto}`;
                    ressalvasList.appendChild(el);
                });
                ressalvasContainer.classList.remove('hidden');
            } else {
                ressalvasContainer.classList.add('hidden');
            }

            const link = document.getElementById('md_link');
            if(data.link_pdf) {
                link.href = data.link_pdf;
                link.classList.remove('hidden');
                link.innerText = 'Abrir Documento Original';
                link.classList.add('text-[#FF3842]', 'underline', 'cursor-pointer');
            } else {
                link.href = '#';
                link.innerText = 'Indisponível';
                link.classList.remove('text-[#FF3842]', 'underline', 'cursor-pointer');
            }

            document.getElementById('projectModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('projectModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function generatePDF() {
            const element = document.getElementById('modalContent');
            const code = document.getElementById('md_codigo').innerText;
            const opt = {
                margin: 0.3,
                filename: `Projeto_${code}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            document.querySelector('.print-show').classList.remove('hidden');
            html2pdf().set(opt).from(element).save().then(() => {
                 document.querySelector('.print-show').classList.add('hidden');
            });
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
    </style>
</x-app-layout>