<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head} from '@inertiajs/vue3'
import PlatformTable from '@/components/PlatformTable.vue'
import type { BreadcrumbItem } from '@/types'


interface PlatformItem {
    id: number;
    name: string;
    icon: string | null;
    user_status: {
        label: string;
        color: string;
    };
}

interface Platform {
    data: PlatformItem[],
    meta: {
        current_page: number;
        from: number;
        last_page: number;
        path: string;
        per_page: number;
        to: number;
        total: number;
    },
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    }
}

defineProps<{
    platforms: Platform
    filters: object
}>()

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Platforms', href: '/platforms' }]

</script>

<template>
    <Head title="Platforms" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #sidebar-actions>
        </template>
        <PlatformTable :platforms="platforms" :filters="filters" />
    </AppLayout>
</template>
