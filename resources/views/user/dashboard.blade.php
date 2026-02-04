<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <div class="w-1 h-5 bg-gradient-to-b from-[#FF3842] to-red-600 rounded-full animate-pulse"></div>
            Painel Principal
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#0f172a] pb-20 transition-colors duration-500 overflow-x-hidden">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-8 md:py-10">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-6 animate-fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-1.5 tracking-tight">
                        Olá, {{ explode(' ', Auth::user()->name)[0] }} <span class="inline-block animate-wave origin-bottom-right">👋</span>
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-normal">Bem-vindo ao seu painel de priorização estratégica.</p>
                </div>
            </div>

            <!-- TIMELINE SECTION (Alive & Floating) -->
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

                <div class="mb-10 relative group animate-fade-in-up delay-100">
                    <!-- Glowing Background -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 via-orange-500 to-red-600 rounded-[2rem] blur opacity-20 group-hover:opacity-30 transition duration-1000 group-hover:duration-200 animate-gradient-xy"></div>
                    
                    <div class="relative bg-white dark:bg-slate-800 rounded-[1.5rem] p-6 shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                        
                        <!-- Floating Background Elements -->
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-32 h-32 bg-red-50 dark:bg-red-900/10 rounded-full blur-2xl animate-float"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-orange-50 dark:bg-orange-900/10 rounded-full blur-2xl animate-float delay-700"></div>

                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                                <div>
                                    <span class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-[10px] font-semibold uppercase tracking-wider mb-2 border border-red-100 dark:border-red-800/50">
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                        </span>
                                        Cronograma Oficial
                                    </span>
                                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                                        {{ $mainAgenda->title }}
                                    </h3>
                                </div>
                                <div class="text-right hidden md:block">
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Status Atual</p>
                                    <p class="text-base font-semibold bg-clip-text text-transparent bg-gradient-to-r from-slate-700 to-slate-900 dark:from-white dark:to-slate-300">
                                        @if($now < $start) ⏳ Em Breve
                                        @elseif($now < $end) 🔥 Votação Ativa
                                        @elseif($now < $result) 🔒 Processando
                                        @else ✅ Finalizado
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Interactive Timeline -->
                            <div class="relative h-2.5 bg-slate-100 dark:bg-slate-700 rounded-full mb-6 mx-6 md:mx-16 shadow-inner">
                                <!-- Progress Bar with Flow Animation -->
                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#FF3842] via-orange-500 to-[#FF3842] rounded-full shadow-[0_0_15px_rgba(255,56,66,0.4)] animate-gradient-x" style="width: {{ $progress }}%; background-size: 200% 100%;"></div>
                                
                                <!-- Timeline Nodes -->
                                <!-- 1. Início -->
                                <div class="absolute top-1/2 left-0 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group/node cursor-default">
                                    <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 shadow-md flex items-center justify-center transition-all duration-300 group-hover/node:scale-110 group-hover/node:border-[#FF3842] {{ $now >= $start ? '!border-[#FF3842] !bg-red-50' : '' }}">
                                        <span class="text-sm">{{ $now >= $start ? '🚀' : '📅' }}</span>
                                    </div>
                                    <div class="mt-3 text-center opacity-70 group-hover/node:opacity-100 transition-opacity transform group-hover/node:-translate-y-0.5">
                                        <p class="text-[9px] font-semibold uppercase text-slate-400">Início</p>
                                        <p class="text-[10px] font-semibold text-slate-800 dark:text-white">{{ $start->format('d/m') }}</p>
                                    </div>
                                </div>

                                <!-- 2. Prazo (Deadline) - Pulsing when active -->
                                <div class="absolute top-1/2 left-[{{ ($start->diffInSeconds($end) / $totalTime) * 100 }}%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group/node z-20 cursor-default">
                                    <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 border-[3px] border-[#FF3842] shadow-[0_0_20px_rgba(255,56,66,0.25)] flex items-center justify-center transition-all duration-300 group-hover/node:scale-110 relative {{ $now < $end && $now >= $start ? 'animate-bounce-slow' : '' }}">
                                        @if($now < $end && $now >= $start)
                                            <span class="absolute inset-0 rounded-full bg-[#FF3842] opacity-20 animate-ping"></span>
                                        @endif
                                        <span class="text-lg">🗳️</span>
                                    </div>
                                    <div class="mt-3 text-center transform group-hover/node:-translate-y-0.5 transition-transform">
                                        <p class="text-[9px] font-bold uppercase text-[#FF3842] tracking-widest">Prazo Final</p>
                                        <p class="text-xs font-bold text-slate-800 dark:text-white">{{ $end->format('d/m') }} <span class="text-[9px] text-slate-400 font-normal">as {{ $end->format('H:i') }}</span></p>
                                    </div>
                                </div>

                                <!-- 3. Resultados -->
                                <div class="absolute top-1/2 right-0 translate-x-1/2 -translate-y-1/2 flex flex-col items-center group/node cursor-default">
                                    <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 shadow-md flex items-center justify-center transition-all duration-300 group-hover/node:scale-110 group-hover/node:border-emerald-500 {{ $now >= $result ? '!border-emerald-500 !bg-emerald-50' : '' }}">
                                        <span class="text-sm">📊</span>
                                    </div>
                                    <div class="mt-3 text-center opacity-70 group-hover/node:opacity-100 transition-opacity transform group-hover/node:-translate-y-0.5">
                                        <p class="text-[9px] font-semibold uppercase text-slate-400">Resultados</p>
                                        <p class="text-[10px] font-semibold text-slate-800 dark:text-white">{{ $result->format('d/m') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                
                <!-- MAIN LIST (Cards) -->
                <div class="xl:col-span-8 space-y-6 animate-fade-in-up delay-200">
                    
                    <div class="flex items-center gap-3 mb-1">
                        <div class="p-1.5 bg-white dark:bg-slate-800 rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-[#FF3842]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800 dark:text-white">Minhas Votações</h2>
                    </div>

                    @forelse($agendas as $agenda)
                        @php
                            $isOpen = $agenda->deadline > now();
                            $isCompleted = $agenda->percentual == 100;
                            $userVotes = Auth::user()->votes ? Auth::user()->votes()->whereIn('project_id', $agenda->projects->pluck('id'))->count() : 0;
                            $totalProjects = $agenda->projects->count();
                        @endphp

                        <!-- Agenda Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-xl shadow-slate-200/40 dark:shadow-slate-900/40 border border-slate-100 dark:border-slate-700 transition-all duration-500 hover:shadow-red-500/5 hover:border-red-100 dark:hover:border-red-900/20 group relative overflow-hidden">
                            
                            <!-- Card Decoration -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 dark:bg-slate-700/10 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#FF3842] rounded-full mix-blend-multiply filter blur-3xl opacity-5 animate-blob animation-delay-2000"></div>

                            <!-- Header -->
                            <div class="relative z-10 flex flex-col md:flex-row justify-between md:items-center gap-6 mb-6">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-300 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wide border border-slate-200 dark:border-slate-600">
                                            Ano {{ $agenda->year }}
                                        </span>
                                        @if($isOpen)
                                            <span class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold px-2.5 py-1 rounded-md border border-emerald-100 dark:border-emerald-800 flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aberta
                                            </span>
                                        @else
                                            <span class="bg-slate-100 dark:bg-slate-700 text-slate-500 text-[10px] font-bold px-2.5 py-1 rounded-md">Encerrada</span>
                                        @endif
                                    </div>
                                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white leading-tight group-hover:text-[#FF3842] transition-colors cursor-default">
                                        {{ $agenda->title }}
                                    </h2>
                                </div>

                                <!-- Circular Progress (Desktop) -->
                                <div class="hidden md:flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progresso</p>
                                        <p class="text-2xl font-bold text-slate-700 dark:text-white">{{ $agenda->percentual }}<span class="text-sm">%</span></p>
                                    </div>
                                    <div class="relative w-12 h-12 group-hover:scale-105 transition-transform duration-300">
                                        <svg class="w-full h-full transform -rotate-90 drop-shadow-sm">
                                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" class="text-slate-100 dark:text-slate-700" />
                                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" stroke-dasharray="125" stroke-dashoffset="{{ 125 - (125 * $agenda->percentual / 100) }}" class="text-[#FF3842] transition-all duration-1000 ease-out" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Progress Bar -->
                            <div class="md:hidden w-full bg-slate-100 dark:bg-slate-900 rounded-full h-2 mb-6 shadow-inner overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-[#FF3842] to-orange-500 transition-all duration-1000" style="width: {{ $agenda->percentual }}%"></div>
                            </div>

                            <!-- Action Buttons Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                
                                <!-- Main Vote Action -->
                                <div class="md:col-span-7 lg:col-span-8">
                                    @if($isOpen)
                                        <a href="{{ route('agenda.vote', $agenda->id) }}" class="group/btn relative flex items-center justify-between w-full p-1 pl-5 pr-2 bg-[#FF3842] hover:bg-red-600 text-white rounded-xl shadow-lg shadow-red-500/20 overflow-hidden transition-all duration-300 hover:-translate-y-0.5">
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
                                            
                                            <div class="flex flex-col py-2">
                                                <span class="text-[9px] font-semibold uppercase tracking-wider opacity-90">Ação Principal</span>
                                                <span class="text-base font-bold uppercase tracking-wide">
                                                    @if($agenda->percentual > 0 && $agenda->percentual < 100) Continuar Votação @elseif($isCompleted) Revisar Respostas @else Iniciar Votação @endif
                                                </span>
                                            </div>
                                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm group-hover/btn:scale-105 transition-transform">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </div>
                                        </a>
                                        <p class="text-center md:text-left text-[11px] text-slate-400 mt-2 pl-2">
                                            <strong>{{ $userVotes }}</strong> projetos avaliados de <strong>{{ $totalProjects }}</strong> disponíveis.
                                        </p>
                                    @else
                                        <button disabled class="w-full py-3 bg-slate-100 dark:bg-slate-700 text-slate-400 font-bold uppercase rounded-xl cursor-not-allowed">Votação Encerrada</button>
                                    @endif
                                </div>

                                <!-- Secondary Actions -->
                                <div class="md:col-span-5 lg:col-span-4 grid grid-cols-2 gap-3">
                                    <button onclick="openDetailsModal({{ json_encode($agenda) }})" class="bg-indigo-50 dark:bg-indigo-900/10 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 p-2.5 rounded-xl border border-indigo-100 dark:border-indigo-800/30 flex flex-col items-center justify-center text-center transition-all duration-300 hover:-translate-y-0.5 group/act">
                                        <svg class="w-5 h-5 text-indigo-500 mb-1.5 group-hover/act:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-[9px] font-bold text-indigo-600 dark:text-indigo-300 uppercase">Infos</span>
                                    </button>
                                    
                                    <!-- FILE CENTER TRIGGER -->
                                    <button onclick='openDownloadsModal(@json($agenda))' class="bg-slate-50 dark:bg-slate-700/40 hover:bg-slate-100 dark:hover:bg-slate-700/80 p-2.5 rounded-xl border border-slate-200 dark:border-slate-600 flex flex-col items-center justify-center text-center transition-all duration-300 hover:-translate-y-0.5 group/act relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-gray-100 via-transparent to-transparent opacity-0 group-hover/act:opacity-100 transition-opacity"></div>
                                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300 mb-1.5 group-hover/act:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <span class="text-[9px] font-bold text-slate-700 dark:text-slate-200 uppercase whitespace-nowrap">Arquivos</span>
                                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                            <!-- Empty state illustration... -->
                             <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Tudo limpo por aqui!</h3>
                            <p class="text-sm text-slate-500 max-w-xs mx-auto">Nenhuma agenda de votação atribuída.</p>
                        </div>
                    @endforelse
                </div>

                <!-- SIDEBAR -->
                <div class="xl:col-span-4 space-y-6 animate-fade-in-up delay-300">
                     <!-- Quick Guide Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-6 shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 bg-orange-100 dark:bg-orange-900/20 rounded-full opacity-40 blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                        
                        <h3 class="text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-3 relative z-10">
                            <span class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-500 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </span>
                            Guia Rápido
                        </h3>

                        <div class="space-y-5 relative z-10">
                            <div class="flex gap-3 items-start group/step">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-slate-50 dark:bg-slate-700 text-slate-500 font-bold text-xs flex items-center justify-center border border-slate-200 dark:border-slate-600 group-hover/step:border-orange-500 group-hover/step:text-orange-500 transition-colors">1</span>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed pt-1">Acesse a <strong>Central de Arquivos</strong> para baixar o Material Base do ano.</p>
                            </div>
                            <div class="flex gap-3 items-start group/step">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-slate-50 dark:bg-slate-700 text-slate-500 font-bold text-xs flex items-center justify-center border border-slate-200 dark:border-slate-600 group-hover/step:border-orange-500 group-hover/step:text-orange-500 transition-colors">2</span>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed pt-1">Clique em <strong>Iniciar Votação</strong> para definir prioridades e estratégias.</p>
                            </div>
                            <div class="flex gap-3 items-start group/step">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-slate-50 dark:bg-slate-700 text-slate-500 font-bold text-xs flex items-center justify-center border border-slate-200 dark:border-slate-600 group-hover/step:border-orange-500 group-hover/step:text-orange-500 transition-colors">3</span>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed pt-1">Salve seu progresso e baixe um <strong>Excel dos seus votos</strong> quando quiser.</p>
                            </div>
                        </div>

                         <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-700">
                            <a href="#" class="flex items-center justify-center gap-2 text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                Assistir Tutorial (2 min)
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- DETAILS MODAL (Existing logic) -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- ... code for details modal layout (keep existing logic) ... -->
         <div class="fixed inset-0 bg-slate-900/80 transition-opacity backdrop-blur-sm" onclick="closeDetailsModal()"></div>
         <div class="flex items-center justify-center min-h-screen p-4">
             <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-lg w-full relative">
                 <h3 class="text-lg font-bold mb-4 dark:text-white">Detalhes da Agenda</h3>
                 <p id="md_desc" class="text-sm text-slate-600 dark:text-slate-300"></p>
                 <div class="mt-6 flex gap-4">
                      <div class="flex-1 bg-slate-50 dark:bg-slate-900 p-3 rounded-xl text-center">
                          <p class="text-[10px] uppercase text-slate-400 font-bold">Início</p>
                          <p id="md_start" class="font-bold dark:text-white text-sm"></p>
                      </div>
                      <div class="flex-1 bg-slate-50 dark:bg-slate-900 p-3 rounded-xl text-center">
                          <p class="text-[10px] uppercase text-slate-400 font-bold">Fim</p>
                          <p id="md_end" class="font-bold text-red-500 text-sm"></p>
                      </div>
                 </div>
                 <button onclick="closeDetailsModal()" class="mt-6 w-full py-3 bg-slate-100 dark:bg-slate-700 font-bold rounded-xl text-slate-500 text-sm hover:bg-slate-200 transition-colors">Fechar</button>
             </div>
         </div>
    </div>

    <!-- DOWNLOADS CENTRAL MODAL -->
    <div id="downloadsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="downloads-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity backdrop-blur-sm" onclick="closeDownloadsModal()"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white dark:bg-slate-800 rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-xl sm:w-full border border-slate-200 dark:border-slate-700">
                
                <!-- Modal Header -->
                <div class="bg-[#F8F9FA] dark:bg-slate-900/50 p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="w-9 h-9 rounded-lg bg-[#FF3842] text-white flex items-center justify-center shadow-md shadow-red-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </span>
                            Central de Arquivos
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 pl-12">Documentos oficiais e exportações.</p>
                    </div>
                    <button onclick="closeDownloadsModal()" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-6" id="downloadLinksContainer">
                    <!-- Links will be injected via JS -->
                </div>
                
                <div class="bg-indigo-50 dark:bg-indigo-900/10 p-3 text-center text-[10px] text-indigo-500 dark:text-indigo-400 font-bold border-t border-indigo-100 dark:border-indigo-900/20">
                    💡 Dica: Salve seus votos (Excel) frequentemente.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Details Modal
        function openDetailsModal(agenda) {
            document.getElementById('md_desc').innerText = agenda.description || 'Sem descrição.';
            document.getElementById('md_start').innerText = new Date(agenda.start_date).toLocaleDateString('pt-BR');
            document.getElementById('md_end').innerText = new Date(agenda.deadline).toLocaleDateString('pt-BR');
            document.getElementById('detailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Downloads Modal Logic - Adjusted for Delicate UI
        function openDownloadsModal(agenda) {
            const container = document.getElementById('downloadLinksContainer');
            
            // Base Routes
            const downloadBase = "{{ route('admin.agendas.download', ['id' => ':id', 'type' => ':type']) }}".replace(':id', agenda.id);
            const exportVotes = "{{ route('agenda.export_my_votes', ['id' => ':id', 'type' => ':type']) }}".replace(':id', agenda.id);
            const reportUrl = "{{ route('admin.agendas.report', ':id') }}".replace(':id', agenda.id);

            let html = '';

            // 1. MATERIAL DE BASE (Grid)
            html += `<h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">📚 Materiais de Estudo</h4>`;
            html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-3">`;
                
                if(agenda.file_path) {
                    html += `
                    <a href="${downloadBase.replace(':type', 'agenda')}" class="flex items-center p-3 bg-white dark:bg-slate-700/50 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-100 dark:border-slate-600 hover:border-[#FF3842] dark:hover:border-[#FF3842] transition-all group">
                        <div class="w-8 h-8 rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-white text-xs">Base Agendados</p>
                            <p class="text-[9px] text-slate-500">PDF Original</p>
                        </div>
                    </a>`;
                }
                
                if(agenda.file_path_remanescentes) {
                    html += `
                    <a href="${downloadBase.replace(':type', 'remanescente')}" class="flex items-center p-3 bg-white dark:bg-slate-700/50 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-100 dark:border-slate-600 hover:border-blue-500 transition-all group">
                        <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-white text-xs">Base Remanescentes</p>
                            <p class="text-[9px] text-slate-500">PDF Original</p>
                        </div>
                    </a>`;
                }

            html += `</div>`;

            // 2. MEUS VOTOS
            html += `<h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">📥 Exportar Meus Votos</h4>`;
            html += `<div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <a href="${exportVotes.replace(':type', 'agenda')}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-dashed border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Apenas Agendados</span>
                    <span class="text-[9px] text-slate-400">Excel</span>
                </a>
                <a href="${exportVotes.replace(':type', 'remanescente')}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-dashed border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Apenas Remanesc.</span>
                    <span class="text-[9px] text-slate-400">Excel</span>
                </a>
                <a href="${exportVotes.replace(':type', 'all')}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-slate-800 text-white shadow-md hover:bg-slate-700 transition-transform hover:scale-105">
                    <span class="text-[10px] font-bold">Completo (Todos)</span>
                    <span class="text-[9px] text-slate-400">Excel</span>
                </a>
            </div>`;

            // 3. RELATÓRIOS
            html += `<h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">📊 Resultado Final</h4>`;
            html += `
            <a href="${reportUrl}" target="_blank" class="flex items-center p-3 bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/20 transition-colors">
                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                         <p class="font-bold text-slate-800 dark:text-white text-xs">Relatório Executivo Geral</p>
                         <span class="text-[8px] font-bold bg-white px-1.5 py-0.5 rounded text-slate-500 uppercase border border-slate-100">PDF</span>
                    </div>
                    <p class="text-[9px] text-slate-500 mt-0.5">Disponível apenas após encerramento.</p>
                </div>
            </a>`;

            container.innerHTML = html;
            document.getElementById('downloadsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDownloadsModal() {
             document.getElementById('downloadsModal').classList.add('hidden');
             document.body.style.overflow = 'auto';
        }
    </script>
    
    <style>
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes wave { 0% { transform: rotate(0deg); } 10% { transform: rotate(14deg); } 20% { transform: rotate(-8deg); } 30% { transform: rotate(14deg); } 40% { transform: rotate(-4deg); } 50% { transform: rotate(10deg); } 60% { transform: rotate(0deg); } 100% { transform: rotate(0deg); } }
        .animate-wave { animation: wave 2.5s infinite; transform-origin: 70% 70%; }

        @keyframes blob { 0% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(30px, -50px) scale(1.1); } 66% { transform: translate(-20px, 20px) scale(0.9); } 100% { transform: translate(0px, 0px) scale(1); } }
        .animate-blob { animation: blob 10s infinite; opacity: 0.5; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        @keyframes bounce-slow { 0%, 100% { transform: translateY(-50%) scale(1); } 50% { transform: translateY(-60%) scale(1); } }
        .animate-bounce-slow { animation: bounce-slow 3s infinite; }
    </style>
</x-app-layout>