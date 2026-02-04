<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-600 rounded-xl shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </span>
                <div class="flex flex-col">
                    <span class="text-xs text-slate-400 uppercase font-bold tracking-wider">Painel de Monitoramento</span>
                    <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight">
                        {{ $agenda->title }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-500">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-6 md:py-10">

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl border border-red-200 dark:border-red-800 font-bold text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $totalProjetos = $agenda->projects->count();
                $qtdAgendados = $agenda->projects->where('type', 'agenda')->count();
                $qtdRemanescentes = $agenda->projects->where('type', 'remanescente')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card 1: Status -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status</span>
                        </div>
                        <div>
                             @if(now() <= $agenda->deadline)
                                <p class="text-2xl font-black text-emerald-500">Aberta</p>
                                <p class="text-[11px] font-bold text-slate-400">Votação em andamento</p>
                            @else
                                <p class="text-2xl font-black text-slate-500">Encerrada</p>
                                <p class="text-[11px] font-bold text-slate-400">Prazo finalizado</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 dark:bg-orange-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total</span>
                        </div>
                        <p class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalProjetos }}</p>
                        <div class="flex gap-3 mt-1 text-xs font-bold">
                            <span class="text-green-600">{{ $qtdAgendados }} Agendas</span>
                            <span class="text-blue-600">{{ $qtdRemanescentes }} Reman.</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Participantes -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 dark:bg-purple-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Participantes</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $usersData->count() }}</span>
                            <span class="text-sm font-bold text-purple-500">Habilitados</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Encerramento -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2.5 bg-red-50 dark:bg-red-900/30 text-[#FF3842] dark:text-red-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Encerramento</span>
                        </div>
                         <div>
                            <p class="text-2xl font-black text-[#FF3842]">{{ $agenda->deadline->format('d/m') }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $agenda->deadline->format('H:i') }}h</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-6">
                    
                    <div class="bg-white dark:bg-slate-800 p-6 md:p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Detalhes da Agenda</h3>
                        <div class="space-y-4">
                            <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl">
                                <p class="text-xs font-bold text-slate-400 uppercase">Descrição</p>
                                <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">{{ $agenda->description ?? 'Sem descrição.' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Início</p>
                                    <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $agenda->start_date ? $agenda->start_date->format('d/m/Y H:i') : '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-400 uppercase">Resultado</p>
                                    <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $agenda->results_date ? $agenda->results_date->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-6 md:p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Arquivos da Base</h3>
                        <div class="space-y-3">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-green-50/50 dark:bg-slate-900 rounded-xl border border-green-100 dark:border-slate-700 gap-3 sm:gap-0">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-100 text-green-600 p-2.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold">Base 1</p>
                                        <p class="text-sm font-bold text-slate-700 dark:text-white">Apresentados</p>
                                    </div>
                                </div>
                                @if($agenda->file_path)
                                    <a href="{{ route('admin.agendas.download', ['id' => $agenda->id, 'type' => 'agenda']) }}" class="text-xs font-bold text-white bg-green-500 hover:bg-green-600 px-4 py-2.5 rounded-lg transition-colors flex items-center justify-center gap-1 w-full sm:w-auto">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Baixar
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-slate-400 bg-slate-200 px-3 py-1 rounded">Indisponível</span>
                                @endif
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-blue-50/50 dark:bg-slate-900 rounded-xl border border-blue-100 dark:border-slate-700 gap-3 sm:gap-0">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-100 text-blue-600 p-2.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold">Base 2</p>
                                        <p class="text-sm font-bold text-slate-700 dark:text-white">Remanescentes</p>
                                    </div>
                                </div>
                                @if(!empty($agenda->file_path_remanescentes))
                                    <a href="{{ route('admin.agendas.download', ['id' => $agenda->id, 'type' => 'remanescente']) }}" class="text-xs font-bold text-white bg-blue-500 hover:bg-blue-600 px-4 py-2.5 rounded-lg transition-colors flex items-center justify-center gap-1 w-full sm:w-auto">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Baixar
                                    </a>
                                @else
                                    <span class="text-[10px] font-bold text-slate-400 bg-slate-200 px-3 py-1 rounded w-full sm:w-auto text-center cursor-help" title="Edite a agenda e reenvie o arquivo para ativar o download.">Importado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-6 md:p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Relatórios Gerenciais
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-red-200 hover:bg-red-50/30 transition-all group">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 dark:text-white text-sm">Relatório Executivo (PDF)</h4>
                                            <p class="text-[10px] text-slate-500 mt-0.5">Consolidado visual para impressão com ressalvas.</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.agendas.report', $agenda->id) }}" target="_blank" class="flex items-center justify-center w-full py-2.5 bg-slate-800 text-white text-xs font-bold rounded-lg hover:bg-slate-700 transition-colors">
                                    Visualizar PDF
                                </a>
                            </div>

                            <hr class="border-slate-100 dark:border-slate-700">
                            
                            <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Exportar Dados Respondidos (Excel)</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <a href="{{ route('admin.agendas.export', ['id' => $agenda->id, 'type' => 'apresentados']) }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-green-50 border border-green-100 hover:bg-green-100 transition-all text-center group">
                                    <div class="text-green-600 mb-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <span class="text-xs font-bold text-green-700">Apresentados</span>
                                    <span class="text-[9px] text-green-600">Somente votados</span>
                                </a>

                                <a href="{{ route('admin.agendas.export', ['id' => $agenda->id, 'type' => 'remanescentes']) }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-blue-50 border border-blue-100 hover:bg-blue-100 transition-all text-center group">
                                    <div class="text-blue-600 mb-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <span class="text-xs font-bold text-blue-700">Remanescentes</span>
                                    <span class="text-[9px] text-blue-600">Somente votados</span>
                                </a>

                                <a href="{{ route('admin.agendas.export', ['id' => $agenda->id, 'type' => 'geral']) }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-slate-100 border border-slate-200 hover:bg-slate-200 transition-all text-center group">
                                    <div class="text-slate-600 mb-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                                    <span class="text-xs font-bold text-slate-700">Geral Unificado</span>
                                    <span class="text-[9px] text-slate-500">Todos os projetos</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white dark:bg-slate-800 p-6 md:p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Progresso de Votação</h3>
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded-full">{{ $usersData->count() }} Participantes</span>
                        </div>

                        <div class="space-y-6 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                            @forelse($usersData as $userData)
                            <div class="group">
                                <div class="flex justify-between items-end mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500">
                                            {{ substr($userData->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-700 dark:text-white leading-none">{{ $userData->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-wide">{{ $userData->associacao ?? 'Empresa não informada' }}</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-sm {{ $userData->progress == 100 ? 'text-emerald-500' : 'text-slate-600 dark:text-slate-400' }}">{{ $userData->progress }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-900 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r {{ $userData->progress == 100 ? 'from-emerald-400 to-emerald-600' : 'from-blue-400 to-indigo-600' }} h-2.5 rounded-full transition-all duration-1000 group-hover:shadow-[0_0_10px_rgba(59,130,246,0.5)]" style="width: {{ $userData->progress }}%"></div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-10"><p class="text-slate-400 text-sm">Nenhum participante vinculado.</p></div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-8 shadow-xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div>
                                <h3 class="text-2xl font-bold text-white mb-2">Base de Projetos</h3>
                                <p class="text-slate-400 text-sm max-w-md">
                                    Acesse a listagem completa, utilize filtros avançados, visualize detalhes e gere PDFs individuais de cada proposição.
                                </p>
                            </div>
                            
                            <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="whitespace-nowrap px-8 py-4 bg-[#FF3842] hover:bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transition-all transform group-hover:scale-105 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                Visualizar Projetos
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
    </style>
</x-app-layout>
