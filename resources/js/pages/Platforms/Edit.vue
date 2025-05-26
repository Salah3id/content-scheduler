<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import type { BreadcrumbItem } from '@/types'

onMounted(() => {
  initFlowbite()
})

interface PageProps {
  post: {
    id: number
    title: string
    content: string
    scheduled_time: string
    platform_ids: number[]
    image_url?: string
    status: string
    platforms: { id: number; name: string; icon: string }[]
  }
  platforms: {data: { id: number; name: string; icon: string }[]}
  [key: string]: any
}

const { props } = usePage<PageProps>()
const platforms = props.platforms
const post = props.post

console.log(props.platforms)

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Posts', href: '/posts' },
  { title: 'Edit', href: `/posts/${props.post.id}/edit` }
]

const form = useForm({
  image: null as File | null,
  title: post.title || '',
  content: post.content || '',
  scheduled_time: post.scheduled_time ? formatDateTimeLocal(post.scheduled_time) : '',
  platform_ids: post.platforms.map(p => p.id) || [],
  status: post.status || ''
})

const submit = () => {
  form.put(`/posts/${post.id}`, {
    onSuccess: () => {
    }
  })
}

function formatDateTimeLocal(datetime: string): string {
  if (!datetime) return ''
  return datetime.slice(0, 16).replace(' ', 'T')
}
</script>

<template>
  <Head :title="`Edit Post #${post.id}`" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 max-w-3xl  space-y-4">
      <h1 class="text-2xl font-bold">Edit Post</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div v-if="post.image_url" class="mb-4">
          <img :src="post.image_url" alt="Current Image" class="max-w-xs rounded" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Image</label>
          <input
            type="file"
            @change="e => { const target = e.target as HTMLInputElement; if (target && target.files) form.image = target.files[0] }"
            class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer"
          />
          <div v-if="form.errors.image" class="text-red-600 text-sm">{{ form.errors.image }}</div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Title</label>
          <input v-model="form.title" type="text" class="w-full px-4 py-2 border rounded-lg" />
          <div v-if="form.errors.title" class="text-red-600 text-sm">{{ form.errors.title }}</div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Content</label>
          <textarea v-model="form.content" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
          <div v-if="form.errors.content" class="text-red-600 text-sm">{{ form.errors.content }}</div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Scheduled Time</label>
          <input v-model="form.scheduled_time" type="datetime-local" class="w-full px-4 py-2 border rounded-lg" />
          <div v-if="form.errors.scheduled_time" class="text-red-600 text-sm">{{ form.errors.scheduled_time }}</div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Platforms</label>
          <ul
            class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white"
          >
            <li
              v-for="platform in platforms.data"
              :key="platform.id"
              class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r last:border-r-0 dark:border-gray-600"
            >
              <div class="flex flex-col items-center">
                <label
                  :for="'platform-checkbox-' + platform.id"
                  class="justify-center items-center flex w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                >
                  <i
                    v-html="platform.icon"
                    class="mr-2 px-5 rounded-full border flex items-center h-15 w-15 justify-center text-center"
                  ></i>
                  {{ platform.name }}
                </label>
                <input
                  :id="'platform-checkbox-' + platform.id"
                  type="checkbox"
                  :value="platform.id"
                  v-model="form.platform_ids"
                  class="w-6 h-6 m-5 text-blue-600 bg-gray-100 border-gray-300 rounded-full focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
              </div>
            </li>
          </ul>

          <div v-if="form.errors.platform_ids" class="text-red-600 text-sm mt-1">
            {{ form.errors.platform_ids }}
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"
            :disabled="form.processing"
          >
            Update Post
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
