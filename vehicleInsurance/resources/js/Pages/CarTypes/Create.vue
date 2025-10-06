<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';

defineOptions({ layout: AppLayout });

const props = defineProps({ countries: Array });

const form = useForm({
  name: '',
  country_id: '',
});

function Store() {
  form.post(route('CarTypes.Store'), {
    onSuccess: () => toast.success('تمت إضافة نوع السيارة بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء الحفظ'),
  });
}
</script>

<template>
  <Head title="إضافة نوع سيارة" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">إضافة نوع سيارة</h1>
    <hr />
    <br />
    <form @submit.prevent="Store">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- الاسم -->
        <div>
          <label class="block text-sm font-medium text-gray-700">اسم النوع <span class="text-red-500">*</span></label>
          <input v-model="form.name" type="text" required class="input-field" placeholder="مثال: شاحنة، صالون..." />
          <p v-if="form.errors.name" class="error-text">{{ form.errors.name }}</p>
        </div>

        <!-- الدولة -->
        <div>
          <label class="block text-sm font-medium text-gray-700">الدولة <span class="text-red-500">*</span></label>
          <el-select v-model="form.country_id" placeholder="اختر الدولة" clearable filterable class="w-full">
            <el-option v-for="country in countries" :key="country.id" :label="country.name" :value="country.id" />
          </el-select>
          <p v-if="form.errors.country_id" class="error-text">{{ form.errors.country_id }}</p>
        </div>

      </div>

      <div class="mt-10 text-left">
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? '...جاري الحفظ' : 'حفظ النوع' }}
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