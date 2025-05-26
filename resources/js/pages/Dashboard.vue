<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const { props } = usePage();

interface Platform {
    id: number;
    name: string;
    icon: string;
    user_status: {
        label: string;
        color: string;
    };
    posts_summary: {
        total_posts: number;
        scheduled_count: number;
        published_count: number;
        failed_on_publish_count: number;
        failed_on_schedule_count: number;
        publishing_success_rate: number;
        publishing_failure_rate: number;
    };
}

interface PlatformsProp {
    data: Platform[];
}

const platforms = (props.platforms as PlatformsProp).data;

console.log(platforms);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                <div v-for="platform in platforms" :key="platform.id"
    class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm bg-white dark:bg-gray-800">
    <div class="flex items-center gap-2 mb-4">
        <span v-html="platform.icon" />
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ platform.name }}</h3>
        <span class="ms-auto text-xs font-medium px-2 py-0.5 rounded-full"
            :class="`bg-${platform.user_status.color}-100 text-${platform.user_status.color}-800 dark:bg-${platform.user_status.color}-200 dark:text-${platform.user_status.color}-900`">
            {{ platform.user_status.label }}
        </span>
    </div>

    <dl class="space-y-2">
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Total Posts</dt>
            <dd class="font-medium text-gray-900 dark:text-white">{{ platform.posts_summary.total_posts }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Scheduled Posts</dt>
            <dd class="font-medium text-gray-900 dark:text-white">{{ platform.posts_summary.scheduled_count }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Published Posts</dt>
            <dd class="font-medium text-gray-900 dark:text-white">{{ platform.posts_summary.published_count }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Failed on Publish</dt>
            <dd class="font-medium text-red-600 dark:text-red-400">{{ platform.posts_summary.failed_on_publish_count }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Failed on Delete</dt>
            <dd class="font-medium text-red-600 dark:text-red-400">{{ platform.posts_summary.failed_on_delete_count }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Publishing Success Rate</dt>
            <dd class="flex items-center mt-1">
                <div class="w-full bg-gray-200 rounded-sm h-2 dark:bg-gray-700 me-2">
                    <div class="bg-green-600 h-2 rounded-sm dark:bg-green-500"
                        :style="`width: ${platform.posts_summary.publishing_success_rate}%`"></div>
                </div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ platform.posts_summary.publishing_success_rate }}%
                </span>
            </dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500 dark:text-gray-400">Publishing Failure Rate</dt>
            <dd class="flex items-center mt-1">
                <div class="w-full bg-gray-200 rounded-sm h-2 dark:bg-gray-700 me-2">
                    <div class="bg-red-600 h-2 rounded-sm dark:bg-red-500"
                        :style="`width: ${platform.posts_summary.publishing_failure_rate}%`"></div>
                </div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ platform.posts_summary.publishing_failure_rate }}%
                </span>
            </dd>
        </div>
    </dl>
</div>

            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
            </div>
        </div>
    </AppLayout>
</template>
