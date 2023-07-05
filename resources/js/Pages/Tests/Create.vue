<template>
  <div>
    <Head title="Gerar Prova" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/tests">Provas </Link>
      <span class="text-indigo-400 font-medium"> / </span> Gerar
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.subject" :error="form.errors.subject" class="pb-8 pr-6 w-full" label="Disciplina">
            <option :value="null" selected="selected">Selecione uma disciplina</option>
            <option v-for="subject in subjects" :key="subject.id" :value="`${subject.id}`">{{ subject.name }}</option>
          </select-input>
          <text-input v-model="form.count_questions" :error="form.errors.count_questions" class="pb-8 pr-6 w-full" label="Quantidade Questões" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Gerar</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout.vue'
import SelectInput from '../../Shared/SelectInput.vue'
import TextInput from '../../Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    subjects: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        subject: null,
        count_questions: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/tests', {
        onSuccess: (response) => console.log(response)
        // onSuccess: () => window.open(`/tests/${}/print`, '__blank')
      })
    },
  },
}
</script>
