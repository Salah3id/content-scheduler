<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const filters = ref({
    scheduled_time: '',
    status: ''
})

const dateInputRef = ref<HTMLInputElement | null>(null)

onMounted(() => {
    if (dateInputRef.value) {
        dateInputRef.value.addEventListener('changeDate', (e: any) => {
            filters.value.scheduled_time = e.target.value
        })
    }
})

const applyFilters = () => {
    const params = new URLSearchParams()

    Object.entries(filters.value).forEach(([key, value]) => {
        params.append(`filter[${key}]`, value ?? '')
    })

    const url = `${window.location.pathname}?${params.toString()}`
    router.visit(url, { preserveScroll: false, preserveState: true })
}
</script>

<template>
    <div class="flex items-center justify-between w-full flex-wrap gap-4 px-4">

        <div class="flex gap-4 items-center">
            <div class="relative">
                <label for="atepicker-autohide"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Schedule Date</label>

                <div class="absolute inset-y-12 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input ref="dateInputRef" name="scheduled_time" id="datepicker-autohide" datepicker datepicker-autohide
                    datepicker-format="yyyy-mm-dd" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Select date" />
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status" name="status" v-model="filters.status"
                    class="w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>All</option>
                    <option value="0">Scheduled</option>
                    <option value="1">Published</option>
                    <option value="2">Deleted</option>
                </select>
            </div>
        </div>
        <button @click="applyFilters" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Filter
        </button>
    </div>
</template>
