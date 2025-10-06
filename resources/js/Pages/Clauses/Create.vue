<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';
import * as constants from '@/JsFiles/constants.js';

defineOptions({ layout: AppLayout });

const form = useForm({
  type: '',
  name: '' , 
  additional_fee_per_year:   constants.additional_fee_per_year 
});

function Store() {
  form.post(route('Clauses.Store'), {
    onSuccess: () => toast.success('تمت إضافة البند بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء الحفظ'),
  });
}
</script>

<template>
  <Head title="إضافة بند تأميني" />

  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">نموذج إضافة بند تأميني</h1>
    <hr /><br />

    <form @submit.prevent="Store()">
      <section>
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
            <el-select v-model="form.type" placeholder="اختر نوع البند" class="w-full" clearable filterable>
              <el-option
                v-for="(label, key) in constants.clause_type"
                :key="key"
                :label="label"
                :value="parseInt(key)"
              />
            </el-select>
            <p v-if="form.errors.type" class="error-text">{{ form.errors.type }}</p>
          </div>



          <div v-if="form.type == 2 ">
            <label class="block text-sm font-medium text-gray-700">  مصاريف سنوية اضافية  <span class="text-red-500">*</span></label>
            <input v-model="form.additional_fee_per_year" type="number" required class="input-field" placeholder="مصرايف اضافية سنوية  "  min="0.0"  step="0.1"/>
            <p v-if="form.errors.additional_fee_per_year" class="error-text">{{ form.errors.additional_fee_per_year }}</p>
          </div>

        </div>
      </section>

      <div class="mt-10 text-left">
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? "...جاري الحفظ" : "حفظ البيانات" }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition;
}
.error-text {
  @apply mt-1 text-sm text-red-600;
}
</style>
