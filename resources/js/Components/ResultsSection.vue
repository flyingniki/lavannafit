<template>
  <section id="results" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">

      <div class="text-center mb-12 reveal">
        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Результаты</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3">Они уже изменились</h2>
      </div>

      <!-- Carousel -->
      <div class="reveal relative overflow-hidden">
        <div
          class="flex transition-transform duration-500 ease-in-out"
          :style="{ transform: `translateX(-${current * 100}%)` }"
        >
          <div
            v-for="(slide, i) in displaySlides"
            :key="i"
            class="w-full flex-shrink-0 px-2"
          >
            <div class="bg-indigo-50 rounded-3xl overflow-hidden aspect-[4/3] flex items-center justify-center">
              <!-- Replace with real before/after images -->
              <img
                v-if="slide.image"
                :src="slide.image"
                :alt="slide.alt"
                class="w-full h-full object-cover"
              />
              <div v-else class="text-center text-indigo-300 p-8">
                <svg class="w-20 h-20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="font-medium text-sm">{{ slide.alt }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Arrows -->
        <button
          class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-md rounded-full flex items-center justify-center hover:bg-indigo-50 transition-colors"
          @click="prev"
          aria-label="Назад"
        >
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button
          class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-md rounded-full flex items-center justify-center hover:bg-indigo-50 transition-colors"
          @click="next"
          aria-label="Вперёд"
        >
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <!-- Dots -->
        <div class="flex justify-center gap-2 mt-6">
          <button
            v-for="(_, i) in displaySlides"
            :key="i"
            class="w-2.5 h-2.5 rounded-full transition-colors"
            :class="current === i ? 'bg-indigo-600' : 'bg-gray-200'"
            @click="current = i"
          />
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useReveal } from '@/composables/useReveal';
useReveal();

const props = defineProps({ slides: Array });

const current = ref(0);

const defaultSlides = [
  { alt: 'Результат клиентки 1', image: '/images/result-1.jpg' },
  { alt: 'Результат клиентки 2', image: '/images/result-2.jpg' },
  { alt: 'Результат клиентки 3', image: '/images/result-3.jpg' },
];

const displaySlides = computed(() => (props.slides && props.slides.length) ? props.slides : defaultSlides);

function prev() {
  current.value = current.value === 0 ? displaySlides.value.length - 1 : current.value - 1;
}
function next() {
  current.value = current.value === displaySlides.value.length - 1 ? 0 : current.value + 1;
}
</script>
