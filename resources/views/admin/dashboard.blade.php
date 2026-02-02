<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
            Gestão Geral
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                
                <div class="bg-white dark:bg-slate-800 overflow-hidden rounded-2xl shadow-sm border-b-4 border-[#FF3842] p-6 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Agendas Criadas</p>
                        <p class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $stats['agendas'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 text-[#FF3842] flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden rounded-2xl shadow-sm border-b-4 border-slate-500 p-6 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Projetos na Base</p>
                        <p class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $stats['projetos'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden rounded-2xl shadow-sm border-b-4 border-emerald-500 p-6 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total de Respostas</p>
                        <p class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $stats['votos'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden rounded-2xl shadow-sm border-b-4 border-[#0f172a] p-6 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Associados</p>
                        <p class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $stats['usuarios'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-[#0f172a] dark:text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <span class="w-1 h-6 bg-[#FF3842] rounded-full"></span>
                    Visão Geral das Agendas
                </h3>
                
                <a href="{{ route('admin.agendas.index') }}" class="text-sm font-bold text-[#FF3842] hover:text-red-700 flex items-center gap-1 transition-colors">
                    Gerenciar Todas
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="divide-y divide-slate-100 dark:divide-slate-700">
                    
                    @forelse($agendas as $agenda)
                    <a href="{{ route('admin.show', $agenda->id) }}" class="block bg-white dark:bg-slate-800 p-6 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group relative overflow-hidden">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ strtotime($agenda->deadline) > time() ? 'bg-green-500' : 'bg-slate-400' }}"></div>

                        <div class="flex flex-col md:flex-row md:items-center justify-between pl-4">
                            
                            <div class="flex items-center gap-5">
                                <div class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-red-50 dark:bg-red-900/20 text-[#FF3842] border border-red-100 dark:border-red-900 flex-shrink-0">
                                    <span class="text-[10px] font-bold uppercase tracking-wide opacity-70">ANO</span>
                                    <span class="text-lg font-black leading-none">{{ $agenda->year }}</span>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800 dark:text-white group-hover:text-[#FF3842] transition-colors">
                                        {{ $agenda->title }}
                                    </h4>
                                    <div class="flex items-center gap-4 mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ date('d/m/Y', strtotime($agenda->deadline)) }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            {{ $agenda->projects_count ?? 0 }} Projetos
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0 flex items-center gap-6">
                                @if(strtotime($agenda->deadline) > time())
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                            Aberta
                                        </span>
                                        <p class="text-[10px] text-gray-400 mt-1 font-medium hidden md:block">Aceitando respostas</p>
                                    </div>
                                @else
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-600">
                                            Encerrada
                                        </span>
                                        <p class="text-[10px] text-gray-400 mt-1 font-medium hidden md:block">Prazo expirado</p>
                                    </div>
                                @endif

                                <div class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-400 group-hover:text-[#FF3842] group-hover:border-[#FF3842] group-hover:bg-red-50 dark:group-hover:bg-red-900/20 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>

                        </div>
                    </a>
                    @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Nenhuma agenda criada</h3>
                        <p class="text-slate-500 text-sm mb-6">Comece criando a primeira agenda legislativa.</p>
                        
                        <a href="{{ route('admin.create') }}" class="inline-flex items-center px-6 py-3 bg-[#FF3842] hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transition-all">
                            Criar Nova Agenda
                        </a>
                    </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</x-app-layout>