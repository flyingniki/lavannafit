<template>
  <section id="reviews" class="py-24 bg-indigo-50">
    <div class="max-w-6xl mx-auto px-4">

      <div class="text-center mb-12 reveal">
        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Отзывы</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-3">Что говорят клиентки</h2>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="(review, i) in displayReviews"
          :key="i"
          class="reveal bg-white rounded-3xl p-6 shadow-sm"
          :style="{ transitionDelay: i * 0.1 + 's' }"
        >
          <!-- Stars -->
          <div class="flex gap-1 mb-4">
            <svg v-for="s in 5" :key="s" class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>

          <p class="text-gray-700 text-sm leading-relaxed mb-5">"{{ review.text }}"</p>

          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm flex-shrink-0">
              {{ review.name[0] }}
            </div>
            <div>
              <p class="font-semibold text-sm text-gray-900">{{ review.name }}</p>
              <p class="text-xs text-gray-400">{{ review.city }}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { useReveal } from '@/composables/useReveal';
useReveal();

const props = defineProps({ reviews: Array });

const defaultReviews = [
  { name: 'Анна К.',   city: 'Москва',          text: 'За 3 месяца минус 8 кг! Самое главное — без голодовок. Тренер всегда на связи, поддерживает и корректирует план под мой график.' },
  { name: 'Марина С.', city: 'Санкт-Петербург', text: 'Наконец-то нашла тренера, который понимает, что у меня нет 2 часов в день на спорт. Тренировки по 40 минут — и результат заметен.' },
  { name: 'Ольга Т.',  city: 'Екатеринбург',    text: 'Подруга посоветовала. Сначала не верила, что онлайн это вообще работает. Теперь сама всем советую. Спасибо огромное!' },
];

const displayReviews = computed(() => (props.reviews && props.reviews.length) ? props.reviews : defaultReviews);
</script>
