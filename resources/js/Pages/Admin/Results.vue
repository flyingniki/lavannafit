<template>
  <AdminLayout title="Результаты (карусель)">
    <div class="flex justify-between items-center mb-6">
      <p class="text-sm text-gray-500">Фотографии «До/После», отображаемые в карусели.</p>
      <button @click="openCreate" class="btn-primary">+ Добавить слайд</button>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="result in results"
        :key="result.id"
        class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
      >
        <div class="aspect-video bg-indigo-50 flex items-center justify-center overflow-hidden">
          <img
            v-if="result.image_url"
            :src="result.image_url"
            :alt="result.title || 'Результат'"
            class="w-full h-full object-cover"
          />
          <div v-else class="text-indigo-200 text-center p-4">
            <div class="text-4xl mb-2">🖼️</div>
            <p class="text-xs">Нет изображения</p>
          </div>
        </div>
        <div class="p-4">
          <p class="font-medium text-sm text-gray-900 truncate">{{ result.title || 'Без названия' }}</p>
          <div class="flex items-center justify-between mt-2">
            <span :class="result.is_active ? 'badge-green' : 'badge-gray'">
              {{ result.is_active ? 'Активен' : 'Скрыт' }}
            </span>
            <div class="flex gap-1">
              <button @click="openEdit(result)" class="btn-icon">✏️</button>
              <button @click="confirmDelete(result)" class="btn-icon text-red-500">🗑️</button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="!results.length" class="col-span-3 text-center py-16 text-gray-400">
        Слайды не добавлены
      </div>
    </div>

    <Modal v-if="modal" :title="editing ? 'Редактировать слайд' : 'Новый слайд'" @close="closeModal">
      <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-4">
        <Field label="Подпись (необязательно)">
          <input v-model="form.title" type="text" class="input" placeholder="До / После — Анна, -8 кг" />
        </Field>

        <Field label="Изображение">
          <div
            class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-400 transition-colors relative"
            @dragover.prevent
            @drop.prevent="onDrop"
            @click="$refs.fileInput.click()"
          >
            <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFileChange" />
            <div v-if="preview">
              <img :src="preview" class="max-h-40 mx-auto rounded-xl object-contain" />
            </div>
            <div v-else-if="editing && editing.image_url">
              <img :src="editing.image_url" class="max-h-40 mx-auto rounded-xl object-contain opacity-60" />
              <p class="text-xs text-gray-400 mt-2">Текущее изображение. Нажмите, чтобы заменить.</p>
            </div>
            <div v-else class="text-gray-400">
              <div class="text-3xl mb-2">📷</div>
              <p class="text-sm">Нажмите или перетащите файл</p>
              <p class="text-xs mt-1">PNG, JPG до 4 МБ</p>
            </div>
          </div>
        </Field>

        <div class="grid grid-cols-2 gap-4">
          <Field label="Порядок">
            <input v-model.number="form.sort_order" type="number" class="input" />
          </Field>
          <Field label="Активен">
            <label class="flex items-center gap-2 mt-2 cursor-pointer">
              <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
              <span class="text-sm text-gray-700">Отображать в карусели</span>
            </label>
          </Field>
        </div>

        <div class="flex justify-end gap-3 pt-2">
          <button type="button" @click="closeModal" class="btn-secondary">Отмена</button>
          <button type="submit" :disabled="processing" class="btn-primary">
            {{ processing ? 'Загрузка...' : 'Сохранить' }}
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

const props = defineProps({ results: Array });

const modal = ref(false);
const editing = ref(null);
const processing = ref(false);
const preview = ref(null);
const fileRef = ref(null);
const form = ref({ title: '', sort_order: 0, is_active: true, image: null });

function openCreate() {
  editing.value = null;
  form.value = { title: '', sort_order: 0, is_active: true, image: null };
  preview.value = null;
  modal.value = true;
}

function openEdit(r) {
  editing.value = r;
  form.value = { title: r.title || '', sort_order: r.sort_order, is_active: r.is_active, image: null };
  preview.value = null;
  modal.value = true;
}

function closeModal() { modal.value = false; editing.value = null; preview.value = null; }

function onFileChange(e) {
  const file = e.target.files[0];
  if (file) { form.value.image = file; preview.value = URL.createObjectURL(file); }
}

function onDrop(e) {
  const file = e.dataTransfer.files[0];
  if (file) { form.value.image = file; preview.value = URL.createObjectURL(file); }
}

function submitForm() {
  processing.value = true;
  const data = new FormData();
  data.append('title', form.value.title ?? '');
  data.append('sort_order', form.value.sort_order ?? 0);
  data.append('is_active', form.value.is_active ? '1' : '0');
  if (form.value.image) data.append('image', form.value.image);

  const url = editing.value ? `/admin/results/${editing.value.id}` : '/admin/results';

  router.post(url, data, {
    forceFormData: true,
    onSuccess: closeModal,
    onFinish: () => { processing.value = false; },
  });
}

function confirmDelete(r) {
  if (confirm('Удалить этот слайд?')) {
    router.delete(`/admin/results/${r.id}`);
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
