<template>
    <div class="min-h-screen flex flex-col">
    
      <div class="flex flex-grow">
        <Trial />
        <!-- Main Content -->
        <main class="flex-grow p-6">
          <slot />
        </main>
      </div>
    </div>
  </template>
  
  <script setup>
  import Trial from '@/Components/Trial.vue';
  </script>
  