<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router , Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ElSelect, ElOption, ElDatePicker } from 'element-plus';
import { claim_status, claim_type } from '@/JsFiles/constants';
import { toast } from 'vue3-toastify';
import { inject } from 'vue'; 

const swal = inject('$swal') ;
 

defineOptions({ layout: AppLayout });

const props = defineProps({
  claims: Object,
  filters: Object,
  insurances: Array
});


const open_index = ref(null);


// الفلاتر
const search = ref({
  insurance_id: props.filters.insurance_id || '',
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || '',
  claim_status: props.filters.claim_status || '',
});

function applyFilters() {
  router.get(route('Claims.Index'), search.value, {
    preserveState: true,
    replace: true,
  });
}


function Accept(claim) {
    swal.fire({
      title: 'تأكيد' ,
      text:  `هل أنت متأكد من قبول   المطالبة  رقم  ${claim.id}
      ؟ للوثيقة رقم ${claim.insurance_id}`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'نعم، قبول',
      cancelButtonText: 'إلغاء',
    }).then((result) => {
      if (result.isConfirmed) {
        router.get(route('Claims.Accept', claim.id), {}, {
          preserveScroll: true,
          onSuccess: () =>  toast.success('تم قبول المطالبة'),
                  onError: () => { toast.error('حدث خطأ في عملية قبول المطالبة    ') },
        });
      }
    });
}
function UnderProcessing(claim) 
{
      swal.fire({
        title: 'تأكيد' ,
        text:  `هل أنت متأكد من وضع   المطالبة  رقم  ${claim.id}
        ؟ للوثيقة رقم ${claim.insurance_id} قيد المعالجة`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'نعم،  ',
        cancelButtonText: 'إلغاء',
      }).then((result) => {
        if (result.isConfirmed) {
          router.get(route('Claims.UnderProcessing', claim.id), {}, {
            preserveScroll: true,
            onSuccess: () =>  toast.success('تم وضع المطالبة قيد المعالجة  '),
                    onError: () => { toast.error('حدث خطأ في عملية   وضع المطالبة قيد المعالجة    ') },
          });
        }
      });
}

function Deny(claim_id) {
  swal.fire({
    title: 'رفض المطالبة',
    input: 'textarea',
    inputLabel: 'سبب الرفض',
    inputPlaceholder: 'أدخل السبب هنا...',
    showCancelButton: true,
    confirmButtonText: 'رفض',
    cancelButtonText: 'إلغاء',
    preConfirm: (reason) => {
      if (!reason) {
        swal.showValidationMessage('يرجى إدخال سبب الرفض');
      }
      return reason;
    },
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(route('Claims.Deny', claim_id), {
        deny_reason: result.value,
      }, {
        preserveScroll: true,
        onSuccess: () => { toast.success('تم رفض المطالبة') },
        onError: () => { toast.error('حدث خطأ في عملية رفض المطالبة    ') },
      });
    }
  });
}

</script>

