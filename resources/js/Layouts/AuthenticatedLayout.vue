<template>
    <div class="min-h-screen flex flex-col">
      <BarNav />
      <div class="flex flex-grow">
        <!-- Main Content -->
        <main class="flex-grow p-6">
          <slot />
        </main>
      </div>
    </div>
  </template>
  
  <script setup>
  import BarNav from '@/Components/NavBars.vue';
  </script>