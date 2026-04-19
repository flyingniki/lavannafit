<template>
  <AdminLayout title="Дашборд" :new-contacts="stats.new_contacts">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <StatCard label="Тарифы"   :value="stats.tariffs"  icon="💳" href="/admin/tariffs" />
      <StatCard label="Отзывы"   :value="stats.reviews"  icon="⭐" href="/admin/reviews" />
      <StatCard label="Результаты" :value="stats.results" icon="🏆" href="/admin/results" />
      <StatCard label="Заявки"   :value="stats.contacts" :badge="stats.new_contacts" icon="📬" href="/admin/contacts" />
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6">
      <h2 class="font-semibold text-gray-900 mb-3">Быстрые действия</h2>
      <div class="flex flex-wrap gap-3">
        <Link href="/admin/tariffs"  class="btn-secondary">+ Добавить тариф</Link>
        <Link href="/admin/reviews"  class="btn-secondary">+ Добавить отзыв</Link>
        <Link href="/admin/results"  class="btn-secondary">+ Добавить слайд</Link>
        <Link href="/admin/settings" class="btn-secondary">⚙️ Настройки сайта</Link>
        <a href="/" target="_blank" class="btn-secondary">🌐 Перейти на сайт</a>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Components/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ stats: Object });

const StatCard = {
  props: ['label', 'value', 'icon', 'href', 'badge'],
  template: `
    <a :href="href" class="bg-white rounded-2xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition-all">
      <div class="flex items-start justify-between mb-3">
        <span class="text-2xl">{{ icon }}</span>
        <span v-if="badge" class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ badge }} новых</span>
      </div>
      <p class="text-3xl font-extrabold text-gray-900">{{ value }}</p>
      <p class="text-sm text-gray-500 mt-1">{{ label }}</p>
    </a>
  `,
};
</script>

<style scoped>
@reference "tailwindcss";
.btn-secondary {
  @apply inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl text-sm font-medium text-gray-700 transition-colors;
}
</style>
