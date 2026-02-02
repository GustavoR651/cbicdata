<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <span class="w-2 h-8 bg-[#FF3842] rounded-full"></span>
            Gestão de Associados
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-300">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">
            
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-700 dark:text-white">Base de Usuários</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Gerencie o acesso e permissões dos membros.</p>
                </div>

                <a href="{{ route('admin.users.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-gradient-to-r from-[#FF3842] to-red-600 rounded-xl shadow-lg shadow-red-500/30 hover:-translate-y-0.5 hover:shadow-red-500/40 focus:outline-none">
                    <svg class="w-5 h-5 mr-2 opacity-90 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Novo Associado
                </a>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
                    <p class="text-green-800 dark:text-green-200 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">
                                <th class="px-8 py-5">Nome / E-mail</th>
                                <th class="px-8 py-5">Função</th>
                                <th class="px-8 py-5">Entidade</th>
                                <th class="px-8 py-5 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-[#FF3842] flex items-center justify-center text-white font-bold mr-4 shadow-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white text-base">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-8 py-5">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800">Admin</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800">Usuário</span>
                                    @endif
                                </td>

                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $user->associacao ?? '-' }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->cargo ?? '-' }}</p>
                                </td>
                                
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <form action="{{ route('admin.users.reset_password', $user->id) }}" method="POST" onsubmit="return confirm('Gerar nova senha?');" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-yellow-500 rounded-lg transition-all" title="Resetar Senha">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-slate-400 hover:text-white hover:bg-orange-500 rounded-lg transition-all" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-red-500 rounded-lg transition-all" title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-500">Nenhum usuário encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>