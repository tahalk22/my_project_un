<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toast } from 'vue3-toastify';
import * as constants from "@/JsFiles/constants.js";

defineOptions({ layout: AppLayout });

const props = defineProps({
  user: Object
});

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  current_password: '',
  password: '',
  password_confirmation: ''
});

const ProfileUpdate = () => {
  form.post(route('Profile.ProfileUpdate'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('password', 'password_confirmation');
      toast.success("تم تحديث بياناتك بنجاح");
    },
    onError: () => {
      toast.error("حدث خطأ في تحديث البيانات");
    }
  });
};
</script>

<template>
  <Head title="الملف الشخصي للأدمن" />
  <div class="min-h-screen bg-white text-right">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-6 border-b border-gray-200">
          <div class="flex items-center justify-start space-x-4 space-x-reverse">
            <div>
              <h1 class="text-2xl font-bold text-gray-800">{{ user.name }}</h1>
              <span class="inline-block mt-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                {{ constants.user_level[user.user_level] }}
              </span>
            </div>
            <div class="relative">
              <img
                :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=4f46e5&color=fff&rounded=true&size=128`"
                :alt="user.name"
                class="h-24 w-24 rounded-full object-cover border-4 border-gray-100 shadow-sm"
              />
            </div>
          </div>
        </div>

        <!-- Form -->
        <div class="px-6 py-6">
          <form @submit.prevent="ProfileUpdate" class="space-y-8">
            <div>
              <h2 class="text-xl font-semibold text-gray-800">تحديث الملف الشخصي</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- الاسم -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 text-right">الاسم الكامل</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-right"
                />
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 text-right">{{ form.errors.name }}</p>
              </div>

              <!-- البريد -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 text-right">البريد الإلكتروني</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-right"
                />
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600 text-right">{{ form.errors.email }}</p>
              </div>

              <!-- كلمة المرور الحالية -->
              <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 text-right">كلمة المرور الحالية</label>
                <input
                  type="password"
                  id="current_password"
                  autocomplete="off"
                  v-model="form.current_password"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-right"
                />
                <p v-if="form.errors.current_password" class="mt-2 text-sm text-red-600 text-right">{{ form.errors.current_password }}</p>
              </div>

              <!-- كلمة المرور الجديدة -->
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 text-right">كلمة المرور الجديدة</label>
                <input
                  type="password"
                  id="password"
                  autocomplete="off"
                  v-model="form.password"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-right"
                />
                <p v-if="form.errors.password" class="mt-2 text-sm text-red-600 text-right">{{ form.errors.password }}</p>
              </div>

              <!-- تأكيد كلمة المرور -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 text-right">تأكيد كلمة المرور</label>
                <input
                  type="password"
                  id="password_confirmation"
                  autocomplete="off"
                  v-model="form.password_confirmation"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-right"
                />
              </div>
            </div>

            <!-- زر الحفظ -->
            <div class="flex justify-start pt-6">
              <button
                type="submit"
                :disabled="form.processing"
                class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150"
              >
                <span v-if="form.processing">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                  </svg>
                  جاري الحفظ...
                </span>
                <span v-else>حفظ التغييرات</span>
              </button>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>
</template>
