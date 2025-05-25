<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3'

interface Links {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
}

interface Meta {
  current_page: number;
  from: number;
  last_page: number;
  path: string;
  per_page: number;
  to: number;
  total: number;
}

const props = defineProps<{
  links: Links;
  meta: Meta;
  filters: object;
}>();



const pages = computed(() => {
  const totalPages = props.meta.last_page;
  const current = props.meta.current_page;
  const pagesArray: (number | string)[] = [];

  if (totalPages <= 5) {
    for (let i = 1; i <= totalPages; i++) {
      pagesArray.push(i);
    }
  } else {
    pagesArray.push(1);

    if (current > 3) {
      pagesArray.push('...');
    }

    const start = Math.max(2, current - 1);
    const end = Math.min(totalPages - 1, current + 1);

    for (let i = start; i <= end; i++) {
      if (i !== 1 && i !== totalPages) {
        pagesArray.push(i);
      }
    }

    if (current < totalPages - 2) {
      pagesArray.push('...');
    }

    pagesArray.push(totalPages);
  }

  return pagesArray;
});

const goToPage = (page: number) => {
  const params = new URLSearchParams()

  Object.entries(props.filters).forEach(([key, value]) => {
    params.append(`filter[${key}]`, value === null ? '' : String(value))
  })

  params.append('page', String(page))

  const url = `${window.location.pathname}?${params.toString()}`

  router.visit(url, { preserveScroll: false, preserveState: true })
}

</script>

<template>
  <nav aria-label="Page navigation example">
    <ul class="inline-flex -space-x-px text-sm">
      <li>
        <button @click="goToPage(props.meta.current_page - 1)" :disabled="!props.links.prev"
          class="flex items-center justify-center px-3 h-8 ms-0 leading-tight border border-e-0 rounded-s-lg
            text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700
            dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
          Previous
        </button>
      </li>

      <li v-for="page in pages" :key="page">
        <span v-if="page === '...'" class="flex items-center justify-center px-3 h-8 text-gray-400">
          ...
        </span>
        <button v-else @click="goToPage(page as number)" :class="[
          'flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-white',
          page === props.meta.current_page
            ? 'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white'
            : 'text-gray-500 bg-white dark:bg-gray-800 dark:text-gray-400'
        ]" :aria-current="page === props.meta.current_page ? 'page' : undefined">
          {{ page }}
        </button>
      </li>


      <li>
        <button @click="goToPage(props.meta.current_page + 1)" :disabled="!props.links.next"
          class="flex items-center justify-center px-3 h-8 leading-tight border border-e-0 rounded-e-lg
            text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700
            dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
          Next
        </button>
      </li>
    </ul>
  </nav>
</template>
