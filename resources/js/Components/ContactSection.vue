<template>
  <section id="contact" class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4">

      <div class="text-center mb-12 reveal">
        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Контакты</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3">Готова начать?</h2>
        <p class="text-gray-500 mt-3">Оставьте заявку — я свяжусь с вами в течение часа.</p>
      </div>

      <div class="grid md:grid-cols-2 gap-12 items-start">

        <!-- Form -->
        <div class="reveal bg-indigo-50 rounded-3xl p-8">
          <form @submit.prevent="submit" novalidate>
            <div v-if="success" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
              {{ success }}
            </div>

            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Ваше имя *</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  autocomplete="given-name"
                  placeholder="Анна"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-sm transition-all"
                  :class="{ 'border-red-400': errors.name }"
                />
                <p v-if="errors.name" class="mt-1 text-xs text-red-500">{{ errors.name[0] }}</p>
              </div>

              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Телефон *</label>
                <input
                  id="phone"
                  v-model="form.phone"
                  type="tel"
                  autocomplete="tel"
                  placeholder="+7 (900) 000-00-00"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-sm transition-all"
                  :class="{ 'border-red-400': errors.phone }"
                />
                <p v-if="errors.phone" class="mt-1 text-xs text-red-500">{{ errors.phone[0] }}</p>
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (необязательно)</label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  autocomplete="email"
                  placeholder="anna@email.com"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-sm transition-all"
                  :class="{ 'border-red-400': errors.email }"
                />
                <p v-if="errors.email" class="mt-1 text-xs text-red-500">{{ errors.email[0] }}</p>
              </div>
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 active:scale-95 disabled:opacity-60 text-white font-semibold py-3.5 rounded-full transition-all duration-200 flex items-center justify-center gap-2"
            >
              <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
              </svg>
              {{ loading ? 'Отправка...' : 'Записаться на пробное занятие' }}
            </button>
          </form>
        </div>

        <!-- Messenger buttons -->
        <div class="reveal space-y-4">
          <p class="text-gray-600 font-medium mb-6">Или напишите напрямую:</p>

          <a
            :href="`https://wa.me/${whatsappPhone}`"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center gap-4 p-5 rounded-2xl border border-gray-200 hover:border-green-400 hover:bg-green-50 transition-all group"
          >
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.523 5.845L.057 23.885l6.201-1.441A11.935 11.935 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.003-1.366l-.359-.213-3.72.864.934-3.613-.234-.37A9.818 9.818 0 1112 21.818z"/>
              </svg>
            </div>
            <div>
              <p class="font-semibold text-gray-900 group-hover:text-green-700">WhatsApp</p>
              <p class="text-sm text-gray-500">+7 (900) 000-00-00</p>
            </div>
          </a>

          <a
            href="https://t.me/yourusername"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center gap-4 p-5 rounded-2xl border border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-all group"
          >
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.869 4.326-2.96-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.829.941z"/>
              </svg>
            </div>
            <div>
              <p class="font-semibold text-gray-900 group-hover:text-blue-700">Telegram</p>
              <p class="text-sm text-gray-500">@yourusername</p>
            </div>
          </a>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useReveal } from '@/composables/useReveal';
useReveal();

const props = defineProps({ whatsappPhone: { type: String, default: '79000000000' } });
const whatsappPhone = computed(() => props.whatsappPhone || '79000000000');

const form    = ref({ name: '', phone: '', email: '' });
const loading = ref(false);
const errors  = ref({});
const success = ref('');

const page = usePage();

async function submit() {
  loading.value = true;
  errors.value  = {};
  success.value = '';

  try {
    const res = await fetch('/contact', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
          || page.props._token || '',
        'Accept': 'application/json',
      },
      body: JSON.stringify(form.value),
    });

    const data = await res.json();

    if (!res.ok) {
      errors.value = data.errors || {};
    } else {
      success.value = 'Спасибо! Мы свяжемся с вами в ближайшее время.';
      form.value = { name: '', phone: '', email: '' };
    }
  } catch {
    errors.value = { name: ['Ошибка сети. Пожалуйста, попробуйте ещё раз.'] };
  } finally {
    loading.value = false;
  }
}
</script>
