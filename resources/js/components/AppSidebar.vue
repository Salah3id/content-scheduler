<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    ChartColumnIncreasing,
    NotebookPen,
    Network,
    Settings,
    Code,
    Github
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: ChartColumnIncreasing,
    },
    {
        title: 'Posts',
        href: '/posts',
        icon: NotebookPen,
    },
    {
        title: 'Platforms',
        href: '/platforms',
        icon: Network,
    },
    {
        title: 'Settings',
        href: 'settings/profile',
        icon: Settings,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/Salah3id/content-scheduler',
        icon: Github,
    },
    {
        title: 'API Documentation',
        href: 'https://www.postman.com/salah3id/workspace/practicing/collection/27536537-7a278c77-0916-41b7-af52-d6eece178949?action=share&creator=27536537&active-environment=27536537-3146d30f-ddee-4e78-9cf1-36709ac939f7',
        icon: Code,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
