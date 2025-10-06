<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ElSelect, ElOption, ElDatePicker } from 'element-plus';
import { inject } from 'vue';
import Pagination from '@/Components/Pagination.vue';
 import * as constants from '@/JsFiles/constants.js';





defineOptions({ layout: AppLayout });

const swal = inject('$swal');

const props = defineProps({
  insurances: Object,
  filters: Object,
  offices: Array,
  users: Array,
});
const open_index = ref('') ;
const auth_user = usePage().props.auth?.user || {};

const form = ref({
  insurance_name: props.filters.insurance_name || '',
  office_id:  parseInt (props.filters.office_id) || '',
  user_id:  parseInt(props.filters.user_id) || '',
  from_date: props.filters.from_date || '',
  to_date: props.filters.to_date || '',
  per_page: props.filters.per_page || 10,
});

const per_page_options = [10, 25, 50, 100];

function ApplyFilters() {
  router.get(route('Insurances.Index'), form.value, {
    preserveState: true,
    replace: true,
  });
}
</script>

<template>
  <Head title="وثائق التأمين" />
  <div class="mx-auto px-4 py-8 w-full">
    <h1 class="text-3xl font-bold text-blue-800 mb-6 pb-3 border-b border-gray-200">إدارة وثائق التأمين</h1>

    <form class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200" @submit.prevent="ApplyFilters">
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">اسم المؤمن</label>
          <input v-model="form.insurance_name" type="text" placeholder="ابحث بالاسم..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ الإصدار</label>
          <input v-model="form.from_date" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ الإصدار</label>
          <input v-model="form.to_date" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div  >
          <label class="block text-sm font-medium text-gray-700 mb-1">المستخدم</label>
          
            <el-select v-model="form.user_id" placeholder="اختر المستخدم" filterable clearable class="w-full">
             <el-option  :label="'الكل'" :value="''" />
          <el-option
            v-for="u in props.users"
            :key="u.id"
            :label="` ${u.name}  - ${constants.user_level[u.user_level]}    `"
            :value="u.id"
          />
        </el-select>
        </div>
        <div v-if="auth_user.user_level <= 2">
          <label class="block text-sm font-medium text-gray-700 mb-1">المكتب</label>
          <el-select v-model="form.office_id" placeholder="اختر المكتب" clearable filterable class="w-full">
            <el-option label="الكل" :value="''" />
            <el-option v-for="office in offices" :key="office.id" :label="office.office_name" :value="office.id" />
          </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">عدد السجلات</label>
          <select v-model="form.per_page" @change="ApplyFilters" class="w-full py-2 border border-gray-300 rounded-lg">
            <option v-for="n in per_page_options" :key="n" :value="n">{{ n }}</option>
          </select>
        </div>
      </div>

      <div class="text-left">
        <button type="submit" class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition">بحث</button>
      </div>
    </form>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
      <div class="overflow-x-auto table_container">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-blue-800">
            <tr class="text-right text-white text-xs font-medium">
              <th class="px-6 py-3">رقم الوثيقة</th>
              <th class="px-6 py-3">اسم المؤمن</th>

              <th class="px-6 py-3"> السكن</th>
              <th class="px-6 py-3"> الهاتف</th>
              <th class="px-6 py-3">  نوع إثبات الهوية</th>
              <th class="px-6 py-3"> رقم الهوية</th>
              <th class="px-6 py-3">تاريخ الإصدار</th>
              <th class="px-6 py-3">  منذ ظهر يوم</th>
              <th class="px-6 py-3">الى ظهر يوم    </th>
              <th class="px-6 py-3">نوع السيارة</th>
              <th class="px-6 py-3">المكتب</th>
              <th class="px-6 py-3">المستخدم</th>
              <th class="px-6 py-3">الإجمالي</th>
              <th class="px-6 py-3">عدد المطالبات </th>
              <th class="px-6 py-3">العمليات</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="insurance in insurances.data" :key="insurance.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm text-gray-800">{{ insurance.id }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ insurance.insurance_name }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ insurance.insurance_location }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ insurance.phone }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ constants.id_types[insurance.id_type] }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ insurance.id_number }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.version_date }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.from_date }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.to_date }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.car_type?.name || '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.office?.office_name || 'الفرع الرئيسي' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.user?.name || '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.total }} د.ل</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ insurance.claims_count  }}  </td>
             <td class="px-6 py-4 text-sm text-gray-700">
                  <div class="relative inline-block text-left pl-[40px] dropdown_container">
                    <button @click="open_index = open_index === insurance.id ? null : insurance.id" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                      <fa icon="ellipsis-vertical" /> العمليات
                    </button>

                    <div v-if="open_index === insurance.id" class="absolute z-10 right-[0px] mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                      <ul class="py-1 text-sm text-gray-700">
                        <li>
                          <Link :href="route('Insurances.Show', { id: insurance.id })">
                            <button class="w-full text-right px-4 py-2 hover:bg-gray-100">
                                 <fa icon="print" class="ml-1 text-green-600" />  عرض وطباعه
                            </button>
                          </Link>
                        </li>
                        <li> 
                            <button class="w-full text-right px-4 py-2 hover:bg-gray-100">
                              <Link :href = "route('Claims.Index' , {insurance_id : insurance.id })" >
                                  <fa icon="eye" class="ml-1 text-blue-600" />  عرض المطالبات
                              </Link> 
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

      <Pagination :links="insurances.links" :from="insurances.from" :to="insurances.to" :total="insurances.total" :currentPage="insurances.current_page" :lastPage="insurances.last_page" />
    </div>
  </div>
</template>
