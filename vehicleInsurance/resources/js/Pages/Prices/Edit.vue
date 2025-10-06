<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: AppLayout });

const props = defineProps({ prices: Object });

const form = useForm({
  id: props.prices.id,
  installment: props.prices.installment,
  tax: props.prices.tax,
  supervision: props.prices.supervision,
  stamp: props.prices.stamp,
  version: props.prices.version,
});

function Update() {
  form.put(route('Prices.Update'), {
    onSuccess: () => toast.success('تم تحديث البيانات بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء التحديث'),
  });
}
</script>

<template>
  <Head title="تعديل الأسعار" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">تعديل الأسعار</h1>
    <hr />
    <br />
    <form @submit.prevent="Update">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
          <label class="block text-sm font-medium text-gray-700">القسط السنوي</label>
          <input v-model="form.installment" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الضريبة</label>
          <input v-model="form.tax" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الإشراف</label>
          <input v-model="form.supervision" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الدمغة</label>
          <input v-model="form.stamp" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الإصدار</label>
          <input v-model="form.version" type="number" step="0.01" class="input-field" required />
        </div>

      </div>

      <div class="mt-10 text-left">
        <Link :href="route('Dashboard')" class="px-8 py-3 text-white font-semibold rounded-lg bg-yellow-600 hover:bg-yellow-700 transition duration-200">
          <fa icon="arrow-right" /> رجوع
        </Link>
        &nbsp;
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? '...جاري التحديث' : 'تحديث البيانات' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition;
}
</style>
