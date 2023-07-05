<template>
  <div>
    <Head title="Editar Questão" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/subjects">Disciplinas </Link>
        <span class="text-indigo-400 font-medium"> / </span>
        <Link class="text-indigo-400 hover:text-indigo-600" :href="`/subjects/${question.subject.id}/edit`">{{ question.subject.name }} </Link>
        <span class="text-indigo-400 font-medium"> / </span>
        {{ question.question }}
      </h1>
    </div>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden mt-8">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.question" :error="form.errors.question" class="pb-8 pr-6 w-full" label="Questão" />
          <div class="pb-8 pr-6 w-full">
            <editor
              v-model="form.additional_text"
              :api-key="`${$inertia.page.props.tinymce_api_key}`"
              plugins="anchor autolink charmap codesample emoticons image link lists searchreplace table visualblocks"
              toolbar="undo redo | fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons | removeformat"
              class="form-textarea"
              :class="{error: form.errors}"
              :initial-value="form.additional_text"
              :rows="4"
            />
          </div>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Atualizar</loading-button>
        </div>
      </form>
    </div>

    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden mt-8">
      <form @submit.prevent="storeAnswer">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="formAnswer.answer" :error="formAnswer.errors.answer" class="pb-8 pr-6 w-full" label="Resposta" />
          <select-input v-model="formAnswer.is_correct" :error="formAnswer.errors.is_correct" class="pb-8 pr-6 w-full" label="Correto">
            <option value="0">Não</option>
            <option value="1">Sim</option>
          </select-input>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="formAnswer.processing" class="btn-indigo ml-auto" type="submit">Adicionar</loading-button>
        </div>
      </form>
    </div>

    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden mt-8">
      <div v-if="!question.answers.length">
        <p class="px-6 py-4 border-t" colspan="4">Nenhuma questão por enquanto.</p>
      </div>
      <table v-else class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Resposta</th>
          <th class="pb-4 pt-6 px-6">Correta (?)</th>
        </tr>
        <tr v-for="answer in question.answers" :key="answer.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500">
              {{ answer.answer }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" tabindex="-1">
              {{ !! answer.is_correct ? 'Sim' : 'Não' }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" tabindex="-1" @click.prevent="removeAnswer(answer.id)">
              <svg height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                <g id="SVGRepo_iconCarrier">
                  <path d="M8 1.5V2.5H3C2.44772 2.5 2 2.94772 2 3.5V4.5C2 5.05228 2.44772 5.5 3 5.5H21C21.5523 5.5 22 5.05228 22 4.5V3.5C22 2.94772 21.5523 2.5 21 2.5H16V1.5C16 0.947715 15.5523 0.5 15 0.5H9C8.44772 0.5 8 0.947715 8 1.5Z" fill="#334155" />
                  <path d="M3.9231 7.5H20.0767L19.1344 20.2216C19.0183 21.7882 17.7135 23 16.1426 23H7.85724C6.28636 23 4.98148 21.7882 4.86544 20.2216L3.9231 7.5Z" fill="#334155" />
                </g>
              </svg>
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
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    Editor,
    Head,
    Link,
    LoadingButton,
    TextInput,
    SelectInput,
  },
  layout: Layout,
  props: {
    question: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        question: this.question.question,
        additional_text: this.question.additional_text,
      }),
      formAnswer: this.$inertia.form({
        answer: '',
        is_correct: 0,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/questions/${this.question.id}`)
    },
    storeAnswer() {
      this.formAnswer.post(`/questions/${this.question.id}/answers`, {
        onSuccess: () => this.formAnswer.reset(),
      })
    },
    removeAnswer(id) {
      if (confirm ('Tem certeza que deseja remover?')) {
        this.formAnswer.delete(`/answers/${id}`)
      }
    },
  },
}
</script>