<template>
  <Head title="سجل المطالبات" />

  <div class="p-6 bg-white rounded-lg" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">سجل المطالبات</h1>

     <form class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200" @submit.prevent="applyFilters">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">

          <!-- وثيقة التأمين -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الوثيقة</label>
            <el-select v-model="search.insurance_id" placeholder="اختر الوثيقة" filterable clearable class="w-full">
                <el-option label = "الكل"  value = '' />
              <el-option
                v-for="ins in props.insurances"
                :key="ins.id"
                :label="`وثيقة رقم ${ins.id} - ${ins.insurance_name}`"
                :value="ins.id"
              />
            </el-select>
          </div>

          <!-- من تاريخ -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">من    </label>
            <input v-model="search.date_from" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
          </div>

          <!-- إلى تاريخ -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">إلى    </label>
            <input v-model="search.date_to" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
          </div>

          <!-- حالة المطالبة -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">حالة المطالبة</label>
            <el-select v-model="search.claim_status" placeholder="اختر الحالة" clearable class="w-full" filterable>
                   <el-option label = "الكل"  value = '' />
              <el-option
                v-for="(label, key) in claim_status"
                :key="key"
                :label="label"
                :value="parseInt(key)"
              />
            </el-select>
          </div>

        </div>

        <div class="text-left">
          <button type="submit" class="bg-[#c5b26b] hover:bg-[#b3a15f] text-white font-medium py-2 px-6 rounded-lg transition">
            بحث
          </button>
        </div>
      </form>

    <!-- جدول عرض المطالبات -->
    <div class="overflow-x-auto   table_container">
      <table class="min-w-full text-sm text-right border">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2">   #</th>
            <th class="p-2">رقم المطالبة</th>
            <th class="p-2">رقم الوثيقة</th>
            <th class="p-2">رقم اللوحة</th>
            <th class="p-2">اسم المؤمن</th>
            <th class="p-2">تاريخ المطالبة</th>
            <th class="p-2">نوع المطالبة</th>
            <th class="p-2">الحالة</th>
            <th class="p-2">سبب الرفض</th>
            <th class="p-2">العمليات</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(claim, index) in props.claims.data"
            :key="claim.id"
            class="border-t "
              :class="[
                'border-t  ',
                claim.claim_status === 4 ? 'bg-red-100' :
                claim.claim_status === 3 ? 'bg-green-100' :
                claim.claim_status === 2 ? 'bg-yellow-100' :
                '' 
              ]"
          >
            <td class="p-2">{{ index +1  }}</td>
            <td class="p-2">{{ claim.id  }}#</td>
            <td class="p-2">{{ claim.insurance_id  }}#</td>
            <td class="p-2">{{ claim.insurance?.plate_number }}</td>
            <td class="p-2">{{ claim.insurance?.insurance_name }}</td>
            <td class="p-2">{{ claim.claim_date }}</td>
            <td class="p-2">{{ claim_type[claim.claim_type]  }}</td>
            <td class="p-2">{{ claim_status[claim.claim_status]  }}   </td>
            <td class="p-2">{{ claim.deny_reason ?? '/'  }}   </td>
            <td class="px-6 py-4 text-sm text-gray-700">
              <div class="relative inline-block text-left pl-[40px]">
                <button
                  @click="open_index = open_index === index ? null : index"
                  class="text-gray-500 hover:text-gray-700 focus:outline-none"
                >
                  <fa icon="ellipsis-vertical" /> العمليات
                </button>

                <div
                  v-if="open_index === index"
                  class="absolute z-10 right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <ul class="py-1 text-sm text-gray-700">
                    <!-- عرض -->
                    <li>
                      <Link :href="route('Claims.Show', claim.id)">
                        <button class="w-full text-right px-4 py-2 hover:bg-blue-100">
                          <fa class="ml-1 text-blue-500" :icon="'eye'" /> عرض
                        </button>
                      </Link>
                    </li>
            
                    <!-- قيد المعالجة -->
                    <li>
                      <button
                        @click="UnderProcessing(claim)"
                        class="w-full text-right px-4 py-2 hover:bg-yellow-100 text-yellow-600"  v-if = "claim.claim_status != 2"
                      >
                        <fa class="ml-1" icon="circle-check" /> قيد المعالجة
                      </button>
                    </li>
                    <!-- قبول -->
                    <li>
                      <button
                        @click="Accept(claim)"
                        class="w-full text-right px-4 py-2 hover:bg-green-100 text-green-600"  v-if = "claim.claim_status != 3"
                      >
                        <fa class="ml-1" icon="circle-check" /> قبول
                      </button>
                    </li>

                    <!-- رفض -->
                    <li>
                      <button  v-if = "claim.claim_status !=  4 "
                        @click="Deny(claim)"
                        class="w-full text-right px-4 py-2 hover:bg-red-100 text-red-600"
                      >
                        <fa class="ml-1" icon="circle-xmark" /> رفض
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
      </div>
    </template>
