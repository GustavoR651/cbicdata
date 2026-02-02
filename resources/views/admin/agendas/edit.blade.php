<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
            Editar: <span class="text-[#FF3842]">{{ $agenda->title }}</span>
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F3F4F6] dark:bg-[#0f172a] pb-32 transition-colors duration-500">
        <form id="editAgendaForm" action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            
            <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8 py-10">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 p-4 rounded-xl shadow-sm animate-pulse">
                        <p class="font-bold text-sm mb-1">Por favor, corrija os erros abaixo:</p>
                        <ul class="text-xs list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                            
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-10 h-10 rounded-full bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Editar Informações</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div class="md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                        Título <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title" value="{{ old('title', $agenda->title) }}" 
                                           class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3.5 px-4 font-bold text-slate-700 dark:text-white transition-all @error('title') ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10 @enderror" 
                                           required>
                                    @error('title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                        Ano <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="year" class="w-full appearance-none bg-none bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3.5 px-4 pr-10 font-bold text-slate-700 dark:text-white cursor-pointer transition-all">
                                            @foreach(range(date('Y') - 5, date('Y') + 5) as $y)
                                                <option value="{{ $y }}" {{ $y == $agenda->year ? 'selected' : '' }}>{{ $y }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block pl-1">
                                    Descrição <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" rows="2" 
                                          class="w-full bg-slate-50 dark:bg-slate-900 border-0 rounded-xl focus:ring-2 focus:ring-[#FF3842] py-3 px-4 text-slate-600 dark:text-slate-300 resize-none transition-all @error('description') ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10 @enderror" 
                                          required>{{ old('description', $agenda->description) }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-transparent @error('start_date') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 block">Início <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_start" name="start_date" value="{{ $agenda->start_date ? $agenda->start_date->format('Y-m-d\TH:i') : '' }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0" required>
                                </div>
                                
                                <div class="bg-red-50 dark:bg-red-900/10 p-3 rounded-xl border border-red-100 dark:border-red-900/30 @error('deadline') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-[#FF3842] uppercase mb-1 block">Prazo Votação <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_deadline" name="deadline" value="{{ $agenda->deadline->format('Y-m-d\TH:i') }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-900 dark:text-white focus:ring-0" required>
                                </div>
                                
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-transparent @error('results_date') ring-2 ring-red-500 @enderror">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase mb-1 block">Resultado <span class="text-red-500">*</span></label>
                                    <input type="datetime-local" id="input_result" name="results_date" value="{{ $agenda->results_date ? $agenda->results_date->format('Y-m-d\TH:i') : '' }}" onchange="validateDates()" class="w-full bg-transparent border-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0" required>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                @error('start_date') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                @error('deadline') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                @error('results_date') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                                <p id="date_error" class="hidden text-xs text-red-500 font-bold mt-2 text-center">⚠ A data final não pode ser anterior à inicial.</p>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 @error('users') ring-2 ring-red-500 @enderror">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                    <span class="bg-purple-50 dark:bg-purple-900/20 text-purple-500 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
                                    Participantes <span class="text-red-500">*</span>
                                </h3>
                                <button type="button" onclick="toggleUsers(this)" class="text-xs font-bold text-purple-500 hover:text-purple-700">Selecionar Todos</button>
                            </div>
                            
                            @error('users') <p class="text-red-500 text-xs font-bold mb-2">⚠ {{ $message }}</p> @enderror
                            
                            <div class="max-h-60 overflow-y-auto pr-2 custom-scrollbar space-y-2">
                                <label class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100 cursor-pointer">
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Todos os Usuários</span>
                                    <input type="checkbox" id="selectAll" class="rounded text-purple-600 focus:ring-purple-500" onchange="toggleAll(this)">
                                </label>
                                <hr class="border-slate-100 dark:border-slate-700 my-2">

                                @foreach($users as $user)
                                <label class="flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-purple-300 hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-all cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500">{{ substr($user->name, 0, 1) }}</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700 dark:text-white leading-none">{{ $user->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $user->associacao ?? 'Sem Empresa' }}</p>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" class="user-checkbox rounded text-purple-600 w-5 h-5 focus:ring-purple-500" {{ in_array($user->id, $selectedUsers) ? 'checked' : '' }}>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        
                        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-6">
                            <label class="relative inline-flex items-center cursor-pointer group justify-between w-full">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-[#FF3842] transition-colors">Agenda Principal</span>
                                    <span class="text-xs text-slate-400">Exibir destaque no dashboard</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" name="is_main_schedule" class="sr-only peer" onchange="checkMainSchedule(this)" {{ $agenda->is_main_schedule ? 'checked' : '' }}>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-[#FF3842] shadow-inner"></div>
                                </div>
                            </label>
                            <hr class="border-slate-100 dark:border-slate-700">
                            <label class="relative inline-flex items-center cursor-pointer group justify-between w-full">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-blue-500 transition-colors">Permitir Edição</span>
                                    <span class="text-xs text-slate-400">Usuário pode alterar voto</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" name="allow_editing" class="sr-only peer" {{ $agenda->allow_editing ? 'checked' : '' }}>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-500 shadow-inner"></div>
                                </div>
                            </label>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/10 p-6 rounded-[2rem] border border-blue-100 dark:border-blue-800 space-y-4">
                            <div>
                                <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">Atualizar Arquivos?</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Se não selecionar, os atuais serão mantidos.</p>
                            </div>
                            
                            <div class="relative group">
                                <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-slate-800 border border-blue-200 dark:border-slate-600 hover:border-blue-500 cursor-pointer">
                                    <div>
                                        <p class="font-bold text-xs text-slate-700 dark:text-white">Apresentados</p>
                                        <p class="text-[10px] text-slate-400" id="status_file_1">Manter atual</p>
                                        <span id="count_file_1" class="hidden text-[10px] font-bold text-green-600"></span>
                                    </div>
                                    <div class="text-[10px] font-bold text-blue-500">Alterar</div>
                                </div>
                                <input type="file" id="file_1" name="file_apresentados" accept=".xlsx,.csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileChange(this, 'status_file_1', 'count_file_1')">
                            </div>
                            @error('file_apresentados') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror

                            <div class="relative group">
                                <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-slate-800 border border-blue-200 dark:border-slate-600 hover:border-blue-500 cursor-pointer">
                                    <div>
                                        <p class="font-bold text-xs text-slate-700 dark:text-white">Remanescentes</p>
                                        <p class="text-[10px] text-slate-400" id="status_file_2">Manter atual</p>
                                        <span id="count_file_2" class="hidden text-[10px] font-bold text-green-600"></span>
                                    </div>
                                    <div class="text-[10px] font-bold text-blue-500">Alterar</div>
                                </div>
                                <input type="file" id="file_2" name="file_remanescentes" accept=".xlsx,.csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileChange(this, 'status_file_2', 'count_file_2')">
                            </div>
                            @error('file_remanescentes') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('admin.agendas.index') }}" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-xl text-center hover:bg-slate-200 transition-colors">Cancelar</a>
                            <button type="submit" class="flex-1 py-4 bg-[#FF3842] hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition-all">Salvar</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        // Validação no Envio (Frontend)
        function validateForm() {
            // Valida Usuários
            const users = document.querySelectorAll('.user-checkbox:checked').length;
            if(users === 0) {
                alert("⚠ Erro: Selecione pelo menos um participante para a agenda.");
                return false;
            }
            
            // Valida Arquivos Duplicados (se ambos forem alterados)
            const f1 = document.getElementById('file_1').value;
            const f2 = document.getElementById('file_2').value;
            if(f1 && f2 && f1 === f2) {
                alert("⚠ Erro: Os arquivos de Apresentados e Remanescentes não podem ser iguais.");
                return false;
            }
            return true;
        }

        // Validação de Datas
        function validateDates() {
            const start = document.getElementById('input_start').value;
            const end = document.getElementById('input_deadline').value;
            const result = document.getElementById('input_result').value;
            const errorMsg = document.getElementById('date_error');

            errorMsg.classList.add('hidden');

            if (start && end && new Date(end) <= new Date(start)) {
                document.getElementById('input_deadline').value = ""; 
                errorMsg.innerText = "⚠ O Prazo de Votação deve ser posterior ao Início.";
                errorMsg.classList.remove('hidden');
            }
            if (end && result && new Date(result) <= new Date(end)) {
                document.getElementById('input_result').value = "";
                errorMsg.innerText = "⚠ A Divulgação deve ser posterior ao Prazo de Votação.";
                errorMsg.classList.remove('hidden');
            }
        }

        // --- FUNÇÃO CRÍTICA: ALERTA DE PERDA DE VOTOS ---
        function handleFileChange(input, statusId, countId) {
            if(input.files && input.files[0]) {
                const confirmChange = confirm("⚠️ ATENÇÃO: SUBSTITUIÇÃO DE ARQUIVO\n\nAo enviar um novo arquivo, todos os projetos antigos desta categoria e os VOTOS já realizados neles serão EXCLUÍDOS PERMANENTEMENTE e reiniciados.\n\nTem certeza que deseja substituir o arquivo atual?");
                
                if (!confirmChange) {
                    input.value = ''; // Limpa o input se cancelar
                    return;
                }
                
                // Se confirmou, segue para verificação
                checkFile(input, statusId, countId);
            }
        }

        function checkFile(input, statusId, countId) {
            const statusEl = document.getElementById(statusId);
            const countEl = document.getElementById(countId);
            
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
                    statusEl.className = "text-[10px] text-slate-500 font-bold truncate max-w-[150px]";
                    countEl.innerText = data.message;
                    countEl.classList.remove('hidden');
                } else {
                    statusEl.innerText = "Erro!";
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        }

        function checkMainSchedule(checkbox) {
            const hasExistingMain = @json($hasMainAgenda);
            if (checkbox.checked && hasExistingMain) {
                const confirmation = confirm("⚠️ ATENÇÃO: Já existe uma Agenda Principal ativa.\n\nAo ativar esta opção, a agenda anterior deixará de ser a principal.\n\nDeseja continuar?");
                if (!confirmation) { checkbox.checked = false; }
            }
        }

        function toggleUsers(btn) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const allChecked = Array.from(checkboxes).every(c => c.checked);
            checkboxes.forEach(c => c.checked = !allChecked);
            
            const selectAll = document.getElementById('selectAll');
            if(selectAll) selectAll.checked = !allChecked;

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