<template>
    <div>
      <!-- 💰 كاش - محلي -->
      <div v-if="form.payment_method === 1">
        <p class="font-bold text-gray-700 mb-2"><HomeIcon class="w-6 h-6 mb-2 inline-block text-[var(--main-color)]" /> تفاصيل الدفع للمشاركين من داخل ليبيا</p>
        <p class="text-sm">رسوم الاشتراك: <strong class="text-green-600"> دينار ليبي
        {{  form.attendance_type == 3  ?   '2,000' : '1,000' }}  
        </strong></p>
        <p class="text-sm text-gray-600">يمكنك الدفع نقداً عند الوصول    .</p>
      </div>
  
      <!-- 💳 تحويل - محلي -->
      <div v-else-if="form.payment_method === 2">
        <p class="font-bold text-gray-700 mb-2"><HomeIcon class="w-6 h-6 mb-2 inline-block text-[var(--main-color)]" /> تفاصيل الدفع للمشاركين من داخل ليبيا</p>
        <p class="text-sm mb-2">رسوم الاشتراك: <strong class="text-green-600"> {{  form.attendance_type == 3  ?   '2,000' : '1,000' }}    دينار ليبي</strong></p>
        <p class="font-semibold mb-1 text-green-600">تفاصيل الحساب البنكي:</p>
        <ul class="ml-4 text-sm text-right">
          <li><strong>اسم البنك:</strong> مصرف الصحارى الفرع الرئيسي </li>
          <li><strong>رقم الحساب:</strong> 2000201483 </li> 
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { HomeIcon } from '@heroicons/vue/24/outline'
  defineProps({ form: Object })
  </script>
  