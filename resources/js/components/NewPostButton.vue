<script setup lang="ts">
import { router } from '@inertiajs/vue3'

const goToCreate = () => router.visit('/posts/create')

</script>

<template>
    <button @click="goToCreate"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
        New Post
    </button>
</template>