<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Configurações do Sistema
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] pb-32">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="relative">
            @csrf
            @method('PUT')

            <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 py-10">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm text-green-700 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-32">
                    
                    <div class="lg:col-span-3 space-y-4">
                        <div class="bg-white rounded-2xl shadow-sm p-4">
                            <h3 class="font-bold text-gray-400 text-xs uppercase tracking-wider mb-2 px-2">Geral</h3>
                            <a href="#" class="block px-4 py-2 bg-blue-50 text-blue-700 font-bold rounded-lg mb-1">
                                📧 Servidor de E-mail
                            </a>
                            <p class="text-xs text-gray-400 px-4 mt-2">
                                Configure aqui sua conexão com SendGrid, Brevo, Mailgun ou SMTP próprio.
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-9 space-y-8">
                        
                        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                            <div class="bg-gray-800 px-8 py-5 border-b border-gray-700 flex justify-between items-center">
                                <h3 class="text-xl font-bold text-white flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Configuração de Disparo (API / SMTP)
                                </h3>
                            </div>
                            
                            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Servidor (Host)</label>
                                    <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" placeholder="ex: smtp.sendgrid.net" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Porta</label>
                                    <input type="text" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" placeholder="587" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Criptografia</label>
                                    <select name="mail_encryption" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                        <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="null" {{ ($settings['mail_encryption'] ?? '') == 'null' ? 'selected' : '' }}>Nenhuma</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Usuário (API Key)</label>
                                    <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Senha (Secret)</label>
                                    <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                </div>

                                <div class="col-span-2 border-t border-gray-100 pt-6 mt-2 grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">E-mail do Remetente</label>
                                        <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" placeholder="nao-responda@cbic.org.br" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Nome do Remetente</label>
                                        <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'CBIDATA' }}" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-8 py-5 flex justify-between items-center">
                                <h3 class="text-xl font-bold text-white flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Modelo: Boas-vindas (Novo Usuário)
                                </h3>
                            </div>
                            
                            <div class="p-8 space-y-6">
                                <div class="bg-blue-50 p-4 rounded-lg text-sm text-blue-800 border border-blue-100">
                                    <strong>Variáveis disponíveis:</strong> Use <code>{name}</code> para o nome do usuário, <code>{email}</code> para o e-mail e <code>{password}</code> para a senha provisória.
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Assunto do E-mail</label>
                                    <input type="text" name="email_template_subject" value="{{ $settings['email_template_subject'] ?? 'Bem-vindo ao CBIDATA - Suas credenciais' }}" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Conteúdo da Mensagem</label>
                                    <textarea name="email_template_body" rows="6" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-blue-500 py-3 px-4">{{ $settings['email_template_body'] ?? "Olá {name},\n\nSeu cadastro no CBIDATA foi realizado com sucesso.\n\nLogin: {email}\nSenha Provisória: {password}\n\nAcesse em: " . url('/') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden mt-8">
                            <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-8 py-5 flex justify-between items-center">
                                <h3 class="text-xl font-bold text-white flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Texto Informativo (Tela de Votação)
                                </h3>
                            </div>
                            
                            <div class="p-8 space-y-6">
                                <div class="bg-orange-50 p-4 rounded-lg text-sm text-orange-800 border border-orange-100">
                                    Este texto aparecerá no topo da tela de votação para todos os usuários. Use HTML básico para formatar (negrito, quebras de linha).
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Conteúdo Informativo</label>
                                    <textarea name="voting_info_text" rows="15" class="w-full bg-gray-50 border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-orange-500 py-3 px-4 font-mono text-sm">{{ $settings['voting_info_text'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-white/90 backdrop-blur-md border border-gray-200 shadow-2xl rounded-full px-8 py-3 z-50 flex items-center gap-6 max-w-2xl w-[90%] justify-between transition-all hover:scale-[1.01]">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 font-bold text-sm hover:text-red-500 transition px-4 py-2">
                        VOLTAR
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold text-lg py-2.5 px-8 rounded-full shadow-lg flex items-center">
                        SALVAR CONFIGURAÇÕES
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>