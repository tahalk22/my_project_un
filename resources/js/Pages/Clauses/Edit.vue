<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ElSelect, ElOption } from 'element-plus';
import { toast } from 'vue3-toastify';
import * as constants from '@/JsFiles/constants.js';

defineOptions({ layout: AppLayout });

const props = defineProps({ clause: Object });

const form = useForm({
    id: props.clause.id,
  name: props.clause.name,
  type: props.clause.type,
    additional_fee_per_year:  constants.additional_fee_per_year  , 
});

function Update() {
  form.post(route('Clauses.Update' ), {
    onSuccess: () => toast.success('تم تحديث البند بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء التحديث'),
  });
}
</script>

<template>
  <Head title="تعديل البند التأميني" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">تعديل البند التأميني</h1>
    <hr />
    <br />
    <form @submit.prevent="Update">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- اسم البند -->
        <div>
          <label class="block text-sm font-medium text-gray-700">اسم البند <span class="text-red-500">*</span></label>
          <input v-model="form.name" type="text" required class="input-field" placeholder="اسم البند" />
          <p v-if="form.errors.name" class="error-text">{{ form.errors.name }}</p>
        </div>

        <!-- نوع البند -->
        <div>
          <label class="block text-sm font-medium text-gray-700">نوع البند <span class="text-red-500">*</span></label>
          <el-select v-model="form.type" placeholder="اختر النوع" clearable filterable class="w-full">
            <el-option v-for="(label, key) in constants.clause_type" :key="key" :label="label" :value="parseInt(key)" />
          </el-select>
          <p v-if="form.errors.type" class="error-text">{{ form.errors.type }}</p>
        </div>

                  <div v-if="form.type == 2 ">
            <label class="block text-sm font-medium text-gray-700">  مصاريف سنوية اضافية  <span class="text-red-500">*</span></label>
            <input v-model="form.additional_fee_per_year" type="number" required class="input-field" placeholder="مصرايف اضافية سنوية  "  min="0.0"  step="0.1"/>
            <p v-if="form.errors.additional_fee_per_year" class="error-text">{{ form.errors.additional_fee_per_year }}</p>
          </div>

      </div>

      <div class="mt-10 text-left">

                <Link  :href = "route('Clauses.Index')"   class="px-8 py-3 text-white font-semibold rounded-lg bg-yellow-600 hover:bg-yellow-700 transition duration-200" :disabled="form.processing">
            <fa icon = "arrow-right" /> رجوع
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
.error-text {
  @apply mt-1 text-sm text-red-600;
}
</style>