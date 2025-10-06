<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router , usePage  } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ElSelect, ElOption } from 'element-plus';
import { claim_type, claim_status } from '@/JsFiles/constants';

defineOptions({ layout: AppLayout });
const page = usePage().props.auth ;

const props = defineProps({
  results: Array,
  filters: Object,
  users: Array,
  offices: Array,
  total: Number
});

const form = ref({
  insurance_name: props.filters.insurance_name || '',
  plate_number: props.filters.plate_number || '',
  user_id:  parseInt( props.filters.user_id)  || '',
  office_id: parseInt (props.filters.office_id) || '',
  claim_id :  props.filters.claim_id || '',
  insurance_id : props.filters.insurance_id || '',
  claim_type:  parseInt (props.filters.claim_type) || '',
  claim_status:  parseInt(props.filters.claim_status) || '',
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || '',
});

function ApplyFilters () {
 
  
  router.get(route('Reports.ClaimReports'), form.value, {
    preserveState: true,
    replace: true,
  });
}
</script>

<template>
  <Head title="البحث المتقدم عن الوثائق والمطالبات" />

  <div class="p-6  bg-white" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">البحث المتقدم</h1>

    <form @submit.prevent="ApplyFilters" class="bg-white p-6 rounded-xl shadow mb-6 border border-gray-200">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block mb-1 text-sm font-medium">اسم المؤمن</label>
          <input v-model="form.insurance_name" type="text" class="w-full border rounded px-4 py-2" />
        </div>


        <div>
          <label class="block mb-1 text-sm font-medium">رقم المطالبة</label>
          <input v-model="form.claim_id" type="number" class="w-full border rounded px-4 py-2" />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium">رقم الوثيقة</label>
          <input v-model="form.insurance_id" type="number" class="w-full border rounded px-4 py-2" />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium">رقم اللوحة</label>
          <input v-model="form.plate_number" type="text" class="w-full border rounded px-4 py-2" />
        </div>

        <div v-if = "(page.user.user_level <= 2 )">
          <label class="block mb-1 text-sm font-medium">المكتب</label>
          <el-select v-model="form.office_id" clearable filterable class="w-full" placeholder="اختر مكتب">
            <el-option :label="'الكل'" value="" />
            <el-option v-for="office in props.offices" :key="office.id" :label="office.office_name" :value="office.id" />
          </el-select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium">المستخدم</label>
          <el-select v-model="form.user_id" clearable filterable class="w-full" placeholder="اختر مستخدم">
            <el-option :label="'الكل'" value="" />
            <el-option v-for="u in props.users" :key="u.id" :label="u.name" :value="u.id" />
          </el-select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium">نوع المطالبة</label>
          <el-select v-model="form.claim_type" clearable class="w-full" placeholder="اختر النوع" filterable>
            <el-option :label="'الكل'" value="" />
            <el-option v-for="(label, key) in claim_type" :key="key" :label="label" :value="parseInt(key)" />
          </el-select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium">حالة المطالبة</label>
          <el-select v-model="form.claim_status" clearable class="w-full" placeholder="اختر الحالة" filterable>
            <el-option :label="'الكل'" value="" />
            <el-option v-for="(label, key) in claim_status" :key="key" :label="label" :value="parseInt(key)" />
          </el-select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium">من تاريخ</label>
          <input type="date" v-model="form.date_from" class="w-full border rounded px-4 py-2" />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium">إلى تاريخ</label>
          <input type="date" v-model="form.date_to" class="w-full border rounded px-4 py-2" />
        </div>
      </div>

      <div class="mt-4 text-left">
        <button type="submit" class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition">
          بحث
        </button>
      </div>
    </form>

    <!-- عرض عدد النتائج -->
    <div class="mb-4 text-lg font-semibold text-gray-700">
      عدد المطالبات: <span class="text-blue-600 font-bold text-2xl">{{ props.total }}</span>
    </div>

    <!-- جدول النتائج -->
    <div class="bg-white rounded-xl shadow p-4 border border-gray-200">
      <table class="w-full text-sm text-right border-collapse">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2 border">رقم المطالبة</th>
            <th class="p-2 border">رقم الوثيقة</th>
            <th class="p-2 border">اسم المؤمن</th>
            <th class="p-2 border">رقم اللوحة</th>
            <th class="p-2 border">نوع المطالبة</th>
            <th class="p-2 border">الحالة</th>
            <th class="p-2 border">التاريخ</th>
            <th class="p-2 border">المكتب</th>
            <th class="p-2 border">المستخدم</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.results.length === 0">
            <td colspan="8" class="text-center p-4 text-gray-500">لا توجد نتائج.</td>
          </tr>
          <tr v-for="row in props.results" :key="row.id" class="border-t hover:bg-gray-50">
                        <td class="p-2">{{ row.id  }}#</td>
            <td class="p-2">{{ row.policy_number }}#</td>
            <td class="p-2">{{ row.insurance_name }}</td>
            <td class="p-2">{{ row.plate_number }}</td>
            <td class="p-2">{{ claim_type[row.claim_type] || '—' }}</td>
            <td class="p-2"   >  <span  :class = "           row.claim_status === 4 ? 'bg-red-100' :
                row.claim_status === 3 ? 'bg-green-100' :
                row.claim_status === 2 ? 'bg-yellow-100' :
                '' "  class="p-1  rounded-xl"> {{ claim_status[row.claim_status] || '—' }}</span> </td>


            <td class="p-2">{{ row.claim_date?.slice(0, 10) }}</td>
            <td class="p-2">{{ row.office_name }}</td>
            <td class="p-2">{{ row.user_name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
