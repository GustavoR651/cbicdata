<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Projetos da Agenda') }}: {{ $agenda->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.agendas.dashboard', $agenda->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Painel (Estatísticas)
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F3F4F6] dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 mb-8">
                <form method="GET" action="{{ route('admin.agendas.show', $agenda->id) }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Search -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Buscar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Código, Ementa..." class="w-full pl-10 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                        </div>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Origem</label>
                        <select name="type" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                            <option value="all">Todas</option>
                            <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Apresentados</option>
                            <option value="remanescente" {{ request('type') == 'remanescente' ? 'selected' : '' }}>Remanescentes</option>
                        </select>
                    </div>

                    <!-- Interest -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Interesse</label>
                        <select name="interesse" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 dark:text-white">
                            <option value="all">Todos</option>
                            @foreach($interesses as $interesse)
                                <option value="{{ $interesse }}" {{ request('interesse') == $interesse ? 'selected' : '' }}>{{ $interesse }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg text-sm transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="px-4 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-lg text-sm hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            Limpar
                        </a>
                    </div>
                </form>
            </div>

            <!-- List -->
            <div class="space-y-4">
                @forelse($projects as $project)
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all">
                    <div class="flex flex-col md:flex-row gap-6">
                        
                        <!-- Header / Info -->
                        <div class="md:w-1/4 flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase {{ $project->type == 'agenda' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $project->type == 'agenda' ? 'Apresentado' : 'Remanescente' }}
                                </span>
                                <span class="text-xs font-mono text-slate-400">#{{ $project->id }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 dark:text-white">
                                {{ $project->codigo }}
                            </h3>
                            <div class="text-xs text-slate-500 space-y-1">
                                <p><span class="font-bold">Autor:</span> {{ $project->autor }}</p>
                                <p><span class="font-bold">Partido:</span> {{ $project->partido }}</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="md:w-2/4 flex flex-col gap-2">
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase mb-1">Ementa</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3">
                                    {{ $project->ementa }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @if($project->tema)
                                    <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-[10px] font-bold text-slate-500 uppercase">{{ $project->tema }}</span>
                                @endif
                                @if($project->interesse)
                                    <span class="px-2 py-1 bg-purple-50 dark:bg-purple-900/20 rounded text-[10px] font-bold text-purple-600 uppercase">{{ $project->interesse }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Stats / Actions -->
                        <div class="md:w-1/4 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-700 pt-4 md:pt-0 md:pl-6 flex flex-col justify-between">
                             <div class="mb-4">
                                <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Votação</h4>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $agenda->users->count() > 0 ? ($project->votes->count() / $agenda->users->count()) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $project->votes->count() }} / {{ $agenda->users->count() }}</span>
                                </div>
                             </div>
                             
                             <!-- Expandable Details (Placeholder for future) -->
                             <button type="button" class="w-full py-2 bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-lg transition-colors">
                                 Ver Detalhes
                             </button>
                        </div>

                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>Nenhum projeto encontrado para os filtros selecionados.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $projects->links() }}
            </div>

        </div>
    </div>
</x-app-layout>