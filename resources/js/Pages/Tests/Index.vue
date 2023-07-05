<template>
  <div>
    <Head title="Provas" />
    <h1 class="mb-8 text-3xl font-bold">Provas</h1>
    <div class="flex items-center justify-between mb-6">
      <Link class="btn-indigo" href="/tests/create">
        <span>Gerar</span>
        <span class="hidden md:inline">&nbsp;Prova</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <div v-if="!tests.length">
        <p class="px-6 py-4 border-t" colspan="4">Nenhuma prova por enquanto.</p>
      </div>
      <table v-else class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Disciplina</th>
          <th class="pb-4 pt-6 px-6">Questões</th>
        </tr>
        <tr v-for="test in tests" :key="test.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <a class="flex items-center px-6 py-4 focus:text-indigo-500" target="__blank" :href="`/tests/${test.id}/print`">
              {{ test.subject.name }}
              <icon v-if="test.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </a>
          </td>
          <td class="border-t">
            <a class="flex items-center px-6 py-4" target="__blank" :href="`/tests/${test.id}/print`" tabindex="-1">
              {{ test.count_questions }}
            </a>
          </td>
          <td class="w-px border-t">
            <a class="flex items-center px-4" target="__blank" :href="`/tests/${test.id}/print`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
// import throttle from 'lodash/throttle'
// import mapValues from 'lodash/mapValues'
// import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout.vue'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    Head,
    Link,
    Icon,
  },
  layout: Layout,
  props: {
    tests: Array,
  },
  data() {
    return {
    }
  },
}
</script>
