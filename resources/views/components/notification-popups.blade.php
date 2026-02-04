<div 
    x-data="{ 
        notifications: [],
        add(message, type = 'success') {
            const id = Date.now();
            this.notifications.push({ id, message, type });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
    @notify.window="add($event.detail.message, $event.detail.type)"
    class="fixed bottom-4 right-4 z-50 space-y-2 pointer-events-none"
>
    <!-- Server-side Flash Messages -->
    @if(session()->has('success'))
        <div x-init="add('{{ session('success') }}', 'success')"></div>
    @endif
    @if(session()->has('error'))
        <div x-init="add('{{ session('error') }}', 'error')"></div>
    @endif

    <template x-for="notification in notifications" :key="notification.id">
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="pointer-events-auto flex items-center w-full max-w-sm px-4 py-4 rounded-xl shadow-lg border"
            :class="{
                'bg-white dark:bg-slate-800 border-green-100 dark:border-green-900/30 text-green-600 dark:text-green-400': notification.type === 'success',
                'bg-white dark:bg-slate-800 border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400': notification.type === 'error',
                'bg-white dark:bg-slate-800 border-blue-100 dark:border-blue-900/30 text-blue-600 dark:text-blue-400': notification.type === 'info'
            }"
        >
            <div class="flex-shrink-0">
                <template x-if="notification.type === 'success'">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
                <template x-if="notification.type === 'error'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
            </div>
            <div class="ml-3 font-bold text-sm" x-text="notification.message"></div>
            <button @click="remove(notification.id)" class="ml-auto hover:opacity-75">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>
</div>
