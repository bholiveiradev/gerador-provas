<template>
  <div>
    <Head title="Gerar Prova" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/tests">Provas </Link>
      <span class="text-indigo-400 font-medium"> / </span> Gerar
    </h1>
    <div class="w-full bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.subject" :error="form.errors.subject" class="pb-8 pr-6 w-full" label="Disciplina">
            <option :value="null" selected="selected">Selecione uma disciplina</option>
            <option v-for="subject in subjects" :key="subject.id" :value="`${subject.id}`">{{ subject.name }}</option>
          </select-input>
          <div class="pb-8 pr-6 w-full">
            <editor
              v-model="form.infos"
              :api-key="`${$inertia.page.props.tinymce_api_key}`"
              plugins="anchor autolink charmap codesample emoticons image link lists searchreplace table visualblocks code"
              toolbar="undo redo | fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons | removeformat code"
              class="form-textarea"
              :class="{error: form.infos}"
              :initial-value="form.infos"
              :rows="4"
            />
          </div>
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
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    Editor,
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
        infos: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/tests', {
        onSuccess: (response) => console.log(response),
        // onSuccess: () => window.open(`/tests/${}/print`, '__blank')
      })
    },
  },
}
</script>
