<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';

defineOptions({ layout: AppLayout });

const props = defineProps({
  car_type: Object,
  countries: Array
});

const form = useForm({
  id: props.car_type.id,
  name: props.car_type.name,
  country_id:  parseInt(props.car_type.country_id) ,
});

function Update() {
  form.put(route('CarTypes.Update'), {
    onSuccess: () => toast.success('تم تحديث النوع بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء التحديث'),
  });
}
</script>

<template>
  <Head title="تعديل نوع السيارة" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">تعديل نوع السيارة</h1>
    <hr />
    <br />
    <form @submit.prevent="Update">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- الاسم -->
        <div>
          <label class="block text-sm font-medium text-gray-700">اسم النوع <span class="text-red-500">*</span></label>
          <input v-model="form.name" type="text" required class="input-field" placeholder="اسم النوع" />
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
        <Link :href="route('CarTypes.Index')" class="px-8 py-3 text-white font-semibold rounded-lg bg-yellow-600 hover:bg-yellow-700 transition duration-200">
          <fa icon="arrow-right" /> رجوع
        </Link>
        &nbsp;
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? '...جاري التحديث' : 'تحديث النوع' }}
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