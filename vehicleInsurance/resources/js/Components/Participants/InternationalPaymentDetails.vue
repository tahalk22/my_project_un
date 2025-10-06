<template>
    <div>
      <!-- 💰 كاش - دولي -->
      <div v-if="form.payment_method === 1">
        <p class="font-bold text-gray-700 mb-2"><CreditCardIcon class="w-6 h-6 mb-2 inline-block text-[var(--main-color)]" /> تفاصيل الدفع للمشاركين من خارج ليبيا</p>
        <p class="text-sm">رسوم الاشتراك: <strong class="text-green-600">     {{  form.attendance_type == 3  ?   '1,000' : '500' }}    دولار أمريكي</strong></p>
        <p class="text-sm text-gray-600">يمكنك الدفع نقداً عند الوصول  .</p>
      </div>
  
      <!-- 💳 تحويل - دولي -->
      <div v-else-if="form.payment_method === 2">
        <p class="font-bold text-gray-700 mb-2"><CreditCardIcon class="w-6 h-6 mb-2 inline-block text-[var(--main-color)]" /> تفاصيل الدفع للمشاركين من خارج ليبيا</p>
        <p class="mb-2 text-sm">رسوم الاشتراك: <strong class="text-green-600">     {{  form.attendance_type == 3  ?   '1,000' : '500' }}   دولار أمريكي</strong></p>
        <p class="mb-2 text-sm font-semibold text-green-600">تفاصيل الحساب البنكي للمشاركين الدوليين:</p>
        <div class="text-sm space-y-4 text-gray-700 text-left">
          <div>
            <p class="font-semibold">: First Account</p>
            <ul class="ml-4">
              <li><strong>Bank Name:</strong> Jordan Islamic Bank</li>
              <li><strong>Account Name:</strong> The International Federation of Takaful & Islamic Insurance Companies</li>
              <li><strong>Account Number:</strong> 2260113410400002</li>
              <li><strong>IBAN:</strong> JO50 JIBA 002000226011 3410400002</li>
              <li><strong>Swift Code:</strong> JIBAJOAMXXX</li>
              <li><strong>Bank Address:</strong> Amman, Jordan</li>
            </ul>
          </div>
          <div>
            <p class="font-semibold">: Second Account</p>
            <ul class="ml-4">
              <li><strong>Bank Name:</strong> Sahara Bank</li>
              <li><strong>Account Name:</strong> Libyan Insurance Federation</li>
              <li><strong>Account Number:</strong> 2003662643</li>
              <li><strong>IBAN:</strong> LY34006001000002003662643 </li> 
              <li><strong>Swift Code:</strong> SABKYL XXXX</li>
              <li><strong>Bank Address:</strong> Tripoli, Libya</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { CreditCardIcon } from '@heroicons/vue/24/outline'
  defineProps({ form: Object })
  </script>
  