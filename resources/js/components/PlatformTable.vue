<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3';


interface PlatformItem {
    id: number;
    name: string;
    icon: string | null;
    user_status: {
        label: string;
        color: string;
    };
}

type ToastType = { message?: string; type?: 'success' | 'error' | 'info' | 'warning' };


defineProps<{
    platforms: {
        data: PlatformItem[]
    }
    toast: {
        type: string;
        message: string;
    }
}>()

const { props } = usePage<{ toast?: ToastType }>();

const togglePlatform = (platform: PlatformItem) => {
    const originalStatus = platform.user_status.label === 'Active';

    router.post(`/platforms/${platform.id}/toggle`, {}, {
        onSuccess: () => {
            props.toast = {
                type: 'success',
                message: 'Status changed successfully!'
            };

            router.reload();

        },
        onError: () => {
            platform.user_status.label = originalStatus ? 'Active' : 'Inactive';
            alert("Failed to change status. Please try again.");
        }
    });
};

</script>

<template>
    <div class="overflow-x-auto space-y-4 p-10">
        <table class="table-auto w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-2 py-3">Icon</th>
                    <th class="px-2 py-3">Name</th>
                    <th class="px-2 py-3">Status</th>
                    <th class="px-2 py-3">Toggle Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="platform in platforms.data" :key="platform.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <div class="flex flex-col items-start justify-center gap-2">
                            <i v-html="platform.icon"></i>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ platform.name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <span
                                :class="`w-35 justify-between flex text-sm font-medium bg-${platform.user_status.color}-100 text-${platform.user_status.color}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-${platform.user_status.color}-200 dark:text-${platform.user_status.color}-700`">
                                <i v-html="platform.icon"></i>
                                {{ platform.user_status.label }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 flex items-center justify-center gap-2">
                        <label class="inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" class="sr-only peer"
                                :checked="platform.user_status.label == 'Active'"
                                @change="togglePlatform(platform)">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
