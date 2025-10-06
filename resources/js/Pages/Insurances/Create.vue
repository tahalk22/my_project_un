<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ElSelect, ElOption } from 'element-plus';
import { ref, watch  , computed  } from 'vue';
import { addDays, addYears, setHours, setMinutes, setSeconds, formatISO } from 'date-fns';

import * as constants from '@/JsFiles/constants.js';

import { inject } from 'vue';
const swal = inject('$swal');



const props = defineProps({
  countries: Array,
  car_types: Array,
  clauses: Array,
  colors: Array,
    prices: Object,
});

defineOptions({ layout: AppLayout });

const form = useForm({
  insurance_name: 'عيسى بو القاسم',
    id_type:  1 ,
  id_number: '12314123',
  phone: '092406141',

  insurance_location: 'طرابلس الفرناج',
  chassis_number: '123',
  motor_power: '15 حصان ',
  motor_number: '123',
  non_driver_passengers: '4',
  plate_number: '12345678',
  country_id:  1 , 
  car_type_id: 1 ,
  clause_id: 6,
  made_year: 2024,
  color_id:  1 ,
  years_number: 1  ,
  installment: '',
  tax: '',
  supervision: '',
  stamp: '',
  version: '',
  total: '',
});

 

const now = new Date();
const version_date = ref(formatISO(setSeconds(setMinutes(setHours(now, 12), 0), 0)).slice(0, 16));

const from_date = ref('');
const to_date = ref('');

const additional_clause_fee = ref(0);

 

//   عند تغير السنة  
watch([() => form.years_number, () => form.clause_id], () => {
  // ✅ حساب التواريخ أولاً
  const from = setSeconds(setMinutes(setHours(addDays(now, 1), 12), 0), 0);
  const to = addYears(from, form.years_number);

  from_date.value = formatISO(from).slice(0, 16);
  to_date.value = formatISO(to).slice(0, 16);

  // ✅ ثم حساب الرسوم والأسعار
  const clause = props.clauses.find(c => c.id === form.clause_id);
  const extra = clause?.type === 2 ? (clause.additional_fee_per_year || 0) * form.years_number : 0;

  additional_clause_fee.value = extra.toFixed(2);
  form.installment = (props.prices.installment * form.years_number).toFixed(2);
  form.tax = props.prices.tax;
  form.supervision = props.prices.supervision;
  form.stamp = props.prices.stamp;
  form.version = props.prices.version;

  form.total = (
    parseFloat(form.installment) +
    parseFloat(form.tax) +
    parseFloat(form.supervision) +
    parseFloat(form.stamp) +
    parseFloat(form.version) +
    parseFloat(additional_clause_fee.value)
  ).toFixed(2);
}, { immediate: true });
 

const filtered_car_types = computed(() =>
  props.car_types.filter(type => type.country_id === form.country_id)
);

function Store() {

swal.fire({
  title: 'تأكيد الإصدار',
  html: 'الرجاء التحقق من البيانات في حال تم اصدار الوقيقة لا يمكن التراجع عن ذلك ',
  icon: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'إصدار الوثيقة ',
  cancelButtonText: 'تراجع',
}).then((result) => {
  if (result.isConfirmed) {
      
    form.post(route('Insurances.Store'), {
      onSuccess: () => toast.success('تم إصدار البطاقة بنجاح'),
      onError: () => toast.error('حدث خطأ أثناء الحفظ'),
    });
  }
});
}
</script>


