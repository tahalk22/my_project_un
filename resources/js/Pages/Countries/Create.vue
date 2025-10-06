<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

defineOptions({ layout: AppLayout });

const form = useForm({
  name: ''
});

function Store() {
  form.post(route('Countries.Store'), {
    onSuccess: () => toast.success('تمت إضافة البلد  بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء الحفظ'),
  });
}
</script>

<template>
  <Head title="إضافة بلد" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">إضافة بلد جديدة  </h1>
    <hr />
    <br />
    <form @submit.prevent="Store">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">اسم البلد <span class="text-red-500">*</span></label>
          <input v-model="form.name" type="text" required class="input-field" placeholder="اسم البلد" />
          <p v-if="form.errors.name" class="error-text">{{ form.errors.name }}</p>
        </div>
      </div>

      <div class="mt-10 text-left">
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? '...جاري الحفظ' : 'حفظ البلد' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition;
}
.error-text {
  @apply mt-1 text-sm text-red-600;
}
</style>
