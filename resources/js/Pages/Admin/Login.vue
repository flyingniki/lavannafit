<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-pink-50 flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
      <div class="text-center mb-8">
        <span class="text-3xl font-extrabold text-indigo-600">FitOnline</span>
        <p class="text-gray-500 text-sm mt-2">Вход в панель управления</p>
      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form @submit.prevent="submit">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input
                v-model="form.email"
                type="email"
                autocomplete="email"
                required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm transition-all"
                :class="{ 'border-red-400': errors.email }"
              />
              <p v-if="errors.email" class="mt-1 text-xs text-red-500">{{ errors.email }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
              <input
                v-model="form.password"
                type="password"
                autocomplete="current-password"
                required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm transition-all"
                :class="{ 'border-red-400': errors.password }"
              />
              <p v-if="errors.password" class="mt-1 text-xs text-red-500">{{ errors.password }}</p>
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
              <input v-model="form.remember" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
              Запомнить меня
            </label>
          </div>

          <button
            type="submit"
            :disabled="processing"
            class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors disabled:opacity-60"
          >
            {{ processing ? 'Входим...' : 'Войти' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const errors = computed(() => page.props.errors ?? {});

const form = ref({ email: '', password: '', remember: false });
const processing = ref(false);

function submit() {
  processing.value = true;
  router.post('/admin/login', form.value, {
    onFinish: () => { processing.value = false; },
    onError: () => { form.value.password = ''; },
  });
}
</script>
