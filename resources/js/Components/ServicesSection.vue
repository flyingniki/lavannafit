<template>
  <section id="services" class="py-24 bg-indigo-50">
    <div class="max-w-6xl mx-auto px-4">

      <div class="text-center mb-14 reveal">
        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Услуги и цены</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3">Выберите свой тариф</h2>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">Все тарифы включают персональную программу и поддержку тренера.</p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(tariff, i) in tariffs"
          :key="tariff.name"
          class="reveal bg-white rounded-3xl shadow-sm hover:shadow-xl transition-shadow duration-300 p-8 flex flex-col"
          :style="{ animationDelay: i * 0.1 + 's' }"
        >
          <h3 class="text-xl font-bold text-gray-900 mb-1">{{ tariff.name }}</h3>
          <p class="text-gray-500 text-sm mb-6">{{ tariff.description }}</p>

          <div class="mb-6">
            <span class="text-4xl font-extrabold text-indigo-600">{{ tariff.price }} ₽</span>
            <span class="text-gray-400 text-sm ml-1">/ {{ tariff.period }}</span>
          </div>

          <ul class="space-y-3 flex-1 mb-8">
            <li
              v-for="feature in tariff.features"
              :key="feature"
              class="flex items-start gap-3 text-sm text-gray-700"
            >
              <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              {{ feature }}
            </li>
          </ul>

          <a
            href="#contact"
            class="block text-center bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-semibold py-3 rounded-full transition-all duration-200"
          >
            Выбрать тариф
          </a>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { useReveal } from '@/composables/useReveal';
useReveal();

defineProps({ tariffs: Array });
</script>
