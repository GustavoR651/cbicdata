<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2">
            <span class="w-2 h-8 bg-[#FF3842] rounded-full"></span>
            Editar Usuário
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-32 transition-colors duration-300">
        
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">
                
                @if(session('password_reset'))
                    <div class="mb-8 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 p-4 rounded-r-xl shadow-sm flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-yellow-800 dark:text-yellow-200 font-bold">{!! session('password_reset') !!}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Dados de Acesso</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nome Completo</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">E-mail</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner" required>
                            </div>
                            
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" onclick="confirmResetPassword()" 
                                        class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/30 rounded-xl text-yellow-700 dark:text-yellow-400 font-bold text-sm hover:bg-yellow-100 dark:hover:bg-yellow-900/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    Enviar Nova Senha por E-mail
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Dados da Entidade</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Associação / Sindicato</label>
                                    <input type="text" name="associacao" value="{{ $user->associacao }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Cargo</label>
                                        <input type="text" name="cargo" value="{{ $user->cargo }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Telefone</label>
                                        <input type="text" name="telefone" value="{{ $user->telefone }}" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nível de Acesso</label>
                                    <select name="role" class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 shadow-inner">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuário Padrão</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-8">
                            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-3.5 rounded-xl transition hover:bg-slate-200 dark:hover:bg-slate-600">
                                Cancelar
                            </a>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-[#FF3842] to-red-700 hover:from-red-600 hover:to-red-800 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-red-500/30 transition-all transform active:scale-95">
                                Salvar Alterações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id="reset-password-form" action="{{ route('admin.users.reset_password', $user->id) }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>

    <script>
        function confirmResetPassword() {
            if(confirm('Tem certeza? Uma nova senha será gerada e mostrada na tela.')) {
                document.getElementById('reset-password-form').submit();
            }
        }
    </script>
</x-app-layout>