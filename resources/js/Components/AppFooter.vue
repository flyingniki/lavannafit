<template>
  <footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
      <p>© {{ year }} FitOnline. Все права защищены.</p>
      <div class="flex items-center gap-4">
        <a href="/privacy" class="hover:text-white transition-colors">Политика конфиденциальности</a>
        <a href="/sitemap.xml" class="hover:text-white transition-colors">Sitemap</a>
      </div>
    </div>
  </footer>
</template>

<script setup>
const year = new Date().getFullYear();
</script>
