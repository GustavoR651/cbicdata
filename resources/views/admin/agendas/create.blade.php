<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">Nova Agenda</h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-32 transition-colors duration-500 relative">
        
        <form id="createAgendaForm" action="{{ route('admin.agendas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8 py-10">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 p-4 rounded-xl shadow-sm animate-pulse">
                        <p class="font-bold text-sm mb-1">Ops! Verifique os erros abaixo:</p>
                        <ul class="text-xs list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-7 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Configuração Básica</h3>

                            <div class="grid grid-cols-3 gap-6 mb-6">
                                <div class="col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                        Título <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="input_title" name="title" value="{{ old('title') }}" 
                                           class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3.5 px-4 font-bold text-slate-700 dark:text-white @error('title') ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10 @enderror" 
                                           placeholder="Ex: Agenda 2026" required>
                                    @error('title')
                                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                        Ano <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="input_year" name="year" class="w-full appearance-none bg-none bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3.5 px-4 font-bold text-slate-700 dark:text-white cursor-pointer">
                                            @foreach(range(date('Y') - 1, date('Y') + 5) as $y)
                                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                    Descrição <span class="text-red-500">*</span>
                                </label>
                                <textarea id="input_description" name="description" rows="2" 
                                          class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 text-slate-600 dark:text-slate-300 resize-none @error('description') ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10 @enderror" 
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-transparent @error('start_date') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 block">Início <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_start" name="start_date" value="{{ old('start_date') }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0" required>
                                </div>
                                
                                <div class="bg-red-50 dark:bg-red-900/10 p-3 rounded-xl border border-red-100 dark:border-red-900/30 @error('deadline') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-[#FF3842] uppercase mb-1 block">Prazo Votação <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_deadline" name="deadline" value="{{ old('deadline') }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-900 dark:text-white focus:ring-0" required>
                                </div>
                                
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-transparent @error('results_date') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 block">Resultado <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_result" name="results_date" value="{{ old('results_date') }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0" required>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                @error('start_date') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                @error('deadline') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                @error('results_date') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                <p id="date_error" class="hidden text-xs text-red-500 font-bold text-center">⚠ A data final não pode ser anterior à inicial.</p>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-6">
                            <label class="relative inline-flex items-center cursor-pointer group justify-between w-full">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 dark:text-white">Agenda Principal</span>
                                    <span class="text-xs text-slate-400">Destaque no dashboard</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="input_main" name="is_main_schedule" class="sr-only peer" onchange="checkMainSchedule(this)" {{ old('is_main_schedule') ? 'checked' : '' }}>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#FF3842]"></div>
                                </div>
                            </label>
                            <hr class="border-slate-100 dark:border-slate-700">
                            <label class="relative inline-flex items-center cursor-pointer group justify-between w-full">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 dark:text-white">Permitir Edição</span>
                                    <span class="text-xs text-slate-400">Alterar voto após envio</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="input_editing" name="allow_editing" class="sr-only peer" checked>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-6">
                        
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Arquivos</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="relative group">
                                        <div class="flex items-center justify-between p-4 rounded-2xl border border-dashed @error('file_apresentados') border-red-500 bg-red-50 dark:bg-red-900/10 @else border-slate-300 dark:border-slate-600 @enderror hover:border-[#FF3842] transition-all cursor-pointer">
                                            <div class="flex items-center gap-4">
                                                <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-[#FF3842]"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                                <div>
                                                    <p class="font-bold text-sm text-slate-700 dark:text-white">Projetos Apresentados <span class="text-red-500">*</span></p>
                                                    <p class="text-[10px] text-slate-400 font-medium" id="status_file_1">Obrigatório • Aguardando arquivo...</p>
                                                    <span id="count_file_1" class="hidden text-xs font-bold text-[#FF3842]"></span>
                                                </div>
                                            </div>
                                            <div class="bg-white dark:bg-slate-700 text-xs font-bold py-1.5 px-3 rounded-lg text-slate-500 shadow-sm group-hover:text-[#FF3842]">Selecionar</div>
                                        </div>
                                        <input type="file" id="file_1" name="file_apresentados" required accept=".xlsx,.csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="checkFile(this, 'status_file_1', 'count_file_1')">
                                    </div>
                                    @error('file_apresentados') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <div class="relative group">
                                        <div class="flex items-center justify-between p-4 rounded-2xl border border-dashed @error('file_remanescentes') border-red-500 bg-red-50 dark:bg-red-900/10 @else border-slate-300 dark:border-slate-600 @enderror hover:border-blue-500 transition-all cursor-pointer">
                                            <div class="flex items-center gap-4">
                                                <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-blue-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                                                <div>
                                                    <p class="font-bold text-sm text-slate-700 dark:text-white">Projetos Remanescentes <span class="text-red-500">*</span></p>
                                                    <p class="text-[10px] text-slate-400 font-medium" id="status_file_2">Obrigatório • Aguardando arquivo...</p>
                                                    <span id="count_file_2" class="hidden text-xs font-bold text-blue-500"></span>
                                                </div>
                                            </div>
                                            <div class="bg-white dark:bg-slate-700 text-xs font-bold py-1.5 px-3 rounded-lg text-slate-500 shadow-sm group-hover:text-blue-500">Selecionar</div>
                                        </div>
                                        <input type="file" id="file_2" name="file_remanescentes" required accept=".xlsx,.csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="checkFile(this, 'status_file_2', 'count_file_2')">
                                    </div>
                                    @error('file_remanescentes') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 @error('users') ring-2 ring-red-500 @enderror">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                                    Participantes <span class="text-red-500">*</span>
                                </h3>
                                <button type="button" onclick="toggleUsers(this)" class="text-xs font-bold text-purple-500">Selecionar Todos</button>
                            </div>
                            
                            @error('users') 
                                <p class="text-red-500 text-xs font-bold mb-2">⚠ {{ $message }}</p> 
                            @enderror

                            <div class="max-h-60 overflow-y-auto custom-scrollbar space-y-2">
                                <label class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100 cursor-pointer">
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Todos os Usuários</span>
                                    <input type="checkbox" id="selectAll" class="rounded text-purple-600 focus:ring-purple-500" onchange="toggleAll(this)">
                                </label>
                                <hr class="border-slate-100 dark:border-slate-700 my-2">
                                @foreach($users as $user)
                                <label class="flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-purple-300 transition-all cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500">{{ substr($user->name, 0, 1) }}</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700 dark:text-white leading-none">{{ $user->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $user->associacao ?? 'Sem Empresa' }}</p>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" class="user-checkbox rounded text-purple-600 focus:ring-purple-500"
                                        {{ (is_array(old('users')) && in_array($user->id, old('users'))) ? 'checked' : '' }}>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="button" onclick="openConfirmationModal()" class="w-full bg-gradient-to-r from-[#FF3842] to-red-600 hover:to-red-700 text-white font-bold text-lg py-4 rounded-xl shadow-xl hover:shadow-red-500/40 hover:-translate-y-1 transition-all mt-4 flex items-center justify-center gap-2">
                            Criar Agenda
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div id="confirmationModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="relative transform overflow-hidden rounded-[2rem] bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:w-full sm:max-w-2xl opacity-0 translate-y-4 scale-95" id="modalPanel">
                        
                        <div class="bg-[#FF3842] p-6 flex items-center justify-between text-white">
                            <h3 class="text-xl font-bold flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Revisar Agenda
                            </h3>
                            <button onclick="closeConfirmationModal()" class="hover:text-red-200"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>

                        <div class="p-8 space-y-6">
                            
                            <div class="flex justify-between items-end border-b border-slate-100 dark:border-slate-700 pb-4">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold">Título da Agenda</p>
                                    <p class="text-2xl font-bold text-slate-800 dark:text-white" id="modal_title">--</p>
                                </div>
                                <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold px-3 py-1 rounded-lg" id="modal_year">--</span>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold mb-1">Descrição</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400 italic bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl" id="modal_description">Sem descrição.</p>
                            </div>

                            <div class="grid grid-cols-3 gap-4 bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl">
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold">Início</p>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200" id="modal_start">--/--/----</p>
                                </div>
                                <div class="border-x border-slate-200 dark:border-slate-700 px-4">
                                    <p class="text-[10px] text-[#FF3842] uppercase font-bold">Fim Votação</p>
                                    <p class="text-sm font-bold text-[#FF3842]" id="modal_deadline">--/--/----</p>
                                </div>
                                <div class="pl-2">
                                    <p class="text-[10px] text-slate-400 uppercase font-bold">Resultado</p>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200" id="modal_result">--/--/----</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 dark:border-slate-700" id="modal_flag_main">
                                    <div class="icon-slot"></div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Agenda Principal</p>
                                        <p class="text-sm font-bold" id="txt_main">Não</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 dark:border-slate-700" id="modal_flag_edit">
                                    <div class="icon-slot"></div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Permite Edição</p>
                                        <p class="text-sm font-bold" id="txt_edit">Não</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl text-sm">
                                <div class="space-y-1">
                                    <p><span class="font-bold text-green-600">Apresentados:</span> <span id="modal_count_1">0</span></p>
                                    <p><span class="font-bold text-blue-500">Remanescentes:</span> <span id="modal_count_2">0</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-400 uppercase font-bold">Participantes</p>
                                    <p class="text-2xl font-black text-purple-600" id="modal_users_count">0</p>
                                </div>
                            </div>

                        </div>

                        <div class="bg-slate-50 dark:bg-slate-900/50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 gap-3">
                            <button type="button" onclick="submitForm()" class="w-full justify-center rounded-xl bg-[#FF3842] px-6 py-3 text-sm font-bold text-white shadow-lg hover:bg-red-700 sm:w-auto transition-all">Confirmar e Criar</button>
                            <button type="button" onclick="closeConfirmationModal()" class="mt-3 w-full justify-center rounded-xl bg-white dark:bg-slate-700 px-6 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 sm:mt-0 sm:w-auto">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        let count1 = 0; let count2 = 0;

        function validateDates() {
            const start = document.getElementById('input_start').value;
            const end = document.getElementById('input_deadline').value;
            const result = document.getElementById('input_result').value;
            const errorMsg = document.getElementById('date_error');

            errorMsg.classList.add('hidden');

            if (start && end) {
                if (new Date(end) <= new Date(start)) {
                    document.getElementById('input_deadline').value = ""; 
                    errorMsg.innerText = "⚠ O Prazo de Votação deve ser posterior ao Início.";
                    errorMsg.classList.remove('hidden');
                }
            }
            if (end && result) {
                if (new Date(result) <= new Date(end)) {
                    document.getElementById('input_result').value = "";
                    errorMsg.innerText = "⚠ A Divulgação deve ser posterior ao Prazo de Votação.";
                    errorMsg.classList.remove('hidden');
                }
            }
        }

        function checkFile(input, statusId, countId) {
            const statusEl = document.getElementById(statusId);
            const countEl = document.getElementById(countId);
            if (!input.files[0]) return;

            statusEl.innerText = "Verificando...";
            statusEl.className = "text-[10px] text-blue-500 font-bold animate-pulse";

            const formData = new FormData();
            formData.append('file', input.files[0]);

            fetch('{{ route("admin.agendas.check_file") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    statusEl.innerText = input.files[0].name;
                    statusEl.className = "text-[10px] text-green-600 font-bold";
                    countEl.innerText = data.message;
                    countEl.classList.remove('hidden');
                    if(statusId.includes('1')) count1 = data.count;
                    if(statusId.includes('2')) count2 = data.count;
                } else {
                    statusEl.innerText = "Erro no arquivo";
                    alert(data.message);
                }
            });
        }

        function openConfirmationModal() {
            // 1. Valida Arquivos Duplicados
            const f1 = document.getElementById('file_1').value;
            const f2 = document.getElementById('file_2').value;
            if(f1 && f2 && f1 === f2) {
                alert("⚠ Erro: Você selecionou o mesmo arquivo para Apresentados e Remanescentes.");
                return;
            }

            // 2. Valida Pelo Menos 1 Usuário
            const selectedUsers = document.querySelectorAll('.user-checkbox:checked').length;
            if(selectedUsers === 0) {
                alert("⚠ Erro: Selecione pelo menos um participante para a agenda.");
                return;
            }

            // 3. Valida Campos Vazios (Manual + Required)
            const title = document.getElementById('input_title').value;
            const deadline = document.getElementById('input_deadline').value;
            const start = document.getElementById('input_start').value;
            const result = document.getElementById('input_result').value;
            const desc = document.getElementById('input_description').value;

            if(!title || !deadline || !start || !result || !desc) {
                alert("Preencha todos os campos obrigatórios.");
                return;
            }

            // Preencher Modal
            document.getElementById('modal_title').innerText = title;
            document.getElementById('modal_year').innerText = document.getElementById('input_year').value;
            document.getElementById('modal_description').innerText = desc;

            const fmt = (dateStr) => {
                if(!dateStr) return "--/--/----";
                const d = new Date(dateStr);
                return d.toLocaleDateString('pt-BR') + ' ' + d.toLocaleTimeString('pt-BR', {hour:'2-digit', minute:'2-digit'});
            };

            document.getElementById('modal_start').innerText = fmt(start);
            document.getElementById('modal_deadline').innerText = fmt(deadline);
            document.getElementById('modal_result').innerText = fmt(result);

            // Flags
            const isMain = document.getElementById('input_main').checked;
            const canEdit = document.getElementById('input_editing').checked;
            updateFlagUI('modal_flag_main', 'txt_main', isMain, 'text-green-600', 'text-slate-400');
            updateFlagUI('modal_flag_edit', 'txt_edit', canEdit, 'text-blue-600', 'text-slate-400');

            // Contagens
            document.getElementById('modal_count_1').innerText = count1 > 0 ? count1 + " proj." : "0";
            document.getElementById('modal_count_2').innerText = count2 > 0 ? count2 + " proj." : "0";
            document.getElementById('modal_users_count').innerText = selectedUsers;

            // Abrir
            const modal = document.getElementById('confirmationModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);
        }

        function updateFlagUI(divId, txtId, isActive, activeColor, inactiveColor) {
            const div = document.getElementById(divId);
            const txt = document.getElementById(txtId);
            const iconSlot = div.querySelector('.icon-slot');
            
            if(isActive) {
                txt.innerText = "Sim";
                txt.className = `text-sm font-bold ${activeColor}`;
                div.className = `flex items-center gap-3 p-3 rounded-xl border border-${activeColor.split('-')[1]}-200 bg-${activeColor.split('-')[1]}-50`;
                iconSlot.innerHTML = `<svg class="w-6 h-6 ${activeColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            } else {
                txt.innerText = "Não";
                txt.className = `text-sm font-bold ${inactiveColor}`;
                div.className = "flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50";
                iconSlot.innerHTML = `<svg class="w-6 h-6 ${inactiveColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            }
        }

        function closeConfirmationModal() {
            const modal = document.getElementById('confirmationModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function submitForm() { document.getElementById('createAgendaForm').submit(); }

        function checkMainSchedule(checkbox) {
            const hasExistingMain = @json($hasMainAgenda);
            if (checkbox.checked && hasExistingMain) {
                const conf = confirm("⚠ JÁ EXISTE UMA AGENDA PRINCIPAL.\nAo ativar esta, a anterior deixará de ser principal.\nDeseja continuar?");
                if (!conf) checkbox.checked = false;
            }
        }

        function toggleUsers(btn) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const allChecked = Array.from(checkboxes).every(c => c.checked);
            checkboxes.forEach(c => c.checked = !allChecked);
            document.getElementById('selectAll').checked = !allChecked;
            if(btn) btn.innerText = !allChecked ? "Desmarcar Todos" : "Selecionar Todos";
        }

        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(c => c.checked = source.checked);
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
    </style>
</x-app-layout>