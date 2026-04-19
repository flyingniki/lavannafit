<template>
  <div>
    <!-- HEADER -->
    <AppHeader :whatsapp-phone="settings?.whatsapp_phone" />

    <!-- SECTIONS -->
    <HeroSection :settings="settings" />
    <AboutSection :settings="settings" />
    <ServicesSection :tariffs="tariffs" />
    <ResultsSection :slides="results" />
    <ReviewsSection :reviews="reviews" />
    <ContactSection :whatsapp-phone="settings?.whatsapp_phone" />
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '@/Components/AppHeader.vue';
import HeroSection from '@/Components/HeroSection.vue';
import AboutSection from '@/Components/AboutSection.vue';
import ServicesSection from '@/Components/ServicesSection.vue';
import ResultsSection from '@/Components/ResultsSection.vue';
import ReviewsSection from '@/Components/ReviewsSection.vue';
import ContactSection from '@/Components/ContactSection.vue';
import AppFooter from '@/Components/AppFooter.vue';

const props = defineProps({
  tariffs: Array,
  reviews: Array,
  results: Array,
  settings: Object,
  seo: Object,
});
</script>

