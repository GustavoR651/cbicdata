<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Votação - {{ $agenda->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        @media print {
            body { background: white; padding: 0; }
            .no-print { display: none; }
            .page-break { page-break-inside: avoid; margin-bottom: 2rem; border: none !important; box-shadow: none !important; }
            .bg-slate-50 { background-color: #f8fafc !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 text-slate-800">

    <div class="max-w-5xl mx-auto bg-white p-12 shadow-xl rounded-3xl print:shadow-none print:max-w-none print:p-0 print:rounded-none">
        
        <!-- Header Relatório -->
        <div class="border-b-4 border-red-600 pb-6 mb-10 flex justify-between items-end">
            <div>
                <h6 class="text-sm font-bold text-red-600 uppercase tracking-widest mb-1">Relatório Executivo</h6>
                <h1 class="text-3xl font-black text-slate-900 uppercase leading-none">Monitoramento Legislativo</h1>
                <p class="text-slate-500 font-medium mt-2 text-lg">{{ $agenda->title }} • {{ $agenda->year }}</p>
            </div>
            <div class="text-right">
                <span class="block text-xs font-bold text-slate-400 uppercase">Gerado em</span>
                <span class="block font-bold text-slate-700 text-sm">{{ date('d/m/Y \à\s H:i') }}</span>
                <span class="inline-block mt-2 bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-full">Sistema CBIC Agenda</span>
            </div>
        </div>

        <div class="mb-10 no-print flex justify-end">
            <button onclick="window.print()" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Imprimir Relatório
            </button>
        </div>

        <div class="space-y-12">
            @forelse($projects as $project)
            <div class="page-break bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                
                <!-- Project Header -->
                <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded uppercase">{{ $project->type ?? 'PL' }}</span>
                            <span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">{{ $project->tema }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 mb-2">{{ $project->codigo }}</h2>
                        <p class="text-sm text-slate-600 italic font-serif leading-relaxed line-clamp-2">{{ $project->ementa }}</p>
                    </div>
                    <div class="text-right text-xs text-slate-500 space-y-1">
                        <div><strong class="text-slate-700">Autor:</strong> {{ $project->autor }}</div>
                        <div><strong class="text-slate-700">Origem:</strong> {{ $project->orgao_origem }}</div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-8">
                        
                        <!-- Coluna 1: Prioridade -->
                        <div>
                            <h4 class="text-xs font-bold text-center text-slate-400 uppercase mb-3 bg-slate-100 py-1 rounded">Prioridade</h4>
                            <div class="grid grid-cols-2 gap-2 text-center">
                                <div class="p-2 bg-purple-50 rounded-lg border border-purple-100">
                                    <span class="block text-xl font-black text-purple-700">{{ $project->stats['agenda'] }}</span>
                                    <span class="text-[10px] font-bold text-purple-400 uppercase">Agenda</span>
                                </div>
                                <div class="p-2 bg-red-50 rounded-lg border border-red-100">
                                    <span class="block text-xl font-black text-red-700">{{ $project->stats['alta'] }}</span>
                                    <span class="text-[10px] font-bold text-red-400 uppercase">Alta</span>
                                </div>
                                <div class="p-2 bg-orange-50 rounded-lg border border-orange-100">
                                    <span class="block text-xl font-black text-orange-700">{{ $project->stats['media'] }}</span>
                                    <span class="text-[10px] font-bold text-orange-400 uppercase">Média</span>
                                </div>
                                <div class="p-2 bg-green-50 rounded-lg border border-green-100">
                                    <span class="block text-xl font-black text-green-700">{{ $project->stats['baixa'] }}</span>
                                    <span class="text-[10px] font-bold text-green-400 uppercase">Baixa</span>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna 2: Posição -->
                        <div>
                            <h4 class="text-xs font-bold text-center text-slate-400 uppercase mb-3 bg-slate-100 py-1 rounded">Posição</h4>
                            <div class="grid grid-cols-2 gap-4 h-full"> <!-- h-full removed from inner elements based on previous task learning, but grid gap keeps layout -->
                                <div class="p-2 rounded-xl bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center">
                                    <span class="block text-3xl font-black text-emerald-600">{{ $project->stats['convergente'] }}</span>
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase">Convergente</span>
                                </div>
                                <div class="p-2 rounded-xl bg-red-50 border border-red-100 flex flex-col items-center justify-center">
                                    <span class="block text-3xl font-black text-red-600">{{ $project->stats['divergente'] }}</span>
                                    <span class="text-[10px] font-bold text-red-700 uppercase">Divergente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ressalvas -->
                @if($project->formatted_ressalvas->count() > 0)
                <div class="bg-yellow-50/50 p-6 border-t border-yellow-100">
                    <h4 class="text-xs font-bold text-yellow-700 uppercase mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        Observações e Ressalvas
                    </h4>
                    <ul class="space-y-3">
                        @foreach($project->formatted_ressalvas as $ressalva)
                        <li class="text-sm text-slate-700 pl-3 border-l-2 border-yellow-400 italic">
                            {!! $ressalva !!}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
            </div>
            @empty
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-slate-500 font-medium text-lg">Nenhum projeto com votação registrada nesta agenda.</p>
            </div>
            @endforelse
        </div>

    </div>
</body>