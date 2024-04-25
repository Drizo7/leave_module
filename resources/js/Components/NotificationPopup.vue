
<script setup>
import { computed } from 'vue'

const props = defineProps({
    notifications: {
        type: Array,
        required: true
    },
    showNotifications: {
        type: Boolean,
        required: true
    }
})

const visibleNotifications = computed(() => props.notifications)
const isNotificationVisible = computed(() => props.showNotifications)
</script>
<template>
    <div v-show="isNotificationVisible" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a v-for="notification in visibleNotifications" :key="notification.id" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                {{ notification.message }}
            </a>
        </div>
    </div>
</template>
