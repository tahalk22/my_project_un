


<script setup>
import { usePage, Head, Link   } from '@inertiajs/vue3';
 
import * as QRCode from 'qrcode';
import { ref, onMounted  , computed  } from 'vue';
import * as constants from '@/JsFiles/constants.js';

const page = usePage().props.auth ;
 

const props = defineProps({
  insurance: Object
});

const qrCodeDataUrl = ref('');

function PrintPage() {
  window.print();
}

// إنشاء QR Code داخلياً
const generateQRCode = async () => {
  try {
    const insuranceUrl = `http://127.0.0.1:8001/Insurances/Show/${props.insurance.id}`;
    qrCodeDataUrl.value = await QRCode.toDataURL(insuranceUrl, {
      width: 120,
      margin: 1,
      color: {
        dark: '#000000',  // لون المربعات الداكنة
        light: '#ffffff' // لون الخلفية
      }
    });
  } catch (err) {
    console.error('Failed to generate QR code', err);
  }
};

onMounted(() => {
  generateQRCode();
});
 
</script>

<template>
  <Head title="عرض وطباعة الوثيقة" />

  <div class="  min-h-screen print:bg-white m-0 ">
    <!-- زر الطباعة -->
    <div class="text-left my-4 px-8 print:hidden  flex gap-2 " v-if = "page.user">
       <button @click="PrintPage" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 flex items-center">
        <fa icon="print" class="ml-2" /> &nbsp; طباعة الوثيقة
      </button>
      <Link   :href = "route('Insurances.Index')" 
      class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg shadow-md transition duration-300 flex items-center">
        <fa icon="reply" class="ml-2" />  &nbsp; رجوع
      </Link>
  


    </div>

    <!-- قالب الوثيقة -->
    <div class="p-8 bg-white text-gray-800 font-sans w-[210mm] min-h-[297mm] mx-auto shadow print:shadow-none print:border-0 print:p-0 print:w-full print:min-h-0 relative" dir="rtl" style="height: 297mm;">
      <!-- العلامة المائية في الأعلى بالمنتصف -->
      <div class="absolute left-0 right-0 flex justify-center opacity-20 z-0 pointer-events-none">
        <img src="/logo/logo.png" alt="علامة مائية" class="h-32 object-contain">
      </div>

      <!-- المحتوى الرئيسي -->
      <div class="relative z-10 h-full flex flex-col" style="padding: 15mm 10mm;">
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-blue-500 pb-4 mb-4">
          <div class="text-sm leading-5">
            <div class="flex items-center">
              <!-- <img src="/logo/logo.png" alt="شعار الشركة" class="h-14 mr-0"> -->
              <div>
                <h2 class="text-xl font-bold text-blue-800">شركة المختار للتأمين</h2>
                <p class="text-gray-600 text-sm" v-if = "insurance.office">{{ `${insurance.office?.office_name} مكتب` }}</p>
              </div>
            </div>
            <p class="text-gray-600 text-xs mt-1">طرابلس – ليبيا</p>
            <p class="text-gray-600 text-xs mt-1">جزيرة دوران زاوية الدهماني</p>
            <p class="text-gray-600 text-xs mt-1">هاتف : 0920000000 </p>
          </div>
          
  <div class="text-left flex ">
    <div class="mb-2 bg-blue-50 p-1 rounded border border-blue-200 inline-block">
      <p class="text-xs text-gray-500 mb-0">رقم الوثيقة:</p>
      <p class="text-red-600 font-bold text-right">{{ insurance.id }}#</p>
    </div>
    <!-- كود QR داخلي مع تنسيق احترافي -->
    <div class="  inline-block mr-3">
      <div v-if="qrCodeDataUrl" class="flex flex-col items-center">
        <img :src="qrCodeDataUrl" 
             alt="QR Code" 
             class="w-16 h-16 mx-auto">
        <!-- <p class="text-[8px] text-center mt-1 text-gray-500">مسح الكود لعرض الوثيقة</p> -->
      </div>
      <div v-else class="w-16 h-16 flex items-center justify-center bg-gray-100">
        <span class="text-xs text-gray-400">جاري التحميل...</span>
      </div>
    </div>
  </div>
        </div>

        <!-- عنوان الوثيقة -->
        <div class="text-center mb-4">
          <h1 class="text-xl font-bold text-blue-800 mb-1">وثيقة التأمين الإجباري</h1>
          <div class="w-24 h-0.5 bg-blue-400 mx-auto"></div>
        </div>

        <!-- معلومات أساسية -->
        <div class="grid grid-cols-4  gap-2 mb-4 text-xs">
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">تاريخ الإصدار:</p>
            <p>{{  insurance.version_date  }}</p>
          </div>
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700"> الفرع:</p>
            <p>{{  insurance.office?.name || 'الرئيسي'  }}</p>
          </div>
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">من ظهر يوم   :</p>
            <p>{{ insurance.from_date  }}</p>
          </div>
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">إلى ظهر يوم :</p>
            <p>{{ insurance.to_date  }}</p>
          </div>
        </div>

        <!-- معلومات العميل والمركبة -->
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div class="bg-blue-50 p-3 rounded border border-blue-200">
            <h3 class="font-semibold text-blue-700 mb-2 border-b border-blue-300 pb-1">معلومات المؤمن له</h3>
            <p class="mb-1 text-sm"><span class="font-semibold">الاسم:</span> {{ insurance.insurance_name }}</p>
            <p class="mb-1 text-sm"><span class="font-semibold">العنوان:</span> {{ insurance.insurance_location }}</p>
            <p class="text-sm"><span class="font-semibold">  الهاتف:</span> {{ insurance.phone }}</p>
            <p class="text-sm"><span class="font-semibold">نوع الهوية  :</span> {{ constants.id_types[insurance.id_type] }}</p>
            <p class="text-sm"><span class="font-semibold">رقم الهوية:</span> {{ insurance.id_number }}</p>
          </div>
          <div class="bg-blue-50 p-3 rounded border border-blue-200">
            <h3 class="font-semibold text-blue-700 mb-2 border-b border-blue-300 pb-1">معلومات المركبة</h3>
            <p class="mb-1 text-sm"><span class="font-semibold">نوع المركبة:</span> {{ insurance.car_type?.name }}</p>
            <p class="mb-1 text-sm"><span class="font-semibold">نوع المركبة:</span> {{ insurance.country?.name }}</p>
            <p class="mb-1 text-sm"><span class="font-semibold">رقم الهيكل:</span> {{ insurance.chassis_number }}</p>
            <p class="mb-1 text-sm"><span class="font-semibold">رقم اللوحة:</span> {{ insurance.plate_number }}</p>
            <p class="mb-1 text-sm"><span class="font-semibold">سنة الصنع:</span> {{ insurance.made_year }}</p>
            <p class="text-sm"><span class="font-semibold">اللون:</span> {{ insurance.color?.name }}</p>
          </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="grid grid-cols-4  gap-2 mb-4 text-xs">
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">قوة المحرك:</p>
            <p>{{ insurance.motor_power }}</p>
          </div>
          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">عدد الركاب:</p>
            <p>{{ insurance.non_driver_passengers }}</p>
          </div>
             <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">البند  :</p>
            <p>{{ constants.clause_type[ insurance.clause?.type] }}</p>
          </div>

          <div class="bg-gray-50 p-2 rounded border border-gray-200">
            <p class="font-semibold text-blue-700">نوع الرخصة:</p>
            <p>{{ insurance.clause?.name }}</p>
          </div>
  
        </div>

        <!-- جدول الرسوم -->
        <div class="mb-4">
          <h3 class="font-semibold text-blue-700 mb-2 text-sm">تفاصيل الرسوم</h3>
          <table class="w-full text-xs border border-gray-200 rounded overflow-hidden">
            <thead>
              <tr class="bg-blue-600 text-white">
                <th class="p-2 text-right font-semibold">البيان</th>
                <th class="p-2 text-right font-semibold w-24">القيمة (د.ل)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-gray-200">
                <td class="p-2">   القسط / السنة  </td>
                <td class="p-2 font-medium">  {{   insurance.installment   }}</td>
              </tr>
              <tr class="border-b border-gray-200">
                <td class="p-2">   ضريبة البند  /   السنة  </td>
                <td class="p-2 font-medium"> {{   constants.additional_fee_per_year  *  insurance.years_number  }}</td>
              </tr>
              <tr class="border-b border-gray-200">
                <td class="p-2">الضريبة</td>
                <td class="p-2 font-medium">{{ insurance.tax }}</td>
              </tr>
              <tr class="border-b border-gray-200">
                <td class="p-2">رسم الدمغة</td>
                <td class="p-2 font-medium">{{ insurance.stamp }}</td>
              </tr>
              <tr class="border-b border-gray-200">
                <td class="p-2">رسم الإشراف</td>
                <td class="p-2 font-medium">{{ insurance.supervision }}</td>
              </tr>
              <tr class="border-b border-gray-200">
                <td class="p-2">رسم الإصدار</td>
                <td class="p-2 font-medium">{{ insurance.version }}</td>
              </tr>
              

              <tr class="bg-blue-50 font-bold">
                <td class="p-2 text-blue-700">الإجمالي</td>
                <td class="p-2 text-blue-700">{{ insurance.total }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- تذييل الصفحة -->
        <div class="flex justify-between items-end mt-auto pt-4 border-t border-gray-300" v-if ="page.user">
          <div class="text-xs">
            <p class="mb-1"><span class="font-semibold">اسم الموظف:</span> {{ insurance.user?.name }}</p>
            <p><span class="font-semibold">وقت الطباعة:</span> {{ new Date().toLocaleString('ar-LY') }}</p>
          </div>
          <div class="text-center">
            <p class="font-semibold text-xs mb-1">الختم والتوقيع</p>
            <div class="h-16 w-40 border border-dashed border-gray-400 rounded"></div>
          </div>
        </div>

        <!-- ملاحظات ختامية -->
        <div class="text-center text-xs text-gray-500 mt-2">
          <p>هذه الوثيقة صادرة من نظام التأمين الإلكتروني لشركة المختار للتأمين</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
@media print {
  @page {
    size: A4 portrait;
    margin: 0;
  }
  body {
    margin: 0;
    padding: 0;
    background: white;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .print\:shadow-none {
    box-shadow: none;
  }
  .print\:border-0 {
    border-width: 0;
  }
  .print\:p-0 {
    padding: 0;
  }
  .print\:w-full {
    width: 100%;
  }
  .print\:min-h-0 {
    min-height: 0;
  }
}
</style>