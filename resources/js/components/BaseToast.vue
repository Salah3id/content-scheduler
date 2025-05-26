<template>
    <div v-if="visible" class="fixed bottom-5 right-5 z-50 max-w-sm w-full border rounded-lg shadow" :class="[
        code === 'success' && 'bg-green-100 border-green-400 text-green-900 dark:bg-green-800 dark:border-green-500 dark:text-green-100',
        code === 'error' && 'bg-red-100 border-red-400 text-red-900 dark:bg-red-800 dark:border-red-500 dark:text-red-100',
        code === 'info' && 'bg-blue-100 border-blue-400 text-blue-900 dark:bg-blue-800 dark:border-blue-500 dark:text-blue-100',
        code === 'warning' && 'bg-yellow-100 border-yellow-400 text-yellow-900 dark:bg-yellow-800 dark:border-yellow-500 dark:text-yellow-100'
    ]" role="alert">
        <div class="flex p-4">
            <div class="ml-3 text-sm font-normal">
                {{ message }}
            </div>
            <button @click="visible = false" type="button"
                class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 text-gray-600 dark:text-gray-300">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const visible = ref(false);
const message = ref('');
const code = ref<'success' | 'error' | 'info' | 'warning'>('info');

function showToast(payload: { message: string; code?: 'success' | 'error' | 'info' | 'warning' }, duration = 3000) {
  message.value = payload.message;
  code.value = payload.code ?? 'info';
  visible.value = true;

  setTimeout(() => {
    visible.value = false;
  }, duration);
}

defineExpose({
  showToast,
});
</script>
