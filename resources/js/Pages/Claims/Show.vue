<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head , Link  } from '@inertiajs/vue3';
import { claim_status, claim_type } from '@/JsFiles/constants';
import VueEasyLightbox from 'vue-easy-lightbox';
import { ref } from 'vue';

defineOptions({ layout: AppLayout });

const props = defineProps({ claim: Object });

const preview_images = ref([]);
const showPreview = ref(false);
const currentIndex = ref(0);

const attachments = JSON.parse(props.claim.attachments || '[]');
preview_images.value = attachments.map(path => `/storage/${path}`);

 const statusConfig = {
  1: { class: 'bg-blue-50 text-blue-800', icon: '⏳' },
  2: { class: 'bg-yellow-50 text-yellow-800', icon: '🔍' },
  3: { class: 'bg-green-50 text-green-800', icon: '✓' },
  4: { class: 'bg-red-50 text-red-800', icon: '✗' },
}[props.claim.claim_status];
</script>

<template>
  <Head title="تفاصيل المطالبة" />

  <div class="max-w-4xl mx-auto p-4 sm:p-6">
    <!-- زر الرجوع -->
    <div class="mb-6">
      <Link 
        :href="route('Claims.Index')" 
        class="inline-flex items-center  hover:text-blue-800 transition   bg-yellow-600
        px-8 py-3 font-semibold rounded-lg   hover:bg-yellow-700   duration-200"  
      >
         <fa icon = "reply" />
        رجوع      
      </Link>
    </div>

    <!-- البطاقة الرئيسية -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
      <!-- الهيدر -->
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-2xl font-bold">المطالبة رقم #{{ claim.id }}</h1>
            <p class="opacity-90 mt-1">تفاصيل كاملة عن المطالبة</p>
          </div>
          <div 
            class="px-4 py-2 rounded-full text-sm font-medium flex items-center"
            :class="statusConfig.class"
          >
            <span class="ml-1">{{ statusConfig.icon }}</span>
            {{ claim_status[claim.claim_status] || 'غير معروفة' }}
          </div>
        </div>
      </div>

      <!-- محتوى البطاقة -->
      <div class="p-6">
        <!-- قسم معلومات المطالبة -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
           <fa icon = 'file-lines'  class = "text-blue-600"/>
            معلومات المطالبة
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">نوع المطالبة</p>
              <p class="font-medium">{{ claim_type[claim.claim_type] }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">تاريخ المطالبة</p>
              <p class="font-medium">{{ claim.claim_date?.slice(0, 16).replace('T', ' ') }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
              <p class="text-gray-500 text-sm">الوصف</p>
              <p class="font-medium">{{ claim.description || '—' }}</p>
            </div>
            
            <div v-if="claim.deny_reason" class="bg-gray-50 p-4 rounded-lg md:col-span-2">
              <p class="text-gray-500 text-sm">سبب الرفض</p>
              <p class="font-medium text-red-600">{{ claim.deny_reason }}</p>
            </div>
          </div>
        </div>

        <!-- قسم بيانات التأمين -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                  <fa icon = 'building'  class = "text-blue-600"/>
            بيانات التأمين
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">اسم المؤمن</p>
              <p class="font-medium">{{ claim.insurance.insurance_name }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">رقم وثيقة التأمين</p>
              <p class="font-medium">{{ claim.insurance_id }}#</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">رقم اللوحة</p>
              <p class="font-medium">{{ claim.insurance.plate_number }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">رقم الهوية</p>
              <p class="font-medium">{{ claim.insurance.id_number }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">الهاتف</p>
              <p class="font-medium">{{ claim.insurance.phone }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">الموقع</p>
              <p class="font-medium">{{ claim.insurance.insurance_location }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-500 text-sm">سنة الصنع</p>
              <p class="font-medium">{{ claim.insurance.made_year }}</p>
            </div>
          </div>
        </div>

        <!-- قسم صور الحادث -->
        <div>
          <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                     <fa icon = 'image'  class = "text-blue-600"/>
            صور الحادث
          </h2>
          
          <div v-if="attachments.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <div 
              v-for="(img, i) in preview_images"
              :key="i"
              class="group relative cursor-pointer"
              @click="currentIndex = i; showPreview = true"
            >
              <img
                :src="img"
                class="w-full h-32 object-cover rounded-lg shadow-md transition-transform group-hover:scale-105"
              />
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          <div v-else class="bg-gray-50 p-8 text-center rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-gray-500">لا توجد صور مرفقة</p>
          </div>
        </div>
      </div>
    </div>

    <!-- نافذة عرض الصور -->
    <VueEasyLightbox
      :visible="showPreview"
      :imgs="preview_images"
      :index="currentIndex"
      @hide="showPreview = false"
    />
  </div>
</template>

<style scoped>
 .bg-gradient-to-r {
  background-image: linear-gradient(to right, var(--tw-gradient-stops));
}

.group:hover .group-hover\:scale-105 {
  transform: scale(1.05);
}

.transition-transform {
  transition-property: transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>