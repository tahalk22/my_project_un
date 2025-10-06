<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import { toast } from 'vue3-toastify';
import { inject } from 'vue';
import { ElSelect, ElOption } from 'element-plus';

const swal = inject('$swal');

const props = defineProps({
  carTypes: Object,
  countries: Array,
  filters: Object,
});

defineOptions({ layout: AppLayout });

const open_index = ref(null);

const form = ref({
  name: props.filters.name || '',
  country_id:  parseInt(props.filters.country_id) || '',
});

function ApplyFilters() {
  router.get(route('CarTypes.Index'), form.value, {
    preserveState: true,
    replace: true,
  });
}

function DeleteCarType(carType) {
  swal.fire({
    title: `حذف النوع؟`,
    html: `سيتم حذف نوع السيارة <strong class=\"text-blue-500\">${carType.name}</strong> نهائيًا.<br>هل أنت متأكد؟`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: 'red',
    cancelButtonColor: 'gray',
    cancelButtonText: 'إلغاء',
    confirmButtonText: 'نعم، حذف',
    preConfirm: () => {
      router.delete(route('CarTypes.Delete', { id: carType.id }), {
        preserveState: true,
        onSuccess: () => toast.success('تم حذف النوع بنجاح'),
        onError: () => toast.error('حدث خطأ أثناء الحذف'),
      });
    }
  });
}
</script>

<template>
  <Head title="أنواع السيارات" />
  <div class="mx-auto px-4 py-8 w-full">
    <h1 class="text-3xl font-bold text-blue-800 mb-6 pb-3 border-b border-gray-200">عرض أنواع السيارات</h1>

    <form class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200" @submit.prevent="ApplyFilters">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
          <input v-model="form.name" type="text" placeholder="ابحث بالاسم..." class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">الدولة</label>
          <el-select v-model="form.country_id" placeholder="الكل" clearable filterable class="w-full">
            <el-option label="الكل" :value="''" />
            <el-option v-for="country in countries" :key="country.id" :label="country.name" :value="country.id" />
          </el-select>
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
              <th class="px-6 py-3">النوع</th>
              <th class="px-6 py-3">الدولة</th>
              <th class="px-6 py-3">العمليات</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(carType, index) in carTypes.data" :key="carType.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ carType.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">{{ carType.country?.name || '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700">
                <div class="relative inline-block text-left pl-[40px]">
                  <button @click="open_index = open_index === index ? null : index" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <fa icon="ellipsis-vertical" /> العمليات
                  </button>

                  <div v-if="open_index === index" class="absolute z-10 right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <ul class="py-1 text-sm text-gray-700">
                      <li>
                        <Link :href="route('CarTypes.Edit', { id: carType.id })">
                          <button class="w-full text-right px-4 py-2 hover:bg-gray-100">
                            <fa class="ml-1 text-blue-500" :icon="'edit'" /> تعديل
                          </button>
                        </Link>
                      </li>
                      <li>
                        <button @click="DeleteCarType(carType)" class="w-full text-right px-4 py-2 hover:bg-gray-100 text-red-600">
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
      <Pagination :links="carTypes.links" :from="carTypes.from" :to="carTypes.to" :total="carTypes.total" :currentPage="carTypes.current_page" :lastPage="carTypes.last_page" />
    </div>
  </div>
</template>