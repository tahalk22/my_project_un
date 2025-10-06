<template>
  <div class="fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-4xl text-right overflow-auto max-h-[90vh] border border-blue-100 dark:border-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 transform hover:shadow-2xl">
      <!-- العنوان مع أيقونة -->
      <div class="flex items-center justify-between mb-6 border-b pb-4 border-blue-100 dark:border-gray-700">
        <h2 class="text-2xl md:text-3xl font-bold text-[#0c2f5c] dark:text-blue-300 flex items-center gap-2">
          <fa icon = "user"  class="h-8 w-8" />
          مراجعة البيانات قبل الإرسال النهائي
        </h2>
        <button @click="$emit('cancel')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
          <fa icon = "xmark"   class="h-6 w-6"   />
        </button>
      </div>

      <!-- البيانات في شكل بطاقات -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- بطاقة المعلومات الشخصية -->
        <div class="bg-blue-50/50 dark:bg-gray-700/50 p-4 rounded-xl border border-blue-100 dark:border-gray-700">
          <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
            <fa icon = "user"  class="h-5 w-5"  />
       
            المعلومات الشخصية
          </h3>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">الإسم الأول:</span>
              <span class="font-medium">{{ form.first_name }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">إسم العائلة:</span>
              <span class="font-medium">{{ form.last_name }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">النوع:</span>
              <span class="font-medium">{{ constants.gender[form.gender] }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-400">الجنسية:</span>
              <span class="font-medium">{{ form.nationality }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-400">نوع المشارك:</span>
              <span class="font-medium">{{ constants.attendance_type[form.attendance_type] }}</span>
            </div>
          </div>
        </div>

        <!-- بطاقة معلومات المشاركة -->
        <div class="bg-blue-50/50 dark:bg-gray-700/50 p-4 rounded-xl border border-blue-100 dark:border-gray-700">
          <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
            <fa  icon = "building"   class="h-5 w-5"  />
            معلومات المشاركة
          </h3>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">نوع المشاركة:</span>
              <span class="font-medium">{{ constants.participant_type[form.participant_type] }}</span>
            </div>
            <div v-if="form.participant_type == 2" class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">الدولة:</span>
              <span class="font-medium">{{ getCountryById(form.country_id)?.name_ar || '-' }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">جهة العمل:</span>
              <span class="font-medium">{{ form.organization }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-400">المسمى الوظيفي:</span>
              <span class="font-medium">{{ form.job_title }}</span>
            </div>
          </div>
        </div>

        <!-- بطاقة معلومات الاتصال -->
        <div class="bg-blue-50/50 dark:bg-gray-700/50 p-4 rounded-xl border border-blue-100 dark:border-gray-700">
          <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
            <fa  icon = "envelope"   class="h-5 w-5"   />
            معلومات الاتصال
          </h3>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">البريد الإلكتروني:</span>
              <span class="font-medium">{{ form.email }}</span>
            </div>
            <div class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">رقم الهاتف:</span>
              <span class="font-medium"  >{{   `${ form.phone }  ` }}   <span dir="ltr" >{{ form.country_key  }}</span></span>
              
            </div>
            <div v-if="form.participant_type == 2" class="flex justify-between border-b border-blue-100 dark:border-gray-700 pb-2">
              <span class="text-gray-600 dark:text-gray-400">يحتاج تأشيرة:</span>
              <span class="font-medium">{{ constants.visa_required[form.visa_required] }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 dark:text-gray-400">طريقة الدفع:</span>
              <span class="font-medium">{{ constants.payment_method[form.payment_method] }}</span>
            </div>
          </div>
        </div>

        <!-- بطاقة المرفقات -->
        <div class="bg-blue-50/50 dark:bg-gray-700/50 p-4 rounded-xl border border-blue-100 dark:border-gray-700">
        <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
  
          <fa :icon="'link'" class="h-5 w-5" />
          المرفقات
        </h3>
        <div class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">الصورة الشخصية:</p>
            <div class="relative group cursor-pointer" @click="showLightbox(0)">
              <img 
                :src="profilePhoto"
                alt="الصورة الشخصية"
                class="w-24 h-24 rounded-full object-cover border-2 shadow transition-all duration-300 group-hover:scale-110"
                :class="form.gender == 1 ? 'border-blue-500' : 'border-pink-400'"
              />
              <div class="absolute inset-0 bg-black/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <fa :icon="['fas', 'search']" class="h-8 w-8 text-white" />
              </div>
            </div>
          </div>
          <div v-if="form.participant_type == 2" class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">صورة جواز السفر:</p>
            <div class="relative group cursor-pointer" @click="showLightbox(1)">
              <img
                :src="passportImage"
                alt="صورة جواز السفر"
                class="w-24 h-24 rounded-full object-cover border-2 shadow border-yellow-400 transition-all duration-300 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-black/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <fa :icon="['fas', 'search']" class="h-8 w-8 text-white" /> 
              </div>
            </div>
          </div>
          <div v-if="form.payment_receipt" class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">    ايصال الدفع:</p>
            <div class="relative group cursor-pointer"  >
              <span v-if="form.payment_receipt" class="text-sm text-gray-600">
                                                    <a :href="paymentReceiptFile" download class="text-blue-600 hover:underline">   <fa icon="file-download" class="w-10  h-10 ml-2" /> </a>
                 </span>
            </div>
          </div>
        </div>
      </div>
      </div>

      <!-- ملاحظات -->
      <div v-if="form.notes" class="bg-yellow-50/50 dark:bg-gray-700/50 p-4 rounded-xl border border-yellow-100 dark:border-gray-700 mb-6">
        <h3 class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2 flex items-center gap-2">
          <fa :icon="['fas', 'comment-alt']" class="h-5 w-5" />
          ملاحظات إضافية
        </h3>
        <p class="text-sm">{{ form.notes }}</p>
      </div>

      <!-- الأزرار -->
      <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
        <button
          @click="$emit('cancel')"
          class="px-6 py-2.5 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition flex items-center justify-center gap-2 text-sm font-medium shadow-sm"
        >
        <fa :icon="['fas', 'arrow-right']" class="h-5 w-5" />

          رجوع للتعديل
        </button>
        <button
          @click="$emit('confirm')"
          :class="[
            'px-6 py-2.5 rounded-full text-white font-medium transition flex items-center justify-center gap-2 text-sm shadow-md hover:shadow-lg',
            form.gender == 1 
              ? 'bg-blue-500 hover:bg-blue-600' 
              : 'bg-pink-500 hover:bg-pink-600'
          ]"
        >
     <fa :icon="['fas', 'check']" class="h-5 w-5" />

          تأكيد الإرسال
        </button>
      </div>
      <vue-easy-lightbox
        :visible="visible"
        :imgs="imgs"
        :index="index"
        @hide="handleHide"
      ></vue-easy-lightbox>
  
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import VueEasyLightbox from 'vue-easy-lightbox';
import * as constants from "@/JsFiles/constants.js";

const props = defineProps({
  form: Object,
  countries: Array,
  profilePhoto: {
    type: [Object, String],
    default: null,
    validator: (val) => val === null || typeof val === 'string' || typeof val === 'object',
  },
  passportImage: {
    type: [Object, String],
    default: null,
    validator: (value) => { return value === null ||  value === undefined ||  typeof value === 'string' ||  typeof value === 'object' }
  },
  paymentReceiptFile: {
    type: [Object, String],
    default: null,
    validator: (value) => { return value === null ||  value === undefined ||  typeof value === 'string' ||  typeof value === 'object' }
  },
});

defineEmits(["confirm", "cancel"]);

// Lightbox Logic
const visible = ref(false);
const index = ref(0);
const imgs = ref([]);

const showLightbox = (imgIndex) => {
  // تحضير مصفوفة الصور للعرض
  imgs.value = [];
  
  if (props.profilePhoto) {
    imgs.value.push({ src: props.profilePhoto, title: 'الصورة الشخصية' });
  }
  
  if (props.passportImage && props.form.participant_type == 2) {
    imgs.value.push({ src: props.passportImage, title: 'صورة جواز السفر' });
  }

  // تحديد الفهرس بناء على الزر الذي تم الضغط عليه
  index.value = imgIndex;
  visible.value = true;
};

const handleHide = () => {
  visible.value = false;
};

const getCountryById = (id) => props.countries.find((c) => c.id == id);
</script>

<style scoped>
/* تأثيرات إضافية لا يمكن تحقيقها بتيلويند */
img {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

img:hover {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* تخصيص Lightbox */
:deep(.vel-img-title) {
  @apply text-right font-bold text-lg;
}

:deep(.vel-btns-wrapper) {
  @apply left-4 right-auto;
}

:deep(.vel-btn) {
  @apply hover:bg-black/20;
}
</style>