<template>
    <div v-if="isOpen" class="fixed z-50 top-2 left-1/2 transform -translate-x-1/2">
      <div class="bg-green-500 text-white py-3 px-4 rounded-md shadow-md flex items-center justify-between">
        <div class="flex items-center">
          <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ props.message }}</span>
        </div>
        <button @click="dismissAlert" class="ml-4 text-green-200 hover:text-white focus:outline-none">
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    message: {
      type: String,
      required: true,
    },
  });
  
  const isOpen = ref(true);
  
  const dismissAlert = () => {
    isOpen.value = false;
  };
  </script>