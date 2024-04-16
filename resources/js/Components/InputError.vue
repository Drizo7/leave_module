<script setup>
defineProps({
    name: {
        type: String,
    },
});
</script>

<template>
    <div v-show="name">
        <p class="text-sm text-red-600">
            {{ name }}
        </p>
    </div>
</template>
