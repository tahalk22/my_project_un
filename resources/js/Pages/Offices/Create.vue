<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { BuildingOfficeIcon, PhoneIcon, MapPinIcon } from '@heroicons/vue/24/outline';
//   import { ElSelect, ElOption } from 'element-plus';
import { toast } from 'vue3-toastify'

defineOptions({ layout: AppLayout });

const props = defineProps({
  cities: Array,
});

const form = useForm({
  office_name: 'مكتب 1',
  manager_name: 'مدير مكتب 1 ',
  phone: '092407112',
  email: 's@gmail.com',
  city_id: 1 ,
  location: 'جزيرة النخيل'
});


function Store() {
form.post(route('Offices.Store'), {
  onSuccess: () => {
    toast.success('تمت إضافة المكتب بنجاح');
  },
  onError: () => {
    toast.error('حدث خطأ أثناء حفظ البيانات');
  },
});
}
</script>


<template>
    <Head title="إضافة مكتب جديد" />
  
    <div class=" w-full mx-left  py-10 px-10  bg-white  " dir="rtl">
      <h1 class="text-3xl font-bold text-center mb-6">نموذج إضافة مكتب جديد</h1>
  
      <form @submit.prevent="Store()">
        <section>
          <div class="flex items-center gap-2 mb-4">
            <fa icon='building' class="w-5 h-5 text-current" />
            <h2 class="text-xl font-semibold">بيانات المكتب</h2>
          </div>
  
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- اسم المكتب -->
            <div>
              <label class="block text-sm font-medium text-gray-700">اسم المكتب <span class="text-red-500">*</span></label>
              <input 
                v-model="form.office_name" 
                type="text" 
                required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="أدخل اسم المكتب"
              />
              <p v-if="form.errors.office_name" class="mt-1 text-sm text-red-600">{{ form.errors.office_name }}</p>
            </div>
  
            <!-- اسم المدير -->
            <div>
              <label class="block text-sm font-medium text-gray-700">اسم المدير <span class="text-red-500">*</span></label>
              <input 
                v-model="form.manager_name" 
                type="text" 
                required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="أدخل اسم المدير"
              />
              <p v-if="form.errors.manager_name" class="mt-1 text-sm text-red-600">{{ form.errors.manager_name }}</p>
            </div>
  
            <!-- رقم الهاتف -->
            <div>
              <label class="block text-sm font-medium text-gray-700">رقم الهاتف <span class="text-red-500">*</span></label>
              <input 
                v-model="form.phone" 
                type="tel" 
                required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-right"
                placeholder="رقم الهاتف"
              />
              <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
            </div>
  
            <!-- البريد الإلكتروني -->
            <div>
              <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
              <input 
                v-model="form.email" 
                type="email" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="example@domain.com"
              />
              <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>
  
            <!-- المدينة باستخدام el-select -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700">المدينة <span class="text-red-500">*</span></label>
              <el-select 
                v-model="form.city_id" 
                placeholder="اختر المدينة" 
                filterable 
                class="w-full  "
              >
                <el-option
                  v-for="city in props.cities"
                  :key="city.id"
                  :label="city.name"
                  :value="city.id"
                />
              </el-select>
              <p v-if="form.errors.city_id" class="mt-1 text-sm text-red-600">{{ form.errors.city_id }}</p>
            </div>
  
            <!-- الموقع الجغرافي -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700">الموقع الجغرافي</label>
              <textarea 
                v-model="form.location" 
                rows="3" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="وصف الموقع أو إحداثياته"
              ></textarea>
              <p v-if="form.errors.location" class="mt-1 text-sm text-red-600">{{ form.errors.location }}</p>
            </div>
          </div>
        </section>
  
        <!-- زر الإرسال -->
        <div class="mt-10 text-left">
          <button
            type="submit"
            class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200"
            :disabled="form.processing"
          >
            {{ form.processing ? "...جاري الحفظ" : "حفظ البيانات" }}
          </button>
        </div>
      </form>
    </div>
  </template>
  
 