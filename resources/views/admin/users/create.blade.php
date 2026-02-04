<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <span class="w-2 h-8 bg-[#FF3842] rounded-full"></span>
            Cadastrar Novo Responsável
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F3F4F6] dark:bg-[#0f172a] min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl p-8 border border-slate-100 dark:border-slate-700">
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-red-800 dark:text-red-200">Atenção</h3>
                                    <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-8">
                        
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Dados Pessoais
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="name" value="Nome Completo" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus placeholder="Ex: João da Silva" />
                                </div>

                                <div>
                                    <x-input-label for="email" value="Email Corporativo" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required placeholder="joao@empresa.com" />
                                </div>

                                <div>
                                    <x-input-label for="telefone" value="Telefone / WhatsApp" />
                                    <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" :value="old('telefone')" placeholder="(00) 00000-0000" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Vínculo Profissional
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="associacao" value="Associação / Entidade" />
                                    <x-text-input id="associacao" name="associacao" type="text" class="mt-1 block w-full" :value="old('associacao')" placeholder="Ex: Sinduscon-SP" />
                                </div>

                                <div>
                                    <x-input-label for="cargo" value="Cargo / Função" />
                                    <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" :value="old('cargo')" placeholder="Ex: Diretor Técnico" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Credenciais
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="role" value="Nível de Acesso" />
                                    <select name="role" id="role" class="mt-1 block w-full border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm h-[42px]">
                                        <option value="user">Usuário Padrão</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="password" value="Senha Inicial" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#FF3842] to-red-600 hover:from-red-600 hover:to-red-800 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 transition transform active:scale-95">
                            Salvar Responsável
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>