<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { ElSelect, ElOption } from 'element-plus';
import Pagination from '@/Components/Pagination.vue';

defineOptions({ layout: AppLayout });
const props = defineProps({
  insurances: Object,
  total: Number,
  filters: Object,
  auth: Object,
  users: Array,
  offices: Array
});

const form = ref({
  from_date: props.filters.from_date || '',
  to_date: props.filters.to_date || '',
  user_id: props.filters.user_id || '',
  office_id: props.filters.office_id || '',
  per_page: props.filters.per_page || 10,
});

const canSeeOffice = props.auth?.user?.user_level <= 2;

function search(page = 1) {
  router.get(route('Reports.InsuranceReports'), { ...form.value, page }, {
    preserveState: true,
    replace: true,
  });
}

watch(() => form.value.per_page, () => search());
</script>

<template>
  <Head title="تقرير وثائق التأمين" />

  <div class="p-6 bg-white " dir="rtl">
    <h1 class="text-2xl font-bold mb-4">تقرير وثائق التأمين حسب الفلاتر</h1>

    <!-- نموذج الفلاتر -->
    <form @submit.prevent="search" class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ الإصدار</label>
          <input v-model="form.from_date" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ الإصدار</label>
          <input v-model="form.to_date" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">المستخدم</label>
          <el-select v-model="form.user_id" placeholder="اختر المستخدم" filterable clearable class="w-full">
            <el-option :label="'الكل'" :value="''" />
            <el-option v-for="u in users" :key="u.id" :label="u.name" :value="u.id" />
          </el-select>
        </div>

        <div v-if="canSeeOffice">
          <label class="block text-sm font-medium text-gray-700 mb-1">المكتب</label>
          <el-select v-model="form.office_id" placeholder="اختر المكتب" clearable filterable class="w-full">
            <el-option label="الكل" :value="''" />
            <el-option v-for="office in offices" :key="office.id" :label="office.office_name" :value="office.id" />
          </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">عدد السجلات</label>
          <select v-model="form.per_page" class="w-full py-2 border border-gray-300 rounded-lg">
            <option v-for="n in [10, 25, 50, 100]" :key="n" :value="n">{{ n }}</option>
          </select>
        </div>
      </div>

      <div class="text-left">
        <button type="submit" class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition">بحث</button>
      </div>
    </form>

    <div class="mb-4 text-lg font-semibold text-gray-700 ">
      عدد الوثائق: <span class="text-blue-600 font-bold text-2xl">{{ total }}</span>
    </div>

    <div class="overflow-auto bg-white p-4 rounded-xl shadow border">
      <table class="w-full text-sm text-right border-collapse">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2 border">الاسم</th>
            <th class="p-2 border">رقم اللوحة</th>
            <th class="p-2 border">رقم الهوية</th>
            <th class="p-2 border">الهاتف</th>
            <th class="p-2 border">الموقع</th>
            <th class="p-2 border">رقم الشاسيه</th>
            <th class="p-2 border">القوة</th>
            <th class="p-2 border">عدد الركاب</th>
            <th class="p-2 border">سنة الصنع</th>
            <th class="p-2 border">اللون</th>
            <th class="p-2 border">البلد</th>
            <th class="p-2 border">النوع</th>
            <th class="p-2 border">عدد السنوات</th>
            <th class="p-2 border">البند</th>
            <th class="p-2 border"  >المستخدم</th>
            <th class="p-2 border"  >المكتب</th>
            <th class="p-2 border">تاريخ الإصدار</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="insurances.data.length === 0">
            <td colspan="15" class="text-center p-4 text-gray-500">لا توجد نتائج.</td>
          </tr>
          <tr v-for="ins in insurances.data" :key="ins.id" class="border-t hover:bg-gray-50">
            <td class="p-2">{{ ins.insurance_name }}</td>
            <td class="p-2">{{ ins.plate_number }}</td>
            <td class="p-2">{{ ins.id_number }}</td>
            <td class="p-2">{{ ins.phone }}</td>
            <td class="p-2">{{ ins.insurance_location }}</td>
            <td class="p-2">{{ ins.chassis_number }}</td>
            <td class="p-2">{{ ins.motor_power }}</td>
            <td class="p-2">{{ ins.non_driver_passengers }}</td>
            <td class="p-2">{{ ins.made_year }}</td>
            <td class="p-2">{{ ins.color?.name || '—' }}</td>
            <td class="p-2">{{ ins.country?.name || '—' }}</td>
            <td class="p-2">{{ ins.car_type?.name || '—' }}</td>
            <td class="p-2">{{ ins.years_number }}</td>
            <td class="p-2">{{ ins.clause?.name || '—' }}</td>
            <td class="p-2" >{{ ins.user?.name   }}</td>
            <td class="p-2" >{{ ins.office?.office_name || 'الفرع الرئيسي' }}</td>
            <td class="p-2">{{ ins.version_date?.slice(0, 10) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <Pagination :links="insurances.links" class="mt-6" />
  </div>
</template>