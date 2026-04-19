<template>
  <div class="bg-white rounded-2xl border border-gray-100 p-6">
    <h3 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-widest text-indigo-600">{{ title }}</h3>
    <div class="space-y-4">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: '',
  },
});
</script>
