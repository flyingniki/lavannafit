<template>
  <section id="about" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <div class="grid md:grid-cols-2 gap-12 items-center">

        <!-- Photo placeholder -->
        <div class="reveal flex justify-center">
          <div class="relative">
            <div class="w-72 h-72 sm:w-80 sm:h-80 rounded-3xl bg-indigo-100 overflow-hidden shadow-xl">
              <img
                v-if="settings?.about_photo_url"
                :src="settings.about_photo_url"
                alt="Фото тренера"
                class="w-full h-full object-cover"
              />
              <div v-else class="absolute inset-0 flex items-center justify-center text-indigo-300">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
            </div>
            <!-- Badge -->
            <div class="absolute -bottom-4 -right-4 bg-indigo-600 text-white rounded-2xl px-4 py-3 shadow-lg text-center">
              <p class="text-2xl font-extrabold leading-none">{{ settings?.about_experience_years || '5+' }}</p>
              <p class="text-xs mt-1">лет опыта</p>
            </div>
          </div>
        </div>

        <!-- Text -->
        <div class="reveal">
          <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Обо мне</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3 mb-6 leading-tight">
            <span v-if="settings?.about_title" v-html="settings.about_title.replace(/\n/g, '<br />')" />
            <template v-else>Я знаю, каково это —<br />не иметь времени на себя</template>
          </h2>
          <p class="text-gray-600 leading-relaxed mb-4">
            {{ settings?.about_text1 || 'Привет! Я — сертифицированный тренер по фитнесу с более чем 5-летним опытом онлайн-ведения. Работаю с занятыми женщинами, у которых нет времени ходить в зал, но есть желание изменить себя.' }}
          </p>
          <p class="text-gray-600 leading-relaxed mb-8">
            {{ settings?.about_text2 || 'Мой подход — без жёстких диет и изнурительных тренировок. Только то, что подходит лично вам, вашему ритму жизни и целям.' }}
          </p>

          <p v-if="settings?.trainer_name" class="text-indigo-700 font-semibold mb-5">
            Тренер: {{ settings.trainer_name }}
          </p>

          <ul class="space-y-3">
            <li v-for="item in achievements" :key="item" class="flex items-center gap-3 text-gray-700">
              <span class="flex-shrink-0 w-5 h-5 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </span>
              {{ item }}
            </li>
          </ul>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { useReveal } from '@/composables/useReveal';

useReveal();

const props = defineProps({ settings: Object });

const fallbackAchievements = [
  'Сертифицированный тренер (ISSA, FPA)',
  'Более 200 клиентов по всей России',
  'Специализация: женский фитнес 30+',
  'Результат без вреда для здоровья',
  'Индивидуальный подход к каждой',
];

const achievements = computed(() => {
  const source = props.settings?.about_achievements;
  if (!source) return fallbackAchievements;

  const parsed = source
    .split('\n')
    .map((item) => item.trim())
    .filter(Boolean);

  return parsed.length ? parsed : fallbackAchievements;
});
</script>
