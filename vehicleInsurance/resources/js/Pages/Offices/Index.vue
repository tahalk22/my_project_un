<script setup>
 
// import { AppLayout } from '@/Layouts/AppLayout.vue' 
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head   , Link, router, useForm , usePage  } from '@inertiajs/vue3';
import {   ref  } from 'vue'
import  *  as  constants  from "@/JsFiles/constants.js";
 
import { toast } from 'vue3-toastify';
import Pagination from "@/Components/Pagination.vue" ;
import { inject } from 'vue'; 
const swal = inject('$swal') ;
 
const page = usePage().props.auth ;   
 
 
defineOptions ( {
    layout  :  AppLayout 
}) ;
 

  // البيانات الواردة من اللارافيل
  const props = defineProps({
  offices: Object,
  filters: Object
});
 
const form = useForm({
  search: props.filters.search || ''  , 
  perPage : props.filters.perPage ||  5 
});

const perPageOptions = [5, 10, 15, 20, 25, 50, 100]; 
const open_index = ref(null)

const ApplyFilters = () => {
    form.get(route('Offices.Index'), {
    preserveState: true,
    replace: true
  });
};
 

  
 
 
const DeleteOffice = (office) => {
  swal.fire({
    title: `حذف المكتب؟`,
    html: `سيتم حذف المكتب <strong class="text-blue-500">${office.office_name}</strong> نهائيًا.<br>هل أنت متأكد؟`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: 'red',
    cancelButtonColor: 'gray',
    cancelButtonText: 'إلغاء',
    confirmButtonText: 'نعم، حذف',
    preConfirm: () => {
      router.delete(route('Offices.Delete' , {id : office.id }), {
        data: { id: office.id },
        preserveState: true,
        onSuccess: () => toast.success('تم حذف المكتب بنجاح'),
        onError: () => toast.error('حدث خطأ أثناء الحذف')
      });
    }
  });
};
 

</script>
 
<template>
  <Head   title = "عرض المشاركين" />
    <div class=" mx-auto px-4 py-8    w-full    ">  
      <h1 class="text-3xl font-bold text-blue-800  mb-6 pb-3 border-b border-gray-200  ">
    عرض وإدارة المكاتب {{  props.filters.perPage  }}
</h1>
 
 
         <form class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200" @submit.prevent = "ApplyFilters">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
          <!-- حقل البحث -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">البحث</label>
            <input 
              v-model="form.search"
              type="text" 
              placeholder="ابحث     باسم المكتب ..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#32506c] focus:border-[#32506c] transition"
            >
          </div>
 
 
            <!-- فلترة عدد السجلات -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">عدد السجلات</label>
                <select
                    v-model="form.perPage"
                    @change="ApplyFilters"
                    class="w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#32506c] focus:border-[#32506c] transition"
                >
                    <option v-for="option in perPageOptions" :value="option" :key="option">
                        {{ option }}
                    </option>
                </select>
            </div>
 

        </div>
        
        <div class="flex space-x-3">
          <button 
          
            class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition duration-300 transform hover:-translate-y-0.5 hover:shadow-md"
          >
            بحث
          </button>
    
        </div>
    </form>


      <!-- الجدول -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 outer_container ">
        <div class="overflow-x-auto  table_container">
          <!-- <table class="min-w-full divide-y divide-gray-200  "  id="table"> -->
          <table class="  divide-y divide-gray-200  "  id="table">
            <thead class="bg-blue-800">
              <tr class=" text-right ">
                <th scope="col" class="px-6 py-3text-xs font-medium text-white uppercase tracking-wider">اسم المكتب</th>
                <th scope="col" class="px-6 py-3   text-xs font-medium text-white uppercase tracking-wider">  المدير</th>
                <th scope="col" class="px-6 py-3   text-xs font-medium text-white uppercase tracking-wider">الهاتف</th>
                <th scope="col" class="px-6 py-3   text-xs font-medium text-white uppercase tracking-wider">المدينة</th>
                <th scope="col" class="px-6 py-3   text-xs font-medium text-white uppercase tracking-wider">العمليات</th>
          
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="office  , index in  offices.data" :key="office.id" class="hover:bg-gray-50 transition">
       
 
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ office.office_name }} 
                  </div> 
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ office.manager_name }} 
                  </div> 
                </td>
              <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ office.phone }} 
                  </div> 
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ office.city?.name || '-' }}
                  </div> 
                </td>
 
 
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium relative">
                        <div class="relative inline-block text-left  pl-[40px] " @click.outside="openIndex = null">
                            <button @click="open_index = open_index === index ? null : index" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                              <fa icon = "ellipsis-vertical" />    العمليات   
                            </button>
 
                            <div
                            v-if="open_index === index"
                            class="absolute z-10  right-[-28px]  mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                            <ul class="py-1 text-sm text-gray-700">
 

                                <li  v-if="page.user.user_level == 1  ">
                                  <Link  :href="route('Offices.Edit' , { id: office.id } )  " >
                                <button  class="w-full text-right px-4 py-2 hover:bg-gray-100">
                                    <fa  class="ml-1 text-blue-500"  :icon = "'edit'"  />           تعديل
                                </button>
                              </Link>
                                </li> 
                         
                                <li  v-if="page.user.user_level == 1  ">
                       
                                    <button @click="DeleteOffice(office)" class="w-full text-right px-4 py-2 hover:bg-gray-100 text-red-600">
                                            <fa  class=" ml-1"  icon = "trash-can" /> حذف
                                        </button>
                                </li>
                            </ul>
                            </div>
                        </div>
                        </td>
           
              </tr>
            </tbody>
          </table>



        </div>
                <!-- استخدام كمبوننت البيجنيشن -->
                <Pagination 
                    :links="offices.links"
                    :from="offices.from"
                    :to="offices.to"
                    :total="offices.total"
                    :currentPage="offices.current_page"
                    :lastPage="offices.last_page"
                />


      </div>

    </div>
  </template>
  
 
 