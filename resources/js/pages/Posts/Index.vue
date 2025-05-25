<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head} from '@inertiajs/vue3'
import PostTable from '@/components/PostTable.vue'
import type { BreadcrumbItem } from '@/types'
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import NewPostButton from '@/components/NewPostButton.vue'

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

defineProps<{
    posts: Post
    filters: object
}>()

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Posts', href: '/posts' }]

</script>

<template>
    <Head title="Posts" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #sidebar-actions>
            <NewPostButton />
        </template>
        <PostTable :posts="posts" :filters="filters" />
    </AppLayout>
</template>
