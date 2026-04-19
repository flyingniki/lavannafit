<template>
  <AdminLayout title="Отзывы">
    <div class="flex justify-between items-center mb-6">
      <p class="text-sm text-gray-500">Управляйте отзывами клиентов, отображаемыми на сайте.</p>
      <button @click="openCreate" class="btn-primary">+ Добавить отзыв</button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Имя</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Город</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Отзыв</th>
            <th class="text-left px-5 py-3 font-medium text-gray-500">Активен</th>
            <th class="px-5 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-for="review in reviews" :key="review.id" class="hover:bg-gray-50 transition-colors">
            <td class="px-5 py-4 font-medium text-gray-900">{{ review.name }}</td>
            <td class="px-5 py-4 text-gray-500">{{ review.city || '—' }}</td>
            <td class="px-5 py-4 text-gray-600 max-w-xs">
              <p class="truncate">{{ review.text }}</p>
            </td>
            <td class="px-5 py-4">
              <span :class="review.is_active ? 'badge-green' : 'badge-gray'">
                {{ review.is_active ? 'Да' : 'Нет' }}
              </span>
            </td>
            <td class="px-5 py-4 flex gap-2 justify-end">
              <button @click="openEdit(review)" class="btn-icon">✏️</button>
              <button @click="confirmDelete(review)" class="btn-icon text-red-500">🗑️</button>
            </td>
          </tr>
          <tr v-if="!reviews.length">
            <td colspan="5" class="px-5 py-8 text-center text-gray-400">Отзывы не найдены</td>
          </tr>
        </tbody>
      </table>
    </div>

    <Modal v-if="modal" :title="editing ? 'Редактировать отзыв' : 'Новый отзыв'" @close="closeModal">
      <form @submit.prevent="submitForm" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <Field label="Имя *">
            <input v-model="form.name" type="text" required class="input" placeholder="Анна К." />
          </Field>
          <Field label="Город">
            <input v-model="form.city" type="text" class="input" placeholder="Москва" />
          </Field>
        </div>
        <Field label="Текст отзыва *">
          <textarea v-model="form.text" rows="4" required class="input resize-none" placeholder="Текст отзыва клиентки..." />
        </Field>
        <div class="grid grid-cols-2 gap-4">
          <Field label="Порядок">
            <input v-model.number="form.sort_order" type="number" class="input" />
          </Field>
          <Field label="Активен">
            <label class="flex items-center gap-2 mt-2 cursor-pointer">
              <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
              <span class="text-sm text-gray-700">Отображать на сайте</span>
            </label>
          </Field>
        </div>

        <div class="flex justify-end gap-3 pt-2">
          <button type="button" @click="closeModal" class="btn-secondary">Отмена</button>
          <button type="submit" :disabled="processing" class="btn-primary">
            {{ processing ? 'Сохранение...' : 'Сохранить' }}
          </button>
        </div>
      </form>
    </Modal>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/AdminLayout.vue';
import Modal from '@/Components/AdminModal.vue';
import Field from '@/Components/AdminField.vue';

const props = defineProps({ reviews: Array });

const modal = ref(false);
const editing = ref(null);
const processing = ref(false);

const emptyForm = () => ({ name: '', city: '', text: '', sort_order: 0, is_active: true });
const form = ref(emptyForm());

function openCreate() { editing.value = null; form.value = emptyForm(); modal.value = true; }
function openEdit(r) { editing.value = r; form.value = { ...r }; modal.value = true; }
function closeModal() { modal.value = false; editing.value = null; }

function submitForm() {
  processing.value = true;
  const url = editing.value ? `/admin/reviews/${editing.value.id}` : '/admin/reviews';
  const method = editing.value ? 'put' : 'post';
  router[method](url, form.value, {
    onSuccess: closeModal,
    onFinish: () => { processing.value = false; },
  });
}

function confirmDelete(r) {
  if (confirm(`Удалить отзыв от «${r.name}»?`)) {
    router.delete(`/admin/reviews/${r.id}`);
  }
}
</script>

<style scoped>
@reference "tailwindcss";
.btn-primary   { @apply inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors disabled:opacity-60; }
.btn-secondary { @apply inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors; }
.btn-icon  { @apply p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-base; }
.badge-green { @apply inline-block px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium; }
.badge-gray  { @apply inline-block px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium; }
.input { @apply w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm transition-all bg-white; }
</style>
