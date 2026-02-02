<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Votação - {{ $agenda->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            .page-break { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 print:bg-white print:p-0">

    <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg print:shadow-none print:max-w-none">
        
        <div class="border-b-2 border-red-500 pb-6 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 uppercase">Relatório de Votação</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $agenda->title }} ({{ $agenda->year }})</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400">Gerado em</p>
                <p class="font-bold text-gray-700">{{ date('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="mb-8 no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition">🖨️ Imprimir / Salvar PDF</button>
        </div>

        <div class="space-y-8">
            @forelse($projects as $project)
            <div class="page-break border border-gray-200 rounded-lg p-6 bg-gray-50 print:bg-white print:border-gray-300">
                
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="inline-block bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded mb-1">{{ strtoupper($project->type ?? 'PROJETO') }}</span>
                        <h3 class="text-lg font-black text-gray-800">{{ $project->codigo }}</h3>
                        <p class="text-sm text-gray-600 mt-1 italic">{{ $project->ementa }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 mb-6 text-center">
                    <div class="bg-green-100 p-2 rounded border border-green-200">
                        <span class="block text-xl font-bold text-green-700">{{ $project->stats['convergente'] }}</span>
                        <span class="text-[10px] uppercase font-bold text-green-600">Convergente</span>
                    </div>
                    <div class="bg-yellow-100 p-2 rounded border border-yellow-200">
                        <span class="block text-xl font-bold text-yellow-700">{{ $project->stats['convergente_ressalva'] }}</span>
                        <span class="text-[10px] uppercase font-bold text-yellow-600">C/ Ressalva</span>
                    </div>
                    <div class="bg-red-100 p-2 rounded border border-red-200">
                        <span class="block text-xl font-bold text-red-700">{{ $project->stats['divergente'] }}</span>
                        <span class="text-[10px] uppercase font-bold text-red-600">Divergente</span>
                    </div>
                    <div class="bg-gray-200 p-2 rounded border border-gray-300">
                        <span class="block text-xl font-bold text-gray-700">{{ $project->stats['abstencao'] }}</span>
                        <span class="text-[10px] uppercase font-bold text-gray-500">Abstenção</span>
                    </div>
                </div>

                @if($project->formatted_ressalvas->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Observações & Ressalvas</h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        @foreach($project->formatted_ressalvas as $ressalva)
                        <li class="pl-3 border-l-4 border-yellow-400 bg-white p-2 rounded shadow-sm">
                            {!! $ressalva !!}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
            @empty
            <p class="text-center text-gray-500 py-10">Nenhum projeto recebeu votos nesta agenda ainda.</p>
            @endforelse
        </div>

    </div>
</body>
</html>