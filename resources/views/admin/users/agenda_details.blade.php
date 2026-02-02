<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                Visualização da Agenda
            </h2>
            
            <a href="{{ route('admin.agendas.index') }}" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 text-sm font-bold px-4 py-2 rounded-xl transition flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-300">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none mb-8 border border-gray-100 dark:border-slate-700 flex flex-col md:flex-row justify-between gap-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#FF3842] to-red-600"></div>

                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-red-50 dark:bg-red-900/20 text-[#FF3842] text-xs font-bold px-3 py-1 rounded-lg border border-red-100 dark:border-red-900/50 uppercase tracking-wider">
                            Ano Base: {{ $agenda->year }}
                        </span>
                        @if(strtotime($agenda->deadline) > time())
                            <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold px-3 py-1 rounded-lg border border-green-200 dark:border-green-800 flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                Aberta
                            </span>
                        @else
                            <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 text-xs font-bold px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-600">Encerrada</span>
                        @endif
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white mb-2 leading-tight">{{ $agenda->title }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Prazo: <strong class="text-slate-700 dark:text-slate-300">{{ date('d/m/Y \à\s H:i', strtotime($agenda->deadline)) }}</strong></p>
                </div>
                
                <div class="flex flex-col gap-4 min-w-[280px]">
                    <div class="flex rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="flex-1 py-5 text-center border-r border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-800 transition">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Projetos</p>
                            <p class="text-3xl font-black text-[#FF3842]">{{ $agenda->projects->count() }}</p>
                        </div>
                        <div class="flex-1 py-5 text-center hover:bg-white dark:hover:bg-slate-800 transition">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Participantes</p>
                            <p class="text-3xl font-black text-slate-800 dark:text-white">{{ $agenda->users->count() }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="flex justify-center items-center bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold py-3 rounded-xl shadow-lg shadow-orange-500/20 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Editar
                        </a>
                        <form action="{{ route('admin.agenda.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('ATENÇÃO: Confirmar exclusão?');" class="h-full">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full h-full flex justify-center items-center bg-white dark:bg-slate-700 border-2 border-red-100 dark:border-slate-600 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-900 text-sm font-bold py-3 rounded-xl shadow-sm transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <form method="GET" action="{{ route('admin.show', $agenda->id) }}" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-hover:text-[#FF3842] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full pl-12 pr-4 py-4 bg-white dark:bg-slate-800 border-0 rounded-2xl shadow-sm text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-[#FF3842] transition-all duration-200" 
                           placeholder="Pesquisar por Código, Ementa, Autor ou Partido...">
                </form>
            </div>

            <div class="space-y-4">
                @forelse($projects as $project)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border-l-4 border-[#FF3842] p-6 relative hover:shadow-md transition duration-200 group">
                    
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            <span class="bg-red-50 dark:bg-red-900/20 text-[#FF3842] text-sm font-bold px-3 py-1 rounded-md border border-red-100 dark:border-red-900/50">
                                {{ $project->codigo }}
                            </span>
                            @if($project->prioridade_original)
                            <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold px-3 py-1 rounded-full border border-green-200 dark:border-green-800">
                                {{ $project->prioridade_original }}
                            </span>
                            @endif
                        </div>
                        
                        <button onclick="openModal({{ json_encode($project) }})" 
                                class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:text-[#FF3842] hover:border-[#FF3842] font-bold py-1.5 px-4 rounded-lg text-sm transition shadow-sm">
                            Detalhes
                        </button>
                    </div>

                    <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3 leading-snug group-hover:text-[#FF3842] transition-colors">
                        {{ $project->ementa }}
                    </h4>

                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-2 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-bold mr-1 text-slate-700 dark:text-slate-300">Autor:</span> 
                            {{ $project->autor }} 
                            <span class="mx-2 text-slate-300 dark:text-slate-600">|</span> 
                            <span class="font-semibold text-[#FF3842]">{{ $project->partido }} / {{ $project->uf }}</span>
                        </div>

                        @if($project->foco)
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-slate-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <span class="font-bold text-slate-700 dark:text-slate-300">Foco:</span>
                                <span class="text-slate-600 dark:text-slate-400 ml-1">{{ Str::limit($project->foco, 140) }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center">
                        <span class="text-xs font-bold text-slate-400 uppercase mr-2">Tema:</span>
                        <span class="text-xs font-bold text-[#FF3842] uppercase tracking-wider bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded border border-red-100 dark:border-red-900/50">
                            {{ $project->tema }}
                        </span>
                    </div>

                </div>
                @empty
                <div class="text-center py-12 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400">Nenhum projeto encontrado ou dados não correspondem.</p>
                </div>
                @endforelse

                @if($projects->hasPages())
                    <div class="mt-6">{{ $projects->links() }}</div>
                @endif
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
                            <span id="md_prioridade" class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-bold px-3 py-1 rounded-full border border-green-200 dark:border-green-800"></span>
                            <span id="md_situacao" class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-sm font-bold px-3 py-1 rounded-full border border-slate-200 dark:border-slate-600"></span>
                        </div>
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Ementa do Projeto</h2>
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
                            <div><span class="text-slate-400 block text-xs uppercase">Posição Recente</span> <span id="md_posicao" class="font-medium text-slate-700 dark:text-slate-300"></span></div>
                        </div>
                    </div>

                    <div class="mb-6 bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#FF3842]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Foco do Projeto
                        </h4>
                        <p id="md_foco" class="text-slate-700 dark:text-slate-400 text-justify leading-relaxed"></p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs text-slate-600 dark:text-slate-300">
                        <div><span class="block text-slate-400 uppercase">Data Posição</span> <span id="md_data_posicao" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Tipo Resultado</span> <span id="md_tipo_resultado" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Ref. Posição</span> <span id="md_ref_posicao" class="font-bold"></span></div>
                        <div><span class="block text-slate-400 uppercase">Link PDF</span> <a id="md_link" href="#" target="_blank" class="text-[#FF3842] underline font-bold">Abrir Documento</a></div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-700 text-center text-xs text-slate-400 hidden print-show">
                        Relatório gerado via CBIC AGENDA em {{ date('d/m/Y') }}
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-900 px-8 py-5 flex flex-row-reverse gap-3 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition">Fechar</button>
                    <button type="button" onclick="generatePDF()" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold hover:bg-orange-700 transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Salvar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(data) {
            // Helper para evitar null/undefined
            const val = (v) => v ? v : '-';

            // Topo
            document.getElementById('md_codigo').innerText = val(data.codigo);
            document.getElementById('md_ementa').innerText = val(data.ementa);
            document.getElementById('md_prioridade').innerText = val(data.prioridade_original);
            document.getElementById('md_situacao').innerText = val(data.situacao);

            // Coluna 1
            document.getElementById('md_autor').innerText = val(data.autor);
            document.getElementById('md_partido_uf').innerText = val(data.partido) + ' / ' + val(data.uf);
            document.getElementById('md_orgao_origem').innerText = val(data.orgao_origem);

            // Coluna 2
            document.getElementById('md_tema').innerText = val(data.tema);
            document.getElementById('md_subtema').innerText = val(data.subtema);
            document.getElementById('md_celula').innerText = val(data.celula_tematica);

            // Coluna 3
            document.getElementById('md_regime').innerText = val(data.regime_tramitacao);
            document.getElementById('md_local_atual').innerText = val(data.localizacao_atual) + ' (' + val(data.orgao_localizacao) + ')';
            document.getElementById('md_posicao').innerText = val(data.posicao_recente);

            // Foco
            document.getElementById('md_foco').innerText = val(data.foco);

            // Extras
            document.getElementById('md_data_posicao').innerText = val(data.data_posicao);
            document.getElementById('md_tipo_resultado').innerText = val(data.tipo_resultado);
            document.getElementById('md_ref_posicao').innerText = val(data.referencia_posicao);
            
            // Link
            const link = document.getElementById('md_link');
            if(data.link_pdf) {
                link.href = data.link_pdf;
                link.classList.remove('hidden');
                link.innerText = 'Abrir Documento Original';
                link.classList.remove('text-gray-400', 'cursor-not-allowed');
                link.classList.add('text-[#FF3842]', 'underline', 'cursor-pointer');
            } else {
                link.href = '#';
                link.innerText = 'Indisponível';
                link.classList.add('text-gray-400', 'cursor-not-allowed');
                link.classList.remove('text-[#FF3842]', 'underline', 'cursor-pointer');
            }

            // Exibir
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
                margin:       0.3,
                filename:     `Projeto_${code}.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            document.querySelector('.print-show').classList.remove('hidden');
            html2pdf().set(opt).from(element).save().then(() => {
                 document.querySelector('.print-show').classList.add('hidden');
            });
        }
    </script>
</x-app-layout>