<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ElSelect, ElOption } from 'element-plus';
import Pagination from '@/Components/Pagination.vue';
import * as constants from '@/JsFiles/constants.js';
import { toast } from 'vue3-toastify';
import { inject } from 'vue'; 

const swal = inject('$swal');

const props = defineProps({
  clauses: Object,
  filters: Object
});

defineOptions({ layout: AppLayout });

const form = ref({
  name: props.filters.name || '',
  type: props.filters.type || '',
  per_page: props.filters.per_page || 10,
});

const open_index = ref(null);
const per_page_options = [10, 25, 50, 100];

function ApplyFilters() {
  router.get(route('Clauses.Index'), form.value, {
    preserveState: true,
    replace: true,
  });
}

function DeleteClause(clause) {
  swal.fire({
    title: `حذف البند؟`,
    html: `سيتم حذف البند <strong class=\"text-blue-500\">${clause.name}</strong> نهائيًا.<br>هل أنت متأكد؟`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: 'red',
    cancelButtonColor: 'gray',
    cancelButtonText: 'إلغاء',
    confirmButtonText: 'نعم، حذف',
    preConfirm: () => {
      router.delete(route('Clauses.Delete', { id: clause.id }), {
        preserveState: true,
        onSuccess: () => toast.success('تم حذف البند بنجاح'),
        onError: () => toast.error('حدث خطأ أثناء الحذف'),
      });
    }
  });
}
</script>

<template>
  <Head title="البنود التأمينية" />
  <div class="mx-auto px-4 py-8 w-full">
    <h1 class="text-3xl font-bold text-blue-800 mb-6 pb-3 border-b border-gray-200">عرض البنود التأمينية</h1>

    <form class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200" @submit.prevent="ApplyFilters">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
          <input v-model="form.name" type="text" placeholder="ابحث بالاسم..." class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">نوع البند</label>
          <el-select v-model="form.type" placeholder="الكل" clearable filterable class="w-full">
            <el-option label="الكل" :value="''" />
            <el-option v-for="(label, key) in constants.clause_type" :key="key" :label="label" :value="key" />
          </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">عدد النتائج</label>
          <select v-model="form.per_page" @change="ApplyFilters" class="w-full py-2 border border-gray-300 rounded-lg">
            <option v-for="opt in per_page_options" :key="opt" :value="opt">{{ opt }}</option>
          </select>
        </div>
      </div>

      <div class="text-left mt-4">
        <button type="submit" class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition">بحث</button>
      </div>
    </form>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
      <div class="overflow-x-auto table_container">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-blue-800">
            <tr class="text-right text-white text-xs font-medium">
              <th class="px-6 py-3">اسم البند</th>
              <th class="px-6 py-3">النوع</th>
              <th class="px-6 py-3">مصرايف اضافية سنوية </th>
              <th class="px-6 py-3">العمليات</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(clause, index) in clauses.data" :key="clause.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ clause.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ constants.clause_type[clause.type] }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ clause.additional_fee_per_year }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">
                <div class="relative inline-block text-left pl-[40px]">
                  <button @click="open_index = open_index === index ? null : index" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <fa icon="ellipsis-vertical" /> العمليات
                  </button>

                  <div v-if="open_index === index" class="absolute z-10 right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <ul class="py-1 text-sm text-gray-700">
                      <li>
                        <Link :href="route('Clauses.Edit', { id: clause.id })">
                          <button class="w-full text-right px-4 py-2 hover:bg-gray-100">
                            <fa class="ml-1 text-blue-500" :icon="'edit'" /> تعديل
                          </button>
                        </Link>
                      </li>
                      <li>
                        <button @click="DeleteClause(clause)" class="w-full text-right px-4 py-2 hover:bg-gray-100 text-red-600">
                          <fa class="ml-1" icon="trash-can" /> حذف
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :links="clauses.links" :from="clauses.from" :to="clauses.to" :total="clauses.total" :currentPage="clauses.current_page" :lastPage="clauses.last_page" />
    </div>
  </div>
</template>