<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <span class="w-2 h-8 bg-[#FF3842] rounded-full"></span>
            Novo Associado
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-32 transition-colors duration-300">
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm animate-pulse">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Ops! Encontramos alguns erros:</h3>
                                <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Acesso ao Sistema</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">E-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Senha Inicial (Opcional)</label>
                                <input type="text" name="password" placeholder="Deixe em branco para gerar aleatória" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Dados Profissionais</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Associação / Sindicato</label>
                                    <input type="text" name="associacao" value="{{ old('associacao') }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Cargo</label>
                                        <input type="text" name="cargo" value="{{ old('cargo') }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Telefone</label>
                                        <input type="text" name="telefone" value="{{ old('telefone') }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nível de Acesso</label>
                                    <div class="relative">
                                        <select name="role" class="w-full appearance-none bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                            <option value="user">Usuário Padrão (Vota e Visualiza)</option>
                                            <option value="admin">Administrador (Gestão Total)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-8">
                            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-3.5 rounded-xl transition hover:bg-slate-200 dark:hover:bg-slate-600">
                                Cancelar
                            </a>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-[#FF3842] to-red-700 hover:from-red-600 hover:to-red-800 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-red-500/30 transition-all transform active:scale-95">
                                Cadastrar Usuário
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>