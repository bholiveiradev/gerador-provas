<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Bem-vindo(a), {{ auth.user.first_name }}</h1>
    <div class="flex flex-wrap lg:flex-nowrap gap-6">
      <div class="w-full lg:w-1/3 rounded overflow-hidden shadow-lg bg-white">
        <div class="px-6 py-4">
          <p class="text-gray-700 text-base text-4xl">
            {{ countSubjects }}
          </p>
          <div class="font-bold mb-2 text-indigo-600 mt-2">Disciplinas</div>
        </div>
      </div>
      <div class="w-full lg:w-1/3 rounded overflow-hidden shadow-lg bg-white">
        <div class="px-6 py-4">
          <p class="text-gray-700 text-base text-4xl">
            {{ countQuestions }}
          </p>
          <div class="font-bold mb-2 text-indigo-600 mt-2">Questões</div>
        </div>
      </div>
      <div class="w-full lg:w-1/3 rounded overflow-hidden shadow-lg bg-white">
        <div class="px-6 py-4">
          <p class="text-gray-700 text-base text-4xl">
            {{ countTests }}
          </p>
          <div class="font-bold mb-2 text-indigo-600 mt-2">Provas Geradas</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout.vue'

export default {
  components: {
    Head,
  },
  layout: Layout,
  props: {
    auth: Object,
    countSubjects: Number,
    countQuestions: Number,
    countTests: Number,
  },
}
</script>
