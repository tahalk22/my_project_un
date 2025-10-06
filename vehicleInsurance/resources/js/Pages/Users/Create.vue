<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';
import * as constants from '@/JsFiles/constants.js';

const props = defineProps({
  offices: Array,
});

const user = usePage().props.auth?.user || {};

defineOptions({ layout: AppLayout });

const form = useForm({
  name: 's1',
  email: 's1@gmail.com',
  password: '123',
  password_confirmation: '123',
  phone: '091010101',
  location: 'سوق الجمعه',
 
  company_id: 1,
  office_id: null,
  user_level: '',
});

function Store() {
  form.post(route('Users.Store'), {
    onSuccess: () => toast.success('تم إضافة المستخدم بنجاح'),
    onError: () => toast.error('حدث خطأ أثناء الحفظ'),
  });
}
</script>

<template>
  <Head title="إضافة مستخدم جديد" />
  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right  mb-6">نموذج إضافة مستخدم جديد</h1>
    <hr />  <br  />
    <form @submit.prevent="Store()">
      <section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">الاسم <span class="text-red-500">*</span></label>
            <input v-model="form.name" type="text" required class="input-field" placeholder="اسم المستخدم" />
            <p v-if="form.errors.name" class="error-text">{{ form.errors.name }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني <span class="text-red-500">*</span></label>
            <input v-model="form.email" type="email" required class="input-field" placeholder="example@domain.com" />
            <p v-if="form.errors.email" class="error-text">{{ form.errors.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">كلمة المرور <span class="text-red-500">*</span></label>
            <input v-model="form.password" type="password" required class="input-field" placeholder="••••••" />
            <p v-if="form.errors.password" class="error-text">{{ form.errors.password }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
            <input v-model="form.password_confirmation" type="password" required class="input-field" placeholder="••••••" />
            <p v-if="form.errors.password_confirmation" class="error-text">{{ form.errors.password_confirmation }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">رقم الهاتف <span class="text-red-500">*</span></label>
            <input v-model="form.phone" type="text" required class="input-field" placeholder="رقم الهاتف" />
            <p v-if="form.errors.phone" class="error-text">{{ form.errors.phone }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">الموقع</label>
            <textarea v-model="form.location" rows="3" class="input-field" placeholder="موقع المستخدم"></textarea>
            <p v-if="form.errors.location" class="error-text">{{ form.errors.location }}</p>
          </div>

      

       <!-- مستوى المستخدم -->
       <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">الصلاحية <span class="text-red-500">*</span></label>
            <el-select v-model="form.user_level" placeholder="اختر الصلاحية" class="w-full" filterable>
              <el-option
                v-for="(label, key) in constants.user_level"
                :key="key"
                :label="label"
                :value="parseInt(key)"
                v-show="parseInt(key) >= user.user_level"
              />
            </el-select>
            <p v-if="form.errors.user_level" class="error-text">{{ form.errors.user_level }}</p>
          </div>

              <!-- المكتب -->            
              <div class="md:col-span-2" v-if="(form.user_level === 3 || form.user_level === 4)  &&  user.user_level < 3 " >
            <label class="block text-sm font-medium text-gray-700">المكتب <span class="text-red-500">*</span></label>
            <el-select
            t v-model="form.office_id" 
            placeholder="اختر المكتب"
             clearable filterable
             class="w-full">
              <el-option v-for="office in props.offices" :key="office.id" :label="office.office_name" :value="office.id" />
            </el-select>
            <p v-if="form.errors.office_id" class="error-text">{{ form.errors.office_id }}</p>
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
