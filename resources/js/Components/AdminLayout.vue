<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <aside class="w-60 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 left-0 z-30">
      <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="text-lg font-bold text-indigo-600">FitOnline</span>
        <span class="ml-2 text-xs font-medium text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Админ</span>
      </div>

      <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <Link
          v-for="item in nav"
          :key="item.href"
          :href="item.href"
          class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-colors"
          :class="isActive(item.href)
            ? 'bg-indigo-50 text-indigo-700'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
        >
          <span class="text-base">{{ item.icon }}</span>
          {{ item.label }}
          <span
            v-if="item.badge"
            class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center"
          >{{ item.badge }}</span>
        </Link>
      </nav>

      <div class="px-4 py-4 border-t border-gray-200">
        <form @submit.prevent="logout">
          <button
            type="submit"
            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors"
          >
            <span>🚪</span> Выйти
          </button>
        </form>
      </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 ml-60 flex flex-col min-h-screen">
      <!-- Top bar -->
      <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 sticky top-0 z-20">
        <h1 class="text-base font-semibold text-gray-900">{{ title }}</h1>
      </header>

      <!-- Flash -->
      <div v-if="flash.success" class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
        {{ flash.success }}
      </div>

      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const props = defineProps({ title: String, newContacts: { type: Number, default: 0 } });

const page = usePage();
const flash = computed(() => page.props.flash ?? {});

const nav = computed(() => [
  { href: '/admin',          icon: '📊', label: 'Дашборд' },
  { href: '/admin/tariffs',  icon: '💳', label: 'Тарифы' },
  { href: '/admin/reviews',  icon: '⭐', label: 'Отзывы' },
  { href: '/admin/results',  icon: '🏆', label: 'Результаты' },
  { href: '/admin/contacts', icon: '📬', label: 'Заявки', badge: props.newContacts || null },
  { href: '/admin/settings', icon: '⚙️', label: 'Настройки' },
]);

function isActive(href) {
  const current = page.url;
  if (href === '/admin') return current === '/admin';
  return current.startsWith(href);
}

function logout() {
  router.post('/admin/logout');
}
</script>
