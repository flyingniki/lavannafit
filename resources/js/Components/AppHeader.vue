<template>
  <header
    class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100 transition-shadow"
    :class="{ 'shadow-md': scrolled }"
  >
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
      <!-- Logo -->
      <a href="#hero" class="text-xl font-bold text-indigo-600 tracking-tight">FitOnline</a>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
        <a href="#about"    class="hover:text-indigo-600 transition-colors">Обо мне</a>
        <a href="#services" class="hover:text-indigo-600 transition-colors">Услуги</a>
        <a href="#results"  class="hover:text-indigo-600 transition-colors">Результаты</a>
        <a href="#reviews"  class="hover:text-indigo-600 transition-colors">Отзывы</a>
        <a href="#contact"  class="hover:text-indigo-600 transition-colors">Контакты</a>
      </nav>

      <!-- CTA -->
      <a
        :href="`https://wa.me/${whatsappPhone}`"
        target="_blank"
        rel="noopener noreferrer"
        class="hidden md:inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-4 py-2 rounded-full transition-all duration-200"
      >
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.523 5.845L.057 23.885l6.201-1.441A11.935 11.935 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.003-1.366l-.359-.213-3.72.864.934-3.613-.234-.37A9.818 9.818 0 1112 21.818z"/>
        </svg>
        WhatsApp
      </a>

      <!-- Burger -->
      <button
        class="md:hidden p-2 text-gray-600"
        @click="menuOpen = !menuOpen"
        aria-label="Меню"
      >
        <svg v-if="!menuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile menu -->
    <transition name="slide-down">
      <div v-if="menuOpen" class="md:hidden bg-white border-t border-gray-100 px-4 py-4 flex flex-col gap-4 text-sm font-medium text-gray-700">
        <a href="#about"    @click="menuOpen = false" class="hover:text-indigo-600">Обо мне</a>
        <a href="#services" @click="menuOpen = false" class="hover:text-indigo-600">Услуги</a>
        <a href="#results"  @click="menuOpen = false" class="hover:text-indigo-600">Результаты</a>
        <a href="#reviews"  @click="menuOpen = false" class="hover:text-indigo-600">Отзывы</a>
        <a href="#contact"  @click="menuOpen = false" class="hover:text-indigo-600">Контакты</a>
        <a
          :href="`https://wa.me/${whatsappPhone}`"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center justify-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-full"
        >WhatsApp</a>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';

const props = defineProps({ whatsappPhone: { type: String, default: '79000000000' } });

const menuOpen = ref(false);
const scrolled  = ref(false);

const whatsappPhone = computed(() => props.whatsappPhone || '79000000000');

function onScroll() {
  scrolled.value = window.scrollY > 20;
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active { transition: opacity 0.2s ease, transform 0.2s ease; }
.slide-down-enter-from,
.slide-down-leave-to     { opacity: 0; transform: translateY(-8px); }
</style>
