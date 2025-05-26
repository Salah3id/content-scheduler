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
        href: 'https://github.com/Salah3id/content_scheduler',
        icon: Github,
    },
    {
        title: 'API Documentation',
        href: 'https://www.postman.com/acairo/workspace/public/request/24549944-7e1ba1e5-be5c-4c52-a451-a729d01e5b8d?action=share&creator=24549944&ctx=documentation&active-environment=24549944-12e70e7f-ff8e-4c0f-960f-9d39600ab9ed',
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
