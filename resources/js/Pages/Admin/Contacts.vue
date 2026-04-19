<template>
  <AdminLayout title="Входящие заявки">
    <div class="flex justify-between items-center mb-6">
      <p class="text-sm text-gray-500">Заявки, отправленные через контактную форму на сайте.</p>
      <span v-if="unread > 0" class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
        {{ unread }} непрочитанных
      </span>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Имя</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Телефон</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Email</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Дата</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Статус</th>
            <th class="px-5 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr
            v-for="contact in contacts"
            :key="contact.id"
            class="transition-colors"
            :class="contact.is_read ? 'hover:bg-gray-50' : 'bg-indigo-50/40 hover:bg-indigo-50/60 font-medium'"
          >
            <td class="px-5 py-4 text-gray-900">{{ contact.name }}</td>
            <td class="px-5 py-4">
              <a :href="`tel:${contact.phone}`" class="text-indigo-600 hover:underline">{{ contact.phone }}</a>
            </td>
            <td class="px-5 py-4 text-gray-600">
              <a v-if="contact.email" :href="`mailto:${contact.email}`" class="hover:underline">{{ contact.email }}</a>
              <span v-else class="text-gray-400">—</span>
            </td>
            <td class="px-5 py-4 text-gray-500 whitespace-nowrap">{{ formatDate(contact.created_at) }}</td>
            <td class="px-5 py-4">
              <span :class="contact.is_read ? 'badge-gray' : 'badge-blue'">
                {{ contact.is_read ? 'Прочитано' : 'Новая' }}
              </span>
            </td>
            <td class="px-5 py-4 flex gap-2 justify-end">
              <button
                v-if="!contact.is_read"
                @click="markRead(contact)"
                class="btn-icon"
                title="Отметить прочитанным"
              >✅</button>
              <button @click="confirmDelete(contact)" class="btn-icon text-red-500">🗑️</button>
            </td>
          </tr>
          <tr v-if="!contacts.length">
            <td colspan="6" class="px-5 py-10 text-center text-gray-400">Заявок пока нет</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/AdminLayout.vue';

const props = defineProps({ contacts: Array });

const unread = computed(() => props.contacts.filter(c => !c.is_read).length);

function formatDate(str) {
  return new Date(str).toLocaleString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function markRead(c) {
  router.patch(`/admin/contacts/${c.id}/read`);
}

function confirmDelete(c) {
  if (confirm(`Удалить заявку от «${c.name}»?`)) {
    router.delete(`/admin/contacts/${c.id}`);
  }
}
</script>

<style scoped>
@reference "tailwindcss";
.btn-icon  { @apply p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-base; }
.badge-gray { @apply inline-block px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium; }
.badge-blue { @apply inline-block px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium; }
</style>
