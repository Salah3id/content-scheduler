<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import BaseToast from '@/components/BaseToast.vue';
import { ref, watch, nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';
import {  } from 'vue';

const toastRef = ref();
type ToastType = { message?: string; type?: 'success' | 'error' | 'info' | 'warning' };

const { props } = usePage<{ toast?: ToastType }>();
console.log('Initial toast props:', props.toast);
watch(() => props.toast, (toast) => {
  console.log('Toast props changed:', toast);
  if (toast?.message) {
    nextTick(() => {
      toastRef.value?.showToast({
        message: toast.message,
        code: toast.type || 'info',
      });
    });
  }
}, { immediate: true });

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #sidebar-actions>
      <slot name="sidebar-actions" />
    </template>
    <slot />
    <BaseToast ref="toastRef" />
  </AppLayout>
</template>
