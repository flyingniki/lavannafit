<template>
  <section
    id="hero"
    class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-pink-50 overflow-hidden pt-16"
  >
    <!-- Decorative floating blobs -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-indigo-200 rounded-full opacity-30 blur-3xl animate-float pointer-events-none" />
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-pink-200 rounded-full opacity-25 blur-3xl animate-float pointer-events-none" style="animation-delay: 3s;" />

    <div class="relative z-10 max-w-3xl mx-auto px-4 text-center">
      <p class="inline-block text-sm font-semibold text-indigo-600 bg-indigo-50 px-4 py-1 rounded-full mb-6 animate-fade-in-up">
        {{ settings?.hero_badge || '🏋️ Онлайн-ведение по всей России' }}
      </p>

      <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-6 animate-fade-in-up" style="animation-delay:0.1s">
        <template v-if="settings?.hero_title">
          <span v-html="settings.hero_title.replace(/\n/g, '<br />')" />
        </template>
        <template v-else>
          Твоё тело изменится.<br />
          <span class="text-indigo-600">Навсегда.</span>
        </template>
      </h1>

      <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto mb-10 animate-fade-in-up" style="animation-delay:0.2s">
        {{ settings?.hero_subtitle || 'Персональные онлайн-тренировки для женщин 30+. Без строгих диет, без зала — только результат, который остаётся.' }}
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up" style="animation-delay:0.3s">
        <a
          href="#contact"
          class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-semibold px-8 py-4 rounded-full shadow-lg shadow-indigo-200 transition-all duration-200 text-base"
        >
          {{ settings?.hero_cta || 'Записаться на пробное занятие' }}
        </a>
        <a
          :href="`https://wa.me/${settings?.whatsapp_phone || '79000000000'}`"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center justify-center gap-2 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 active:scale-95 font-semibold px-8 py-4 rounded-full transition-all duration-200 text-base"
        >
          Написать в WhatsApp
        </a>
      </div>

      <!-- Stats -->
      <div class="mt-16 grid grid-cols-3 gap-6 max-w-lg mx-auto animate-fade-in-up" style="animation-delay:0.4s">
        <div>
          <p class="text-3xl font-extrabold text-gray-900">{{ settings?.stat_clients || '200+' }}</p>
          <p class="text-sm text-gray-500 mt-1">довольных клиентов</p>
        </div>
        <div>
          <p class="text-3xl font-extrabold text-gray-900">{{ settings?.stat_years || '5 лет' }}</p>
          <p class="text-sm text-gray-500 mt-1">опыта в тренерстве</p>
        </div>
        <div>
          <p class="text-3xl font-extrabold text-gray-900">100%</p>
          <p class="text-sm text-gray-500 mt-1">онлайн, вся страна</p>
        </div>
      </div>
    </div>

    <!-- Scroll cue -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce opacity-50">
      <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>
  </section>
</template>

<script setup>
defineProps({ settings: Object });
</script>