<template>
  <Head title="إصدار بطاقة تأمين" />
  <div class="w-full py-10 px-10 bg-white"  >
    <h1 class="text-3xl font-bold text-right mb-6">إصدار بطاقة تأمين</h1>
    <hr />
    <br />
    <form @submit.prevent="Store">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right">

        <div>
          <label class="block text-sm font-medium text-gray-700">اسم المؤمن</label>
          <input v-model="form.insurance_name" type="text" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700"> السكن</label>
          <input v-model="form.insurance_location" type="text" class="input-field" required />
        </div>

        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
  <div>
    <label class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
    <input v-model="form.phone" type="text" class="input-field" required />
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">أنواع إثبات الهوية</label>
    <el-select v-model="form.id_type" placeholder="اختر نوع الإثبات" filterable clearable class="w-full">
      <el-option
        v-for="(label, key) in constants.id_types"
        :key="key"
        :label="label"
        :value="parseInt(key)"
      />
    </el-select>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">رقم إثبات الهوية</label>
    <input v-model="form.id_number" type="text" class="input-field" required />
  </div>
</div>



        <div>
          <label class="block text-sm font-medium text-gray-700">رقم الشاسيه</label>
          <input v-model="form.chassis_number" type="text" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">رقم المحرك</label>
          <input v-model="form.motor_number" type="text" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">قوة المحرك</label>
          <input v-model="form.motor_power" type="text" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">عدد الركاب (عدا السائق)</label>
          <input v-model="form.non_driver_passengers" type="number" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">رقم اللوحة</label>
          <input v-model="form.plate_number" type="text" class="input-field" required />
        </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">سنة الصنع</label>
            <el-select v-model="form.made_year" placeholder="اختر السنة" filterable clearable class="w-full">
              <el-option v-for="year in constants.made_years" :key="year" :label="year" :value="year" />
            </el-select>
          </div>

                <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 ">تاريخ الإصدار</label>
         <input type="datetime-local"  class="input-field bg-gray-100 text-right " :value="version_date" readonly />
        </div>

        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">عدد السنوات</label>
            <el-select v-model="form.years_number" placeholder="اختر المدة" filterable class="w-full">
              <el-option v-for="year in constants.insurance_years" :key="year" :label="`${year} سنة`" :value="year" />
            </el-select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">من</label>
            <input type="datetime-local" class="input-field bg-gray-100" :value="from_date" readonly />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">إلى</label>
            <input type="datetime-local" class="input-field bg-gray-100" :value="to_date" readonly />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الدولة</label>
          <el-select v-model="form.country_id" placeholder="اختر الدولة" filterable clearable class="w-full">
            <el-option v-for="country in countries" :key="country.id" :label="country.name" :value="country.id" />
          </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">نوع السيارة</label>
        <el-select v-model="form.car_type_id" placeholder="اختر النوع" filterable clearable class="w-full">
          <el-option v-for="type in filtered_car_types" :key="type.id" :label="type.name" :value="type.id" />
        </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">لون السيارة</label>
          <el-select v-model="form.color_id" placeholder="اختر اللون" filterable clearable class="w-full">
            <el-option v-for="color in colors" :key="color.id" :label="color.name" :value="color.id" />
          </el-select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">البند التأميني</label>
          <el-select v-model="form.clause_id" placeholder="اختر البند" filterable clearable class="w-full">
            <el-option v-for="clause in clauses" :key="clause.id" :label="  `${clause.name }  -  ${constants.clause_type[clause.type]} `" :value="clause.id" />
          </el-select>
        </div>



        <!-- التكاليف -->
        <div>
          <label class="block text-sm font-medium text-gray-700">القسط</label>
          <input v-model="form.installment" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الضريبة</label>
          <input v-model="form.tax" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الإشراف</label>
          <input v-model="form.supervision" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الدمغة</label>
          <input v-model="form.stamp" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الإصدار</label>
          <input v-model="form.version" type="number" step="0.01" class="input-field" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">الإجمالي</label>
          <input v-model="form.total" type="number" step="0.01" class="input-field" required />
        </div>

      </div>

      <div class="mt-10 text-left">
        <button type="submit" class="px-8 py-3 text-white font-semibold rounded-lg bg-blue-600 hover:bg-blue-700 transition duration-200" :disabled="form.processing">
          {{ form.processing ? '...جاري الإصدار' : 'إصدار الوثيقة' }}
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition;
}

 

</style>