<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import * as constants from '@/JsFiles/constants.js';
import { format, addHours } from 'date-fns';
import VueEasyLightbox from 'vue-easy-lightbox';

defineOptions({ layout: AppLayout });

const props = defineProps({
  insurances: Array
});
 
const now = new Date();
const claim_date_local = format(addHours(now, 0), "yyyy-MM-dd'T'HH:mm");

 const form = useForm({
  insurance_id: '',
  claim_type: '',
  claim_date: claim_date_local,
  description: '',
  attachments: [],
});

 const preview_images = ref([]);
const showPreview = ref(false);
const current_index = ref(0);

 function handleFileUpload(event) {
  const files = event.target.files;
  form.attachments = [];
  preview_images.value = [];
  
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    
    if (!file.type.startsWith('image/')) {
      toast.error('يسمح فقط برفع الصور');
      continue;
    }
    
    form.attachments.push(file);
    preview_images.value.push({
      title: file.name,
      src: URL.createObjectURL(file)
    });
  }
}

 function showImage(index) {
  current_index.value = index;
  showPreview.value = true;
}

 function Store() {
  const payload = new FormData();
  
   payload.append('insurance_id', form.insurance_id);
  payload.append('claim_type', form.claim_type);
  payload.append('claim_date', form.claim_date);
  payload.append('description', form.description);
  
   form.attachments.forEach(file => {
    payload.append('attachments[]', file);
  });

  form.post(route('Claims.Store'), {
    data: payload,
    forceFormData: true,
    onSuccess: () => toast.success('تم تسجيل المطالبة بنجاح'),
    onError: () => {
      toast.error('حدث خطأ أثناء الحفظ');
      console.log(form.errors);
    },
  });
}
</script>

<template>
  <Head title="إضافة مطالبة جديدة" />
  <div class="w-full py-10 px-10 bg-white" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">نموذج إضافة مطالبة</h1>

    <form @submit.prevent="Store">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- رقم الوثيقة -->
        <div>
          <label class="block text-sm font-medium text-gray-700">رقم الوثيقة</label>
          <select 
            v-model="form.insurance_id" 
            class="input-field"
          >
            <option value="">اختر الوثيقة</option>
            <option 
              v-for="doc in props.insurances"
              :key="doc.id"
              :value="doc.id"
            >
              وثيقة رقم {{ doc.id }} - {{ doc.insurance_name }}
            </option>
          </select>
          <p v-if="form.errors.insurance_id" class="text-red-600 text-sm mt-1">
            {{ form.errors.insurance_id }}
          </p>
        </div>

        <!-- نوع المطالبة -->
        <div>
          <label class="block text-sm font-medium text-gray-700">نوع المطالبة</label>
          <select 
            v-model="form.claim_type" 
            class="input-field"
          >
            <option value="">اختر نوع المطالبة</option>
            <option 
              v-for="(label, key) in constants.claim_type"
              :key="key"
              :value="parseInt(key)"
            >
              {{ label }}
            </option>
          </select>
          <p v-if="form.errors.claim_type" class="text-red-600 text-sm mt-1">
            {{ form.errors.claim_type }}
          </p>
        </div>

        <!-- التاريخ -->
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">تاريخ المطالبة</label>
          <input 
            v-model="form.claim_date" 
            type="datetime-local" 
            class="input-field" 
            readonly 
          />
          <p v-if="form.errors.claim_date" class="text-red-600 text-sm mt-1">
            {{ form.errors.claim_date }}
          </p>
        </div>

        <!-- الوصف -->
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">تفاصيل المطالبة</label>
          <textarea 
            v-model="form.description" 
            rows="4" 
            class="input-field" 
            placeholder="أدخل التفاصيل..."
          ></textarea>
          <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">
            {{ form.errors.description }}
          </p>
        </div>

        <!-- المرفقات -->
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">صور الحادث</label>
          
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
            <input
              type="file"
              multiple
              accept="image/*"
              @change="handleFileUpload"
              class="hidden"
              id="file-upload"
            />
            
            <label 
              for="file-upload"
              class="flex flex-col items-center justify-center cursor-pointer p-4"
            >
              <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
              </svg>
              <p class="mt-2 text-sm text-gray-600">
                <span class="font-semibold text-blue-600">انقر لرفع الملفات</span> أو اسحبها وأسقطها هنا
              </p>
              <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF (الحد الأقصى 10 ملفات)</p>
            </label>
          </div>
          
          <p v-if="form.errors.attachments" class="text-red-600 text-sm mt-1">
            {{ form.errors.attachments }}
          </p>

          <!-- عرض الصور المصغرة -->
          <div v-if="preview_images.length > 0" class="mt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">الصور المرفوعة:</h3>
            <div class="flex flex-wrap gap-2">
              <div 
                v-for="(img, i) in preview_images"
                :key="i"
                class="relative group"
              >
                <img
                  :src="img.src"
                  @click="showImage(i)"
                  class="w-24 h-24 object-cover rounded cursor-pointer border border-gray-300 hover:border-blue-500 transition"
                />
                <button
                  @click.stop="() => {
                    preview_images.value.splice(i, 1);
                    form.attachments.splice(i, 1);
                  }"
                  class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                >
                  &times;
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 text-left">
        <button 
          type="submit" 
          class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition"
          :disabled="form.processing"
        >
          <span v-if="form.processing">جاري الحفظ...</span>
          <span v-else>تسجيل المطالبة</span>
        </button>
      </div>
    </form>

     <vue-easy-lightbox
      :visible="showPreview"
      :imgs="preview_images.map(img => img.src)"
      :index="current_index"
      @hide="showPreview = false"
    />
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full py-2  border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition;
}
</style>