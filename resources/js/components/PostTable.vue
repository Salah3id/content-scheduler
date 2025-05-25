<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import Pagination from '@/components/Pagination.vue'
import FilterForm from '@/components/FilterForm.vue'


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

interface PostPagination {
    data: PostItem[];
    meta: {
        current_page: number;
        from: number;
        last_page: number;
        path: string;
        per_page: number;
        to: number;
        total: number;
    };
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };
}


const props = defineProps<{
    posts: PostPagination
    filters: Object
}>()

const handleFilter = (filters: any) => {
    router.get('/posts', filters, { preserveState: true })
}


const editPost = (id: number) => {
    router.visit(`/posts/${id}/edit`)
}

const deletePost = (id: number) => {
    if (confirm('Are you sure?')) {
        router.delete(`/posts/${id}`)
    }
}


</script>

<template>
    <div class="overflow-x-auto space-y-4 p-10">
        <FilterForm :initialFilters="filters" @filter="handleFilter" />
        <table class="table-auto w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-2 py-3">#</th>
                    <th class="px-2 py-3">Title</th>
                    <th class="px-2 py-3">Date</th>
                    <th class="px-2 py-3">Platform</th>
                    <th class="px-2 py-3">Status</th>
                    <th class="px-2 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts.data" :key="post.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td>
                        <img src="https://fakeimg.pl/200x100/" class="w-16 md:w-32 max-w-full max-h-full"
                            alt="Placeholder Image">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ post.title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ post.scheduled_time }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-start justify-center gap-2">
                            <span v-for="platform in post.platforms" :key="platform.name"
                                :class="`w-35 justify-between flex text-sm font-medium bg-${platform.status.color}-100 text-${platform.status.color}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-${platform.status.color}-200 dark:text-${platform.status.color}-700`">
                                <i v-html="platform.icon"></i>
                                {{ platform.status.label }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            :class="`px-2 py-1 rounded text-xs font-semibold bg-${post.status.color}-100 text-${post.status.color}-800 dark:bg-${post.status.color}-900 dark:text-${post.status.color}-300`">

                            {{ post.status.label }}
                        </span>

                    </td>
                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                        <button v-if="post.status.label == 'Scheduled'" @click="editPost(post.id)" type="button"
                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                    clip-rule="evenodd" />
                            </svg>

                        </button>
                        <button v-if="post.status.label != 'Deleted'" @click="deletePost(post.id)" type="button"
                            class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>

                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="posts.links" :meta="posts.meta" :filters="filters" />
    </div>
</template>
