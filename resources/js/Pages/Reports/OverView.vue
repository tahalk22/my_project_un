<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { BarChart, PieChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

defineOptions({ layout: AppLayout });

const props = defineProps({
  top_offices: Array,       // قائمة المكاتب مع عدد الوثائق
  claims_stats: Object      // عدد المطالبات حسب الحالة
});

// بيانات المكاتب
const officeChart = {
  labels: props.top_offices.map(o => o.office_name),
  datasets: [{
    label: 'عدد الوثائق',
    data: props.top_offices.map(o => o.insurances_count),
    backgroundColor: '#3b82f6'
  }]
};

// أسماء حالات المطالبات
const statusLabels = {
  1: 'مطالبة جديدة',
  2: 'قيد المعالجة',
  3: 'تم القبول',
  4: 'تم الرفض'
};

// بيانات المطالبات
const claimChart = {
  labels: Object.keys(props.claims_stats).map(k => statusLabels[k] || `حالة ${k}`),
  datasets: [{
    label: 'عدد المطالبات',
    data: Object.values(props.claims_stats),
    backgroundColor: ['#9ca3af', '#facc15', '#22c55e', '#ef4444']
  }]
};
</script>

<template>
  <Head title="تقارير الإحصاءات" />

  <div class="p-6" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">تقارير الإحصاءات الجاهزة</h1>
 
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      
      <!-- المكاتب الأكثر إصدارًا -->
      <div class="bg-white p-4 rounded-xl shadow border">
        <h2 class="text-lg font-semibold mb-4">المكاتب الأكثر إصدارًا للوثائق</h2>
<BarChart :chartData="officeChart" />
      </div>

      <!-- حالة المطالبات -->
      <div class="bg-white p-4 rounded-xl shadow border">
        <h2 class="text-lg font-semibold mb-4">عدد المطالبات حسب الحالة</h2>
 <PieChart :chartData="claimChart" />
      </div>

    </div>
  </div>
</template>
