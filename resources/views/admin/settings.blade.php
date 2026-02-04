<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    
    <script src="https://cdn.tiny.cloud/1/{{ $settings['tinymce_api_key'] ?? 'no-api-key' }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.wysiwyg',
            language: 'pt_BR', 
            height: 400,
            menubar: false,
            plugins: ['link', 'lists', 'autolink', 'image', 'preview', 'code', 'table', 'wordcount'],
            toolbar: 'undo redo | blocks | bold italic forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | code',
            content_style: 'body { font-family:Inter,sans-serif; font-size:14px; color: #334155; }'
        });
    </script>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-3">
            <span class="flex items-center justify-center w-10 h-10 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </span>
            Configurações
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-20 transition-colors duration-300" x-data="{ activeTab: 'perfil' }">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold text-green-800 dark:text-green-200">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-72 flex-shrink-0">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-6">
                        <div class="p-6 bg-slate-50 dark:bg-slate-900 border-b border-slate-100 dark:border-slate-700">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Painel</h3>
                        </div>
                        <nav class="flex flex-col p-3 space-y-1">
                            
                            <button @click="activeTab = 'perfil'" 
                                    :class="activeTab === 'perfil' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold ring-1 ring-blue-200 dark:ring-blue-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                                    class="flex items-center w-full px-4 py-3.5 rounded-xl text-sm transition-all group">
                                <div :class="activeTab === 'perfil' ? 'bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 group-hover:bg-white'" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                Meu Perfil
                            </button>

                            @if(auth()->user()->role === 'admin')
                                <div class="px-4 pt-4 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sistema</div>

                                <button @click="activeTab = 'geral'" 
                                        :class="activeTab === 'geral' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold ring-1 ring-blue-200 dark:ring-blue-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                                        class="flex items-center w-full px-4 py-3.5 rounded-xl text-sm transition-all group">
                                    <div :class="activeTab === 'geral' ? 'bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 group-hover:bg-white'" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    Geral & Identidade
                                </button>

                                <button @click="activeTab = 'emails'" 
                                        :class="activeTab === 'emails' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold ring-1 ring-blue-200 dark:ring-blue-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                                        class="flex items-center w-full px-4 py-3.5 rounded-xl text-sm transition-all group">
                                    <div :class="activeTab === 'emails' ? 'bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 group-hover:bg-white'" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    Modelos de E-mail
                                </button>

                                <button @click="activeTab = 'disparos'" 
                                        :class="activeTab === 'disparos' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold ring-1 ring-blue-200 dark:ring-blue-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                                        class="flex items-center w-full px-4 py-3.5 rounded-xl text-sm transition-all group">
                                    <div :class="activeTab === 'disparos' ? 'bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 group-hover:bg-white'" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    </div>
                                    Disparos em Massa
                                </button>

                                <button @click="activeTab = 'notificacoes'" 
                                        :class="activeTab === 'notificacoes' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold ring-1 ring-blue-200 dark:ring-blue-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                                        class="flex items-center w-full px-4 py-3.5 rounded-xl text-sm transition-all group">
                                    <div :class="activeTab === 'notificacoes' ? 'bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 group-hover:bg-white'" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    </div>
                                    Notificações Automáticas
                                </button>
                            @endif
                        </nav>
                    </div>
                </div>

                <div class="flex-1">
                    
                    <div x-show="activeTab === 'perfil'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                        
                        <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Minhas Informações
                            </h3>
                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf @method('patch')
                                <div><x-input-label for="name" value="Nome Completo" /><x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required /></div>
                                <div><x-input-label for="email" value="E-mail" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required /></div>
                                <div class="flex justify-end"><x-primary-button>Salvar Alterações</x-primary-button></div>
                            </form>
                        </div>

                        <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Alterar Senha
                            </h3>
                            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                                @csrf @method('put')
                                <div><x-input-label for="current_password" value="Senha Atual" /><x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" /></div>
                                <div><x-input-label for="password" value="Nova Senha" /><x-text-input id="password" name="password" type="password" class="mt-1 block w-full" /></div>
                                <div><x-input-label for="password_confirmation" value="Confirmar Nova Senha" /><x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" /></div>
                                <div class="flex justify-end"><x-primary-button>Atualizar Senha</x-primary-button></div>
                            </form>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'admin')
                    
                    <div x-show="activeTab === 'disparos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8 border-l-[6px] border-l-blue-600">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    Novo Comunicado Geral
                                </h3>
                                <p class="text-sm text-slate-500">Envie um e-mail imediato para <b>todos os usuários ativos</b>.</p>
                            </div>
                            <form action="{{ route('admin.settings.send_notification') }}" method="POST" onsubmit="return confirm('Confirmar envio para TODOS os usuários?');">
                                @csrf
                                <div class="space-y-6">
                                    <div><x-input-label value="Assunto" /><x-text-input name="subject" class="w-full mt-1" required placeholder="Ex: Aviso Importante" /></div>
                                    <div><x-input-label value="Mensagem" /><textarea name="message" class="wysiwyg w-full"></textarea></div>
                                    <div class="flex justify-end"><button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Enviar Agora</button></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div x-show="activeTab === 'geral'" x-transition style="display: none;" class="space-y-6">
                            
                            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Configurações do Sistema
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="md:col-span-2">
                                        <x-input-label value="Nome do Sistema" />
                                        <x-text-input name="site_name" value="{{ $settings['site_name'] ?? 'CBIC Data' }}" class="w-full mt-1" />
                                    </div>
                                    <div>
                                        <x-input-label value="Fuso Horário" />
                                        <select name="site_timezone" class="w-full mt-1 bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-gray-300 rounded-xl focus:ring-blue-500">
                                            @foreach(['America/Sao_Paulo' => 'Brasília', 'America/Manaus' => 'Manaus', 'America/Belem' => 'Belém'] as $tz => $lb)
                                                <option value="{{ $tz }}" {{ ($settings['site_timezone'] ?? 'America/Sao_Paulo') == $tz ? 'selected' : '' }}>{{ $lb }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label value="Token TinyMCE (Editor)" />
                                        <x-text-input type="password" name="tinymce_api_key" value="{{ $settings['tinymce_api_key'] ?? '' }}" class="w-full mt-1" placeholder="Cole sua chave aqui" />
                                    </div>
                                </div>

                                <div x-data="imageUploader()" class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                                    <div>
                                        <x-input-label value="Logo (Recomendado: 250x70px)" class="mb-2" />
                                        <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-4 text-center hover:border-blue-500 transition relative bg-slate-50 dark:bg-slate-900">
                                            <div class="mb-3 h-20 flex items-center justify-center bg-[url('https://cdn.dribbble.com/users/2340/screenshots/1779920/media/937397e889b70b3329062d9899c9222e.png')] bg-contain">
                                                <img id="preview-logo" src="{{ isset($settings['site_logo']) ? asset('storage/'.$settings['site_logo']) : '' }}" class="h-full object-contain" style="{{ isset($settings['site_logo']) ? '' : 'display:none' }}">
                                                <span id="placeholder-logo" class="text-slate-400 text-xs" style="{{ isset($settings['site_logo']) ? 'display:none' : '' }}">Sem Logo</span>
                                            </div>
                                            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-md font-semibold text-xs text-slate-700 dark:text-slate-300 uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-600 transition shadow-sm">
                                                Selecionar & Cortar
                                                <input type="file" class="hidden" accept="image/png, image/jpeg, image/webp" @change="loadFile($event, 'logo')">
                                            </label>
                                            <input type="file" name="site_logo" id="real-input-logo" class="hidden">
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label value="Favicon (Recomendado: 32x32px)" class="mb-2" />
                                        <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-4 text-center hover:border-blue-500 transition relative bg-slate-50 dark:bg-slate-900">
                                            <div class="mb-3 h-20 flex items-center justify-center bg-[url('https://cdn.dribbble.com/users/2340/screenshots/1779920/media/937397e889b70b3329062d9899c9222e.png')] bg-contain">
                                                <img id="preview-favicon" src="{{ isset($settings['site_favicon']) ? asset('storage/'.$settings['site_favicon']) : '' }}" class="h-8 w-8 object-contain" style="{{ isset($settings['site_favicon']) ? '' : 'display:none' }}">
                                                <span id="placeholder-favicon" class="text-slate-400 text-xs" style="{{ isset($settings['site_favicon']) ? 'display:none' : '' }}">Sem Ícone</span>
                                            </div>
                                            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-md font-semibold text-xs text-slate-700 dark:text-slate-300 uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-600 transition shadow-sm">
                                                Selecionar & Cortar
                                                <input type="file" class="hidden" accept="image/png, image/jpeg, image/webp" @change="loadFile($event, 'favicon')">
                                            </label>
                                            <input type="file" name="site_favicon" id="real-input-favicon" class="hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Texto de Boas-vindas (Dashboard)</h3>
                                <div><x-input-label value="Mensagem" /><textarea name="voting_info_text" class="wysiwyg w-full">{{ $settings['voting_info_text'] ?? '' }}</textarea></div>
                            </div>
                        </div>

                        <div x-show="activeTab === 'emails'" x-transition style="display: none;" class="space-y-6">
                            
                            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">SMTP (Servidor)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div><x-input-label value="Host" /><x-text-input name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" class="w-full mt-1" /></div>
                                    <div><x-input-label value="Porta" /><x-text-input name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" class="w-full mt-1" /></div>
                                    <div><x-input-label value="Usuário" /><x-text-input name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="w-full mt-1" /></div>
                                    <div><x-input-label value="Senha" /><x-text-input name="mail_password" type="password" value="{{ $settings['mail_password'] ?? '' }}" class="w-full mt-1" /></div>
                                    <div><x-input-label value="E-mail From" /><x-text-input name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="w-full mt-1" /></div>
                                    <div><x-input-label value="Nome From" /><x-text-input name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}" class="w-full mt-1" /></div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8" x-data="{ currentEmail: 'welcome' }">
                                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Modelos de E-mail</h3>
                                    <div class="w-full md:w-72">
                                        <select x-model="currentEmail" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-300 focus:ring-blue-500">
                                            @foreach([
                                                'welcome' => 'Boas Vindas', 'reset_password' => 'Reset Senha', 'notification' => 'Notificação Padrão',
                                                'agenda_created' => 'Agenda Criada', 'agenda_ended' => 'Agenda Encerrada',
                                                'agenda_finalized' => 'Arquivo Final', 'user_reregister' => 'Recadastramento'
                                            ] as $k => $l)
                                                <option value="{{ $k }}">{{ $l }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @foreach(['welcome','reset_password','notification','agenda_created','agenda_ended','agenda_finalized','user_reregister'] as $key)
                                    <div x-show="currentEmail === '{{ $key }}'" style="display: none;">
                                        <div class="space-y-4">
                                            <div><x-input-label value="Assunto" /><x-text-input name="email_{{ $key }}_subject" value="{{ $settings['email_'.$key.'_subject'] ?? '' }}" class="w-full mt-1" /></div>
                                            <div><x-input-label value="Conteúdo HTML" /><textarea name="email_{{ $key }}_body" class="wysiwyg w-full">{{ $settings['email_'.$key.'_body'] ?? '' }}</textarea></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div x-show="activeTab === 'notificacoes'" x-transition style="display: none;" class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-700 p-8">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Gatilhos de Notificação</h3>
                            <div class="space-y-4">
                                @foreach(['notify_new_user','notify_vote_finish','notify_agenda_created','notify_agenda_ended','notify_agenda_finalized','notify_user_reregister'] as $key)
                                    <div class="flex items-center justify-between py-4 border-b border-slate-100 dark:border-slate-700">
                                        <span class="text-slate-700 dark:text-slate-300 font-bold text-sm uppercase">{{ str_replace('_', ' ', str_replace('notify_', '', $key)) }}</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="hidden" name="{{ $key }}" value="0">
                                            <input type="checkbox" name="{{ $key }}" value="1" class="sr-only peer" {{ ($settings[$key] ?? '0') == '1' ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div x-show="activeTab !== 'disparos' && activeTab !== 'perfil'" class="flex justify-end mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                            <x-primary-button class="bg-green-600 hover:bg-green-700 px-8 py-3 text-base shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Salvar Todas as Configurações
                            </x-primary-button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="cropperModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="p-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white">Ajustar Imagem</h3>
                <button onclick="closeCropper()" class="text-slate-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-4 h-[400px] bg-slate-900 flex justify-center">
                <img id="cropperImage" class="max-h-full max-w-full">
            </div>
            <div class="p-4 flex justify-end gap-3 bg-slate-50 dark:bg-slate-900 border-t border-slate-100 dark:border-slate-700">
                <button onclick="closeCropper()" class="px-4 py-2 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 rounded-lg">Cancelar</button>
                <button onclick="cropAndSave()" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700">Recortar & Usar</button>
            </div>
        </div>
    </div>

    <script>
        let cropper;
        let currentType = ''; 
        const modal = document.getElementById('cropperModal');
        const imageElement = document.getElementById('cropperImage');

        function imageUploader() {
            return {
                loadFile(event, type) {
                    const file = event.target.files[0];
                    if (file) {
                        currentType = type;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            imageElement.src = e.target.result;
                            modal.classList.remove('hidden');
                            if(cropper) cropper.destroy();
                            cropper = new Cropper(imageElement, {
                                aspectRatio: type === 'favicon' ? 1 : NaN,
                                viewMode: 1,
                                autoCropArea: 1,
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        }

        function closeCropper() {
            modal.classList.add('hidden');
            if(cropper) cropper.destroy();
        }

        function cropAndSave() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({
                width: currentType === 'favicon' ? 64 : 400,
            });

            canvas.toBlob((blob) => {
                const file = new File([blob], "cropped.webp", { type: "image/webp" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('real-input-' + currentType).files = dataTransfer.files;

                document.getElementById('preview-' + currentType).src = URL.createObjectURL(blob);
                document.getElementById('preview-' + currentType).style.display = 'block';
                document.getElementById('placeholder-' + currentType).style.display = 'none';

                closeCropper();
            }, 'image/webp');
        }
    </script>
</x-app-layout>