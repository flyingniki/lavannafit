<template>
  <AdminLayout title="Настройки сайта">
    <form @submit.prevent="save" class="space-y-8 max-w-2xl">

      <!-- SEO -->
      <Section title="SEO">
        <Field label="SEO-заголовок страницы">
          <input v-model="form.seo_title" type="text" class="input" />
        </Field>
        <Field label="SEO-описание (meta description)">
          <textarea v-model="form.seo_description" rows="3" class="input resize-none" />
        </Field>
      </Section>

      <!-- Hero -->
      <Section title="Главный экран (Hero)">
        <Field label="Бейдж (метка над заголовком)">
          <input v-model="form.hero_badge" type="text" class="input" placeholder="🏋️ Онлайн-ведение по всей России" />
        </Field>
        <Field label="Заголовок">
          <textarea v-model="form.hero_title" rows="2" class="input resize-none" placeholder="Твоё тело изменится.&#10;Навсегда." />
        </Field>
        <Field label="Подзаголовок">
          <textarea v-model="form.hero_subtitle" rows="3" class="input resize-none" />
        </Field>
        <Field label="Текст кнопки CTA">
          <input v-model="form.hero_cta" type="text" class="input" placeholder="Записаться на пробное занятие" />
        </Field>
      </Section>

      <!-- Stats -->
      <Section title="Статистика (Hero)">
        <div class="grid grid-cols-2 gap-4">
          <Field label="Клиентов">
            <input v-model="form.stat_clients" type="text" class="input" placeholder="200+" />
          </Field>
          <Field label="Лет опыта">
            <input v-model="form.stat_years" type="text" class="input" placeholder="5 лет" />
          </Field>
        </div>
      </Section>

      <!-- About -->
      <Section title="Раздел «Обо мне»">
        <Field label="Имя тренера">
          <input v-model="form.trainer_name" type="text" class="input" placeholder="Мария Иванова" />
        </Field>
        <Field label="Фото тренера">
          <div class="space-y-3">
            <div class="w-36 h-36 rounded-2xl bg-indigo-50 border border-gray-200 overflow-hidden flex items-center justify-center">
              <img
                v-if="aboutPhotoPreview"
                :src="aboutPhotoPreview"
                alt="Фото тренера"
                class="w-full h-full object-cover"
              />
              <span v-else class="text-indigo-300 text-xs">Нет фото</span>
            </div>
            <input type="file" accept="image/*" @change="onAboutPhotoChange" class="input cursor-pointer" />
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
              <input v-model="form.remove_about_photo" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
              Удалить текущее фото
            </label>
          </div>
        </Field>
        <div class="grid grid-cols-2 gap-4">
          <Field label="Опыт (бейдж возле фото)">
            <input v-model="form.about_experience_years" type="text" class="input" placeholder="5+" />
          </Field>
          <div></div>
        </div>
        <Field label="Заголовок блока «Обо мне»">
          <textarea v-model="form.about_title" rows="2" class="input resize-none" />
        </Field>
        <Field label="Первый абзац">
          <textarea v-model="form.about_text1" rows="3" class="input resize-none" />
        </Field>
        <Field label="Второй абзац">
          <textarea v-model="form.about_text2" rows="3" class="input resize-none" />
        </Field>
        <Field label="Достижения (каждое с новой строки)">
          <textarea v-model="form.about_achievements" rows="5" class="input resize-none" placeholder="Сертифицированный тренер\nБолее 200 клиентов\nИндивидуальный подход" />
        </Field>
      </Section>

      <!-- Contacts -->
      <Section title="Контакты">
        <Field label="Номер WhatsApp (только цифры, с кодом страны)">
          <input v-model="form.whatsapp_phone" type="text" class="input" placeholder="79001234567" />
        </Field>
      </Section>

      <div class="flex items-center gap-4">
        <button type="submit" :disabled="processing" class="btn-primary">
          {{ processing ? 'Сохранение...' : 'Сохранить настройки' }}
        </button>
        <p v-if="saved" class="text-sm text-green-600 font-medium">✅ Сохранено!</p>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/AdminLayout.vue';
import Field from '@/Components/AdminField.vue';
import Section from '@/Components/AdminSettingsSection.vue';

const props = defineProps({ settings: Object });

const form = reactive({
  ...props.settings,
  remove_about_photo: false,
});
const processing = ref(false);
const saved = ref(false);
const aboutPhotoFile = ref(null);
const aboutPhotoPreview = ref(props.settings?.about_photo_url ?? null);

function onAboutPhotoChange(event) {
  const file = event.target.files?.[0];
  if (!file) return;
  aboutPhotoFile.value = file;
  aboutPhotoPreview.value = URL.createObjectURL(file);
  form.remove_about_photo = false;
}

function save() {
  processing.value = true;
  saved.value = false;

  const payload = new FormData();
  Object.entries(form).forEach(([key, value]) => {
    if (key === 'about_photo_url') return;
    payload.append(key, value ?? '');
  });

  payload.set('remove_about_photo', form.remove_about_photo ? '1' : '0');

  if (aboutPhotoFile.value) {
    payload.append('about_photo', aboutPhotoFile.value);
  }

  router.post('/admin/settings', payload, {
    forceFormData: true,
    onSuccess: () => { saved.value = true; setTimeout(() => { saved.value = false; }, 3000); },
    onFinish: () => { processing.value = false; },
  });
}

</script>

<style scoped>
@reference "tailwindcss";
.btn-primary { @apply inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors disabled:opacity-60; }
.input { @apply w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm transition-all bg-white; }
</style>
