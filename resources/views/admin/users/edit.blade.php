<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <span class="w-2 h-8 bg-[#FF3842] rounded-full"></span>
            Editar Responsável
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F3F4F6] dark:bg-[#0f172a] min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-green-800 dark:text-green-200 font-bold">{!! session('success') !!}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl p-8 border border-slate-100 dark:border-slate-700">
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Dados Pessoais
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="name" value="Nome Completo" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$user->name" required />
                                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="email" value="Email Corporativo" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="$user->email" required />
                                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                                </div>

                                <div>
                                    <x-input-label for="telefone" value="Telefone / WhatsApp" />
                                    <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" :value="$user->telefone" />
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
                                    <x-text-input id="associacao" name="associacao" type="text" class="mt-1 block w-full" :value="$user->associacao" />
                                </div>

                                <div>
                                    <x-input-label for="cargo" value="Cargo / Função" />
                                    <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" :value="$user->cargo" />
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
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuário Padrão</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-end">
                                    <button type="button" onclick="confirmResetPassword()" class="w-full h-[42px] flex items-center justify-center gap-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 border border-yellow-200 rounded-xl font-bold text-sm transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        Gerar Nova Senha Aleatória
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#FF3842] to-red-600 hover:from-red-600 hover:to-red-800 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 transition transform active:scale-95">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
                
                <form id="reset-password-form" action="{{ route('admin.users.reset_password', $user->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>
    </div>

    <script>
        function confirmResetPassword() {
            if(confirm('Tem certeza? Uma nova senha aleatória será gerada e exibida na tela anterior.')) {
                document.getElementById('reset-password-form').submit();
            }
        }
    </script>
</x-app-layout>