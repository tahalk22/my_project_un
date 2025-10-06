<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';
import * as constants from '@/JsFiles/constants.js';
import { reactive, nextTick } from 'vue';

const props = defineProps({
  offices: Array,
});

const user = usePage().props.auth?.user || {};
defineOptions({ layout: AppLayout });

/* نموذج البيانات */
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  phone: '',
  location: '',
  company_id: 1,
  office_id: null,
  user_level: '',
});

/* مجـموع أخطاء التحقق */
const validationErrors = reactive({});

/* دالة لإضافة/إعادة تشغيل الاهتزاز */
const shakeField = (selector) => {
  nextTick(() => {
    const el = document.querySelector(selector);
    if (el) {
      el.classList.remove('shake');
      // إجبار المتصفح على إعادة الحساب لبدء الأنيميشن من جديد
      void el.offsetWidth;
      el.classList.add('shake');
    }
  });
};

/* التحقق من الحقول عند الضغط على زر الحفظ */
function validateFields() {
  let ok = true;

  /* الاسم */
  if (!form.name) {
    validationErrors.name = 'الاسم مطلوب';
    shakeField('input[name="name"]');
    ok = false;
  } else {
    validationErrors.name = '';
  }

  /* البريد */
  if (!form.email) {
    validationErrors.email = 'البريد الإلكتروني مطلوب';
    shakeField('input[name="email"]');
    ok = false;
  } else if (!/^\S+@\S+\.\S+$/.test(form.email)) {
    validationErrors.email = 'صيغة البريد غير صالحة';
    shakeField('input[name="email"]');
    ok = false;
  } else {
    validationErrors.email = '';
  }

  /* كلمة المرور */
  if (!form.password) {
    validationErrors.password = 'كلمة المرور مطلوبة';
    shakeField('input[name="password"]');
    ok = false;
  } else if (form.password.length < 6) {
    validationErrors.password = 'كلمة المرور قصيرة (6 أحرف على الأقل)';
    shakeField('input[name="password"]');
    ok = false;
  } else {
    validationErrors.password = '';
  }

  /* تأكيد كلمة المرور */
  if (form.password_confirmation !== form.password) {
    validationErrors.password_confirmation = 'الرمزين غير متطابقين';
    shakeField('input[name="password_confirmation"]');
    ok = false;
  } else {
    validationErrors.password_confirmation = '';
  }

  /* الهاتف */
  if (!form.phone) {
    validationErrors.phone = 'رقم الهاتف مطلوب';
    shakeField('input[name="phone"]');
    ok = false;
  } else if (!/^\d{9,15}$/.test(form.phone)) {
    validationErrors.phone = 'رقم الهاتف غير صالح';
    shakeField('input[name="phone"]');
    ok = false;
  } else {
    validationErrors.phone = '';
  }

  /* الصلاحية */
  if (form.user_level === '') {
    validationErrors.user_level = 'يرجى اختيار الصلاحية';
    shakeField('.select-user-level .el-input__wrapper');
    ok = false;
  } else {
    validationErrors.user_level = '';
  }

  /* المكتب (عند الحاجة) */
  if ((form.user_level === 3 || form.user_level === 4) && user.user_level < 3) {
    if (!form.office_id) {
      validationErrors.office_id = 'يرجى اختيار المكتب';
      shakeField('.select-office .el-input__wrapper');
      ok = false;
    } else {
      validationErrors.office_id = '';
    }
  } else {
    validationErrors.office_id = '';
  }

  return ok;
}

/* إرسال النموذج */
function Store() {
  if (!validateFields()) {
    toast.error('فضلاً صحّح الأخطاء قبل المتابعة');
    return;
  }

  form.post(route('Users.Store'), {
    onSuccess: () => toast.success('تم إضافة المستخدم بنجاح'),
    onError: ()   => toast.error('حدث خطأ أثناء الحفظ'),
  });
}
</script>

