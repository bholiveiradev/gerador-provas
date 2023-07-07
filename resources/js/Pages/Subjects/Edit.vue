<template>
  <div>
    <Head title="Editar Disciplina" />
    <div class="flex justify-start mb-8 w-full">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/subjects">Disciplinas</Link>
        <span class="text-indigo-400 font-medium"> / </span>
        {{ form.name }}
      </h1>
    </div>
    <trashed-message v-if="subject.deleted_at" class="mb-6" @restore="restore"> A disciplina foi removido. </trashed-message>
    <div class="w-full bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full" label="Disciplina" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!subject.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Remover</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Atualizar</loading-button>
        </div>
      </form>
    </div>

    <div class="w-full bg-white rounded-md shadow overflow-hidden mt-8">
      <form @submit.prevent="storeQuestion">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="formQuestion.question" :error="formQuestion.errors.question" class="pb-8 pr-6 w-full" label="Questão" />
          <div class="pb-8 pr-6 w-full">
            <editor
              v-model="formQuestion.additional_text"
              :api-key="`${$inertia.page.props.tinymce_api_key}`"
              plugins="anchor autolink charmap codesample emoticons image link lists searchreplace table visualblocks"
              toolbar="undo redo | fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons | removeformat"
              class="form-textarea"
              :class="{error: formQuestion.errors}"
              :initial-value="formQuestion.additional_text"
              :rows="4"
            />
          </div>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="formQuestion.processing" class="btn-indigo ml-auto" type="submit">Adicionar</loading-button>
        </div>
      </form>
    </div>

    <div class="w-full bg-white rounded-md shadow overflow-hidden mt-8">
      <div v-if="!subject.questions.length">
        <p class="px-6 py-4 border-t" colspan="4">Nenhuma questão por enquanto.</p>
      </div>
      <table v-else class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Questão</th>
          <th class="pb-4 pt-6 px-6">Texto Compl (?)</th>
        </tr>
        <tr v-for="question in subject.questions" :key="question.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/questions/${question.id}/edit`">
              {{ question.question }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/questions/${question.id}/edit`" tabindex="-1">
              {{ !! question.additional_text ? 'Sim' : 'Não' }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/questions/${question.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout.vue'
import Icon from '@/Shared/Icon.vue'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    Editor,
    Head,
    Link,
    LoadingButton,
    TextInput,
    TrashedMessage,
    Icon,
  },
  layout: Layout,
  props: {
    subject: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        name: this.subject.name,
      }),
      formQuestion: this.$inertia.form({
        question: '',
        additional_text: '',
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/subjects/${this.subject.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Deseja relamente remover a disciplina?')) {
        this.$inertia.delete(`/subjects/${this.subject.id}`)
      }
    },
    restore() {
      if (confirm('Deseja realmente restaurar a disciplina?')) {
        this.$inertia.put(`/subjects/${this.subject.id}/restore`)
      }
    },
    storeQuestion() {
      this.formQuestion.post(`/subjects/${this.subject.id}/questions`, {
        onSuccess: () => this.formQuestion.reset(),
      })
    },
  },
}
</script>
