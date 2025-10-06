<template>
    <div class="p-8 bg-white text-black font-sans w-[794px] min-h-[1123px] mx-auto border border-gray-400 shadow print:shadow-none print:border-0 print:p-0 print:w-full print:min-h-0" dir="rtl">
      <!-- Header -->
      <div class="flex justify-between items-start border-b border-gray-300 pb-2 mb-4">
        <div class="text-sm leading-5">
          <h2 class="text-lg font-bold">شركة العالمية للتأمين</h2>
          <p>International Insurance Company</p>
          <p>طرابلس – ليبيا، شارع الجمهورية، عمارة رقم 20</p>
          <p>هاتف: 0213504529 / 0213514201</p>
        </div>
        <div class="text-right text-sm">
          <div class="mb-2">
            <p class="text-xs">رقم الوثيقة:</p>
            <p class="border border-red-500 text-red-600 px-3 py-1 font-bold inline-block">2338252</p>
          </div>
          <img src="https://api.qrserver.com/v1/create-qr-code/?data=2338252&size=80x80" alt="QR Code">
        </div>
      </div>
  
      <h1 class="text-center text-lg font-bold underline mb-6">وثيقة التأمين الإجباري</h1>
  
      <!-- Document + Client Info -->
      <div class="grid grid-cols-2 gap-y-4 text-sm mb-6">
        <div>
          <p><span class="font-semibold">رقم الوثيقة:</span> 901/04/2024/01 مكتب مرور زاوية</p>
          <p><span class="font-semibold">رقم النموذج:</span> 067863</p>
        </div>
        <div>
          <p><span class="font-semibold">تاريخ الإصدار:</span> 22/04/2024</p>
          <p><span class="font-semibold">ساري إلى:</span> 23/04/2025</p>
        </div>
        <div>
          <p><span class="font-semibold">اسم المؤمن له:</span> السنوسي محمد الأمين</p>
          <p><span class="font-semibold">العنوان:</span> طرابلس</p>
        </div>
        <div>
          <p><span class="font-semibold">رقم الهوية:</span> 5-2435248</p>
        </div>
      </div>
  
      <!-- Vehicle Info -->
      <div class="grid grid-cols-2 gap-y-4 text-sm mb-6">
        <div>
          <p><span class="font-semibold">رقم الهيكل:</span> 583258</p>
          <p><span class="font-semibold">قوة المحرك:</span> 16 حصان</p>
          <p><span class="font-semibold">عدد الركاب:</span> 4 راكب</p>
        </div>
        <div>
          <p><span class="font-semibold">نوع المركبة:</span> كورية الصنع</p>
          <p><span class="font-semibold">اللون:</span> رمادي</p>
          <p><span class="font-semibold">سنة الصنع:</span> 2008</p>
        </div>
        <div>
          <p><span class="font-semibold">نوع الرخصة:</span> خصوصي</p>
        </div>
        <div>
          <p><span class="font-semibold">الجهة المنفذ بها:</span> طرابلس</p>
        </div>
      </div>
  
      <!-- Fees Table -->
      <div class="mb-6">
        <table class="w-full text-sm border border-gray-300">
          <thead>
            <tr class="bg-gray-100">
              <th class="border border-gray-300 p-2 text-right">البيان</th>
              <th class="border border-gray-300 p-2 text-right">القيمة (د.ل)</th>
            </tr>
          </thead>
          <tbody>
            <tr><td class="border border-gray-300 p-2">قيمة القسط</td><td class="border border-gray-300 p-2">64.000</td></tr>
            <tr><td class="border border-gray-300 p-2">الضريبة</td><td class="border border-gray-300 p-2">1.000</td></tr>
            <tr><td class="border border-gray-300 p-2">رسم الدمغة</td><td class="border border-gray-300 p-2">0.500</td></tr>
            <tr><td class="border border-gray-300 p-2">رسم الإشراف</td><td class="border border-gray-300 p-2">0.320</td></tr>
            <tr><td class="border border-gray-300 p-2">رسم الإصدار</td><td class="border border-gray-300 p-2">2.000</td></tr>
            <tr class="font-bold bg-gray-50">
              <td class="border border-gray-300 p-2">الإجمالي</td>
              <td class="border border-gray-300 p-2">67.820</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Footer -->
      <div class="flex justify-between items-start text-sm">
        <div>
          <p><span class="font-semibold">اسم الموظف:</span> أحمد إبراهيم كرفاع</p>
          <p><span class="font-semibold">وقت الطباعة:</span> 22/04/2024 – 10:35:53</p>
        </div>
        <div class="text-center">
          <p class="font-semibold">الختم والتوقيع</p>
          <div class="mt-4 h-16 border border-dashed border-gray-400 rounded"></div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  // لا حاجة لكود JS في هذا القالب حالياً
  </script>
  
  <style>
  @media print {
    html, body {
      width: 210mm;
      height: 297mm;
      margin: 0;
      padding: 0;
      background: white;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    @page {
      size: A4 portrait;
      /* margin: 0; */
    }
  }
  </style>
  