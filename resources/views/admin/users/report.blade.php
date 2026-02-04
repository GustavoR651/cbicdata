<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório Executivo - Gestão de Responsáveis</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        @media print {
            @page { margin: 1cm; size: A4; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            .no-print { display: none !important; }
            .break-inside-avoid { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <div class="h-2 w-full bg-gradient-to-r from-blue-900 via-blue-700 to-[#FF3842] no-print"></div>

    <div class="max-w-[1100px] mx-auto bg-white shadow-2xl min-h-screen print:shadow-none print:w-full">
        
        <div class="px-10 py-10 border-b border-slate-100 flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center text-white font-black text-xl">
                        C
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">CBIC<span class="text-[#FF3842]">DATA</span></span>
                </div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight mt-4">Relatório de Responsáveis</h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Gestão de Acesso e Engajamento</p>
            </div>
            
            <div class="text-right">
                <div class="inline-block bg-slate-100 rounded-lg px-4 py-2 border border-slate-200">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Data de Emissão</p>
                    <p class="text-base font-bold text-slate-800">{{ now()->format('d/m/Y') }} <span class="text-slate-400 font-normal">às {{ now()->format('H:i') }}</span></p>
                </div>
                <p class="text-[10px] text-slate-400 mt-2">Gerado por: {{ auth()->user()->name }}</p>
            </div>
        </div>

        <div class="px-10 py-8 bg-slate-50/50 border-b border-slate-100">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Resumo Geral</h2>
            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs text-slate-500 font-bold uppercase">Total Cadastrado</p>
                    <p class="text-2xl font-black text-blue-900 mt-1">{{ $users->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs text-slate-500 font-bold uppercase">Administradores</p>
                    <p class="text-2xl font-black text-purple-600 mt-1">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs text-slate-500 font-bold uppercase">Engajados (Votaram)</p>
                    <p class="text-2xl font-black text-emerald-600 mt-1">{{ $users->filter(fn($u) => $u->votes->isNotEmpty())->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-xs text-slate-500 font-bold uppercase">Novos (Este Mês)</p>
                    <p class="text-2xl font-black text-[#FF3842] mt-1">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
            </div>
        </div>

        <div class="p-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-900 text-white text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 rounded-tl-lg font-bold">Responsável Técnico</th>
                        <th class="px-4 py-3 font-bold">Entidade / Cargo</th>
                        <th class="px-4 py-3 font-bold text-center">Perfil</th>
                        <th class="px-4 py-3 font-bold text-center">Último Voto</th>
                        <th class="px-4 py-3 rounded-tr-lg font-bold text-right">Data Cadastro</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($users as $index => $user)
                    <tr class="border-b border-slate-100 {{ $index % 2 == 0 ? 'bg-white' : 'bg-slate-50' }} break-inside-avoid">
                        
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-800">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </td>

                        <td class="px-4 py-3">
                            @if($user->associacao)
                                <p class="font-semibold text-slate-700">{{ $user->associacao }}</p>
                                <p class="text-[10px] text-slate-400 uppercase">{{ $user->cargo ?? '-' }}</p>
                            @else
                                <span class="text-slate-400 italic text-xs">Não informado</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 rounded bg-purple-100 text-purple-700 text-[10px] font-bold uppercase border border-purple-200">Admin</span>
                            @else
                                <span class="px-2 py-1 rounded bg-slate-200 text-slate-600 text-[10px] font-bold uppercase border border-slate-300">Usuário</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($user->votes->isNotEmpty())
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-emerald-700 font-bold text-xs">{{ $user->votes->first()->created_at->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-emerald-500">{{ $user->votes->first()->created_at->format('H:i') }}</span>
                                </div>
                            @else
                                <span class="text-slate-300 text-xs font-medium">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right text-slate-600">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-10 py-6 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400 print:bg-white">
            <p>© {{ date('Y') }} CBIC - Câmara Brasileira da Indústria da Construção. Todos os direitos reservados.</p>
            <p>Documento Confidencial - Uso Interno</p>
        </div>
    </div>

    <div class="fixed bottom-8 right-8 no-print flex flex-col gap-3">
        <button onclick="window.print()" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-full shadow-xl flex items-center gap-3 transition-transform hover:scale-105 group">
            <span class="bg-white/20 p-2 rounded-full group-hover:bg-white/30 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </span>
            <div class="text-left">
                <span class="block text-[10px] font-normal opacity-80 uppercase tracking-wider">Ação</span>
                <span class="block text-sm">Imprimir Relatório</span>
            </div>
        </button>
        
        <button onclick="window.close()" class="bg-white hover:bg-slate-100 text-slate-600 font-bold py-3 px-6 rounded-full shadow-lg border border-slate-200 text-sm transition">
            Fechar
        </button>
    </div>

</body>
</html>