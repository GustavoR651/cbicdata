<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <div class="w-1 h-6 bg-gradient-to-b from-[#FF3842] to-red-600 rounded-full"></div>
            Painel Principal
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-8">

            <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white mb-1 tracking-tight">
                        Olá, {{ explode(' ', Auth::user()->name)[0] }} 👋
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Bem-vindo ao sistema de priorização estratégica.</p>
                </div>
            </div>

            @if(isset($mainAgenda))
                @php
                    $now = now();
                    $start = $mainAgenda->start_date;
                    $end = $mainAgenda->deadline;
                    $result = $mainAgenda->results_date;
                    
                    $totalTime = $start->diffInSeconds($result);
                    $elapsed = $start->diffInSeconds($now);
                    $progress = ($now < $start) ? 0 : (($now > $result) ? 100 : ($elapsed / $totalTime) * 100);
                @endphp

                <div class="mb-8 bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-md border border-slate-100 dark:border-slate-700 relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-slate-100 dark:bg-grid-slate-700/30 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FF3842]"></span>
                                </span>
                                Cronograma Oficial {{ $mainAgenda->year }}
                            </h3>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 dark:bg-slate-700 px-2 py-1 rounded-lg uppercase tracking-wider">Tempo Real</span>
                        </div>

                        <div class="relative h-1 bg-slate-100 dark:bg-slate-700 rounded-full mb-6 mx-8 md:mx-12">
                            <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#FF3842] to-orange-500 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(255,56,66,0.4)]" style="width: {{ $progress }}%"></div>
                            
                            <div class="absolute top-1/2 left-0 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-800 shadow-sm flex items-center justify-center {{ $now >= $start ? 'bg-[#FF3842] text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                </div>
                                <p class="mt-2 text-[9px] font-bold uppercase text-slate-400">Início</p>
                                <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300">{{ $start->format('d/m') }}</p>
                            </div>

                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-800 shadow-md flex items-center justify-center transition-all {{ $now > $end ? 'bg-green-500 text-white' : ($now >= $start ? 'bg-[#FF3842] text-white animate-pulse' : 'bg-slate-200 dark:bg-slate-700 text-slate-400') }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="mt-2 text-[9px] font-bold uppercase text-[#FF3842]">Prazo</p>
                                <p class="text-[10px] font-bold text-[#FF3842]">{{ $end->format('d/m H:i') }}</p>
                            </div>

                            <div class="absolute top-1/2 right-0 translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-800 shadow-sm flex items-center justify-center {{ $now >= $result ? 'bg-green-500 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="mt-2 text-[9px] font-bold uppercase text-slate-400">Resultados</p>
                                <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300">{{ $result->format('d/m') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-8 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#FF3842]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Ficha de Priorização
                    </h3>

                    @forelse($agendas as $agenda)
                        @php
                            $isOpen = $agenda->deadline > now();
                            $isCompleted = $agenda->percentual == 100;
                            // Se a relação votes existir no model User
                            $userVotes = Auth::user()->votes ? Auth::user()->votes()->whereIn('project_id', $agenda->projects->pluck('id'))->count() : 0;
                            $totalProjects = $agenda->projects->count();
                        @endphp

                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-red-100 dark:hover:border-slate-600 transition-all duration-300">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#FF3842] to-red-600"></div>

                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pl-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="bg-red-50 text-[#FF3842] text-[9px] font-bold px-2 py-0.5 rounded border border-red-100 uppercase tracking-widest">Ano {{ $agenda->year }}</span>
                                        @if($isOpen)
                                            <span class="bg-emerald-50 text-emerald-600 text-[9px] font-bold px-2 py-0.5 rounded border border-emerald-100 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aberta
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded">Encerrada</span>
                                        @endif
                                    </div>
                                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white leading-tight flex items-center gap-2">
                                        {{ $agenda->title }}
                                        <button onclick="openDetailsModal({{ json_encode($agenda) }})" class="text-slate-400 hover:text-[#FF3842] transition-colors" title="Mais Informações">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </h2>
                                </div>

                                <div class="text-right">
                                    <div class="flex items-baseline justify-end gap-1">
                                        <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $agenda->percentual }}<span class="text-sm text-slate-400">%</span></span>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Concluído</p>
                                </div>
                            </div>

                            <div class="w-full bg-slate-100 dark:bg-slate-900 rounded-full h-2 mb-6 pl-4 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-[#FF3842] to-red-600 transition-all duration-1000" style="width: {{ $agenda->percentual }}%"></div>
                            </div>

                            <div class="mb-8 pl-4">
                                @if($isOpen)
                                    <a href="{{ route('agenda.vote', $agenda->id) }}" class="flex items-center justify-center w-full py-3.5 bg-[#FF3842] hover:bg-red-700 text-white font-bold text-sm uppercase tracking-wide rounded-xl shadow-md shadow-red-500/20 transform hover:-translate-y-0.5 transition-all duration-200">
                                        @if($agenda->percentual > 0 && $agenda->percentual < 100) Continuar Votação @elseif($isCompleted) Revisar Respostas @else Iniciar Votação @endif
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                    <p class="text-center text-[10px] text-slate-400 mt-2">
                                        {{ $userVotes }} de {{ $totalProjects }} projetos analisados
                                    </p>
                                @else
                                    <button disabled class="w-full py-3.5 bg-slate-100 dark:bg-slate-700 text-slate-400 font-bold text-sm rounded-xl cursor-not-allowed uppercase">Prazo Encerrado</button>
                                @endif
                            </div>

                            <div class="border-t border-slate-100 dark:border-slate-700 pt-6 pl-4">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Central de Documentos</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300">📚 Material de Base</p>
                                        
                                        @if($agenda->file_path)
                                        <a href="{{ route('admin.agendas.download', ['id' => $agenda->id, 'type' => 'agenda']) }}" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-green-200 transition-colors group">
                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-green-700">Base Agendados</span>
                                        </a>
                                        @endif

                                        @if($agenda->file_path_remanescentes)
                                        <a href="{{ route('admin.agendas.download', ['id' => $agenda->id, 'type' => 'remanescente']) }}" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-blue-200 transition-colors group">
                                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-blue-700">Base Remanesc.</span>
                                        </a>
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300">📥 Meus Votos (Excel)</p>
                                        
                                        <a href="{{ route('agenda.export_my_votes', ['id' => $agenda->id, 'type' => 'agenda']) }}" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-green-200 transition-colors group">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-green-700">Meus Agendados</span>
                                        </a>

                                        <a href="{{ route('agenda.export_my_votes', ['id' => $agenda->id, 'type' => 'remanescente']) }}" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-blue-200 transition-colors group">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-blue-700">Meus Remanesc.</span>
                                        </a>

                                        <a href="{{ route('agenda.export_my_votes', ['id' => $agenda->id, 'type' => 'all']) }}" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-purple-200 transition-colors group">
                                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-purple-700">Completo (Todos)</span>
                                        </a>
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300">📊 Resultados Finais</p>
                                        
                                        <a href="{{ route('admin.agendas.report', $agenda->id) }}" target="_blank" class="flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-red-200 transition-colors group">
                                            <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:text-red-700">Relatório Executivo PDF</span>
                                        </a>
                                        
                                        <div class="p-2 text-[9px] text-slate-400 italic">
                                            Outros relatórios serão liberados após o encerramento.
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-[2rem] border border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-sm text-slate-500 font-medium">Nenhuma ficha de votação disponível.</p>
                        </div>
                    @endforelse
                </div>

                <div class="lg:col-span-4 space-y-6">
                    
                    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg">
                        <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Material de Apoio
                        </h3>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center p-3 rounded-xl bg-slate-50 dark:bg-slate-900 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 flex items-center justify-center shadow-sm text-orange-500 group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-orange-600">Tutorial de Votação</p>
                                    <p class="text-[9px] text-slate-400">Vídeo explicativo (2min)</p>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity backdrop-blur-sm" onclick="closeDetailsModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white dark:bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-700 p-8">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-5 w-5 text-[#FF3842]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-slate-900 dark:text-white" id="modal-title">Detalhes da Agenda</h3>
                    <div class="mt-4 text-left space-y-4">
                        <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Descrição</p>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed" id="md_desc"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-xl text-center">
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Início</p>
                                <p class="text-xs font-bold text-slate-800 dark:text-white" id="md_start"></p>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-xl text-center">
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Fim</p>
                                <p class="text-xs font-bold text-[#FF3842]" id="md_end"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="button" onclick="closeDetailsModal()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-[#FF3842] text-sm font-bold text-white hover:bg-red-700 focus:outline-none">
                        Entendi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDetailsModal(agenda) {
            document.getElementById('md_desc').innerText = agenda.description || 'Sem descrição.';
            document.getElementById('md_start').innerText = new Date(agenda.start_date).toLocaleDateString('pt-BR');
            document.getElementById('md_end').innerText = new Date(agenda.deadline).toLocaleDateString('pt-BR');
            document.getElementById('detailsModal').classList.remove('hidden');
        }
        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>

    <style>
        .bg-grid-slate-100 { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(241 245 249 / 0.5)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e"); }
        .dark .bg-grid-slate-700\/30 { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(51 65 85 / 0.3)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e"); }
    </style>
</x-app-layout>