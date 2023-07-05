<template>
  <div>
    <Head title="Disciplinas" />
    <h1 class="mb-8 text-3xl font-bold">Disciplinas</h1>
    <div class="flex items-center justify-between mb-6">
      <Link class="btn-indigo" href="/subjects/create">
        <span>Criar</span>
        <span class="hidden md:inline">&nbsp;Disciplina</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <div v-if="!subjects.data.length">
        <p class="px-6 py-4 border-t" colspan="4">Nenhuma disciplina por enquanto.</p>
      </div>
      <table v-else class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nome</th>
        </tr>
        <tr v-for="subject in subjects.data" :key="subject.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/subjects/${subject.id}/edit`">
              {{ subject.name }}
              <icon v-if="subject.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/subjects/${subject.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
      </table>
    </div>
    <pagination :links="subjects.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout.vue'
import Icon from '@/Shared/Icon.vue'
import Pagination from '@/Shared/Pagination.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination
  },
  layout: Layout,
  props: {
    subjects: Array,
  },
  data() {
    return {
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/subjects', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
