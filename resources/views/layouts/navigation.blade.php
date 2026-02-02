<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     x-transition:enter="transition-opacity ease-linear duration-300" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-300" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden backdrop-blur-sm">
</div>

<aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'" 
       class="fixed lg:static inset-y-0 left-0 z-50 bg-white dark:bg-[#0f172a] text-slate-800 dark:text-white shadow-2xl border-r border-slate-200 dark:border-slate-800 transition-all duration-300 flex flex-col h-full">
    
    <div class="h-20 flex items-center justify-center border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0f172a] flex-shrink-0 transition-colors duration-300 px-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden whitespace-nowrap transition-all duration-200 group w-full justify-center">
            @if(isset($settings) && $settings->logo_path)
                <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="w-10 h-10 object-contain rounded-xl shadow-sm">
            @else
                <div class="w-10 h-10 bg-gradient-to-br from-[#FF3842] to-red-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-500/30 flex-shrink-0 transform group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            @endif

            <div class="flex flex-col justify-center transition-opacity duration-200 lg:group-hover:opacity-100" 
                 :class="sidebarOpen ? 'opacity-100' : 'lg:hidden'">
                <span class="font-black text-slate-900 dark:text-white text-xl leading-none tracking-tight">CBIC</span>
                <span class="font-bold text-[#FF3842] text-[10px] uppercase tracking-[0.25em] leading-none mt-1">Agenda</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto sidebar-scroll overflow-x-hidden">
        
        <div class="mb-2 transition-opacity duration-300" :class="sidebarOpen ? 'block' : 'lg:hidden'">
            <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Principal</p>
        </div>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-[#FF3842] text-white shadow-lg shadow-red-500/30 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white font-medium' }}"
           title="Painel Geral">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path></svg>
            <span class="ml-3 whitespace-nowrap" :class="sidebarOpen ? 'block' : 'lg:hidden'">Painel Geral</span>
        </a>

        @if(Auth::user()->role === 'admin')
        <div class="mt-8 space-y-2">
            <div class="mb-2 transition-opacity duration-300" :class="sidebarOpen ? 'block' : 'lg:hidden'">
                <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Gestão</p>
            </div>
            
            <a href="{{ route('admin.agendas.index') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('admin.agendas.*') ? 'bg-[#FF3842] text-white shadow-lg shadow-red-500/30 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white font-medium' }}"
               title="Gerenciar Agendas">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="ml-3 whitespace-nowrap" :class="sidebarOpen ? 'block' : 'lg:hidden'">Agendas</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('admin.users.*') ? 'bg-[#FF3842] text-white shadow-lg shadow-red-500/30 font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white font-medium' }}"
               title="Responsáveis Técnicos">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="ml-3 whitespace-nowrap" :class="sidebarOpen ? 'block' : 'lg:hidden'">Responsáveis</span>
            </a>

            <div class="border-t border-slate-200 dark:border-slate-800 my-2 mx-3 pt-2" :class="sidebarOpen ? 'block' : 'lg:hidden'"></div>

            <a href="{{ route('admin.settings') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('admin.settings') ? 'bg-red-50 dark:bg-red-900/20 text-[#FF3842] font-bold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white font-medium' }}"
               title="Configurações">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="ml-3 whitespace-nowrap" :class="sidebarOpen ? 'block' : 'lg:hidden'">Configurações</span>
            </a>
        </div>
        @endif
    </nav>

    <div class="p-4 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex-shrink-0 transition-colors duration-300 relative">
        
        <div x-data="{ userMenu: false }" class="relative mb-4">
            <button @click="userMenu = !userMenu" class="flex items-center gap-3 w-full text-left focus:outline-none group">
                <div class="w-10 h-10 rounded-full bg-[#FF3842] flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-red-500/20 flex-shrink-0 border-2 border-white dark:border-slate-800 hover:scale-105 transition-transform">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0" :class="sidebarOpen ? 'block' : 'lg:hidden'">
                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate group-hover:text-[#FF3842] transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <div :class="sidebarOpen ? 'block' : 'lg:hidden'">
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="userMenu ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                </div>
            </button>

            <div x-show="userMenu" 
                 @click.away="userMenu = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 class="absolute bottom-full left-0 mb-3 w-full min-w-[220px] bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden z-50 origin-bottom-left"
                 :class="!sidebarOpen ? 'left-12' : ''">
                
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-[10px] text-slate-400 uppercase font-bold">Conta</p>
                    <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-[#FF3842] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Editar Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-bold border-t border-slate-100 dark:border-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Sair
                    </button>
                </form>
            </div>
        </div>

        <div class="flex items-center w-full transition-all duration-300" :class="sidebarOpen ? 'justify-between flex-row' : 'flex-col gap-4'">
            
            <button @click="toggleTheme()" class="group flex items-center gap-2" title="Alternar Tema">
                <div class="p-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm text-slate-500 dark:text-slate-400 group-hover:text-[#FF3842] transition-colors">
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </div>
                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 group-hover:text-[#FF3842] transition-colors" :class="sidebarOpen ? 'block' : 'lg:hidden'">
                    <span x-show="!darkMode">Claro</span><span x-show="darkMode">Escuro</span>
                </span>
            </button>

            <button @click="toggleSidebar()" class="hidden lg:block p-1.5 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm" title="Expandir/Recolher Menu">
                <svg class="w-4 h-4 transition-transform duration-300" :class="!sidebarOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
            </button>
        </div>

    </div>
</aside>