<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import type { BreadcrumbItem } from '@/types'
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

onMounted(() => {
    initFlowbite();
})

interface PostItem {
    id: number;
    title: string;
    image: string | null;
    date: string;
    status: {
        label: string;
        color: string;
    };
    scheduled_time: string;
    platforms: {
        icon: string;
        name: string;
        status: {
            label: string;
            color: string;
        };
    }[];
}
interface Post {
    data: PostItem[],
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

const props = defineProps<{
    posts: Post
    filters: Object
}>()

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Posts', href: '/posts' },
{ title: 'Edit', href: '/posts/edit' }]

</script>

<template>

    <Head title="Posts" />
    <AppLayout :breadcrumbs="breadcrumbs">
    </AppLayout>
</template>
