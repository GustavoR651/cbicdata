<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CBIC AGENDA') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = { 
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Montserrat', sans-serif !important; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; }
        .transition-width { transition-property: width; transition-duration: 300ms; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#0f172a] text-slate-800 dark:text-gray-100 transition-colors duration-300 overflow-hidden"
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark',
          sidebarOpen: localStorage.getItem('sidebar') === 'true', 
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) document.documentElement.classList.add('dark');
              else document.documentElement.classList.remove('dark');
          },
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              localStorage.setItem('sidebar', this.sidebarOpen);
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
      :class="{ 'dark': darkMode }">
    
    <div class="flex h-screen w-full overflow-hidden">
        
        @include('layouts.navigation')

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50 dark:bg-[#0f172a] transition-colors duration-300">
            
            <header class="bg-white dark:bg-slate-800 shadow-sm h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 flex-shrink-0 transition-colors duration-300 border-b border-slate-200 dark:border-slate-800">
                
                <div class="flex items-center lg:hidden">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 dark:text-slate-300 hover:text-slate-700 focus:outline-none mr-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
                
                <div class="flex-1 flex justify-between items-center">
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white leading-tight truncate">
                        {{ $header ?? '' }}
                    </h2>

                    <div class="flex items-center gap-4">
                        <button onclick="history.back()" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#FF3842] transition-colors py-2 px-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 border border-transparent hover:border-slate-200 dark:hover:border-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span class="hidden sm:inline">Voltar</span>
                        </button>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 sm:p-8 scroll-smooth">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>