<template>
  <vid>
    <Head title="Visualizar Prova" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/tests">Provas </Link>
      <span class="text-indigo-400 font-medium"> / </span> {{ props.subject.name }}
    </h1>
  </vid>
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
    test: Object,
  },
}
</script>