<template>
  <Head title="إضافة مستخدم جديد" />
  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-3xl font-bold text-right mb-6">نموذج إضافة مستخدم جديد</h1>
    <hr class="mb-6" />

    <form @submit.prevent="Store">
      <section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- الاسم -->
          <div>
            <label class="label">الاسم <span class="text-red-500">*</span></label>
            <input
              name="name"
              v-model="form.name"
              type="text"
              :class="[
                'input-field',
                validationErrors.name ? 'border-red-500' :
                form.name ? 'border-green-500' : ''
              ]"
              placeholder="اسم المستخدم"
            />
            <p v-if="validationErrors.name" class="error-text">{{ validationErrors.name }}</p>
          </div>

          <!-- البريد -->
          <div>
            <label class="label">البريد الإلكتروني <span class="text-red-500">*</span></label>
            <input
              name="email"
              v-model="form.email"
              type="email"
              :class="[
                'input-field',
                validationErrors.email ? 'border-red-500' :
                form.email ? 'border-green-500' : ''
              ]"
              placeholder="example@domain.com"
            />
            <p v-if="validationErrors.email" class="error-text">{{ validationErrors.email }}</p>
          </div>

          <!-- كلمة المرور -->
          <div>
            <label class="label">كلمة المرور <span class="text-red-500">*</span></label>
            <input
              name="password"
              v-model="form.password"
              type="password"
              :class="[
                'input-field',
                validationErrors.password ? 'border-red-500' :
                form.password ? 'border-green-500' : ''
              ]"
              placeholder=""
            />
            <p v-if="validationErrors.password" class="error-text">{{ validationErrors.password }}</p>
          </div>

          <!-- تأكيد كلمة المرور -->
          <div>
            <label class="label">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
            <input
              name="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              :class="[
                'input-field',
                validationErrors.password_confirmation ? 'border-red-500' :
                form.password_confirmation ? 'border-green-500' : ''
              ]"
              placeholder="••••••"
            />
            <p v-if="validationErrors.password_confirmation" class="error-text">{{ validationErrors.password_confirmation }}</p>
          </div>

          <!-- الهاتف -->
          <div>
            <label class="label">رقم الهاتف <span class="text-red-500">*</span></label>
            <input
              name="phone"
              v-model="form.phone"
              type="text"
              :class="[
                'input-field',
                validationErrors.phone ? 'border-red-500' :
                form.phone ? 'border-green-500' : ''
              ]"
              placeholder="رقم الهاتف"
            />
            <p v-if="validationErrors.phone" class="error-text">{{ validationErrors.phone }}</p>
          </div>

          <!-- الموقع -->
          <div class="md:col-span-2">
            <label class="label">الموقع</label>
            <textarea
              v-model="form.location"
              rows="3"
              class="input-field"
              placeholder="موقع المستخدم"
            />
          </div>

          <!-- الصلاحية -->
          <div class="md:col-span-2">
            <label class="label">الصلاحية <span class="text-red-500">*</span></label>
            <el-select
              v-model="form.user_level"
              placeholder="اختر الصلاحية"
              class="w-full select-user-level"
              filterable
              :class="{
                'border-red-500': validationErrors.user_level,
                'border-green-500': form.user_level && !validationErrors.user_level
              }"
            >
              <el-option
                v-for="(label, key) in constants.user_level"
                :key="key"
                :label="label"
                :value="parseInt(key)"
                v-show="parseInt(key) >= user.user_level"
              />
            </el-select>
            <p v-if="validationErrors.user_level" class="error-text">{{ validationErrors.user_level }}</p>
          </div>

          <!-- المكتب -->
          <div
            class="md:col-span-2"
            v-if="(form.user_level === 3 || form.user_level === 4) && user.user_level < 3"
          >
            <label class="label">المكتب <span class="text-red-500">*</span></label>
            <el-select
              v-model="form.office_id"
              placeholder="اختر المكتب"
              clearable
              filterable
              class="w-full select-office"
              :class="{
                'border-red-500': validationErrors.office_id,
                'border-green-500': form.office_id && !validationErrors.office_id
              }"
            >
              <el-option
                v-for="office in props.offices"
                :key="office.id"
                :label="office.office_name"
                :value="office.id"
              />
            </el-select>
            <p v-if="validationErrors.office_id" class="error-text">{{ validationErrors.office_id }}</p>
          </div>
        </div>
      </section>

      <div class="mt-10 text-left">
        <button
          type="submit"
          class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200"
          :disabled="form.processing"
        >
          {{ form.processing ? '...جاري الحفظ' : 'حفظ البيانات' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
/* حقول الإدخال العامة */
.input-field {
  @apply w-full px-4 py-2 border rounded-lg focus:ring-2 transition duration-150 ease-in-out;
}

/* التسمية */
.label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}

/* نصّ الخطأ */
.error-text {
  @apply mt-1 text-sm text-red-600;
}

/* تأثير الاهتزاز */
@keyframes shake {
  0%, 100%  { transform: translateX(0); }
  25%       { transform: translateX(-6px); }
  50%       { transform: translateX(6px); }
  75%       { transform: translateX(-6px); }
}
.shake {
  animation: shake 0.35s;
}

/* ضبط حدود Element-Plus Select */
.el-select.border-red-500 .el-input__wrapper,
.border-red-500 .el-input__wrapper       { border-color:#ef4444 !important; }

.el-select.border-green-500 .el-input__wrapper,
.border-green-500 .el-input__wrapper     { border-color:#22c55e !important; }
</style>
