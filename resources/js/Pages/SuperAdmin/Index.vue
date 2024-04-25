<script setup>
import AdminLayout from '@/Layouts/SuperAdminLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const { totalEmployees, totalDepartments, totalLeavetypes, pendingLeaves, approvedLeaves, rejectedLeaves } = defineProps({
  users: {
    type: Array,
    required: true,
  },
  totalEmployees: {
    type: Number,
    required: true,
  },
  totalDepartments: {
    type: Number,
    required: true,
  },
  totalLeavetypes: {
    type: Number,
    required: true,
  },
  pendingLeaves: {
        type: Number,
        required: true,
    },
    approvedLeaves: {
        type: Number,
        required: true,
    },
    rejectedLeaves: {
        type: Number,
        required: true,
    },
});

const { props: pageProps, replace } = usePage();
const users = ref(pageProps.users || []);
const currentPage = ref(1);
const perPage = 10;

const paginatedUsers = computed(() => {
  const startIndex = (currentPage.value - 1) * perPage;
  return users.value.slice(startIndex, startIndex + perPage);
});

const totalPages = computed(() => Math.ceil(users.value.length / perPage));

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
}
</script>
<template>
    <Head title="Dashboard" />
    <AdminLayout>
      <div class="py-8">
        <div class="max-w-6xl sm:px-3 lg:px-8">
          <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
            <div class="flex flex-col gap-6 mb-8 ml-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-purple-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Total Employees</p>
                    <p class="text-4xl font-semi-bold">{{ totalEmployees }}</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-blue-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Departments</p>
                    <p class="text-4xl font-semi-bold">{{ totalDepartments }}</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-orange-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Leave Types</p>
                    <p class="text-4xl font-semi-bold">{{ totalLeavetypes }}</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-yellow-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Pending</p>
                    <p class="text-4xl font-semi-bold">{{ pendingLeaves }}</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-green-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Approved</p>
                    <p class="text-4xl font-semi-bold">{{ approvedLeaves }}</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <div class="w-10 h-24 bg-red-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                  <div class="ml-8">
                    <p class="text-lg">Rejected</p>
                    <p class="text-4xl font-semi-bold">{{ rejectedLeaves }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="overflow-hidden">
              <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
                  <thead>
                    <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                      <th class="px-4 py-2 text-left">Id</th>
                      <th class="px-4 py-2 text-left">Name</th>
                      <th class="px-4 py-2 text-left">Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in paginatedUsers" :key="index" class="border-b hover:bg-gray-50 text-sm">
                      <td class="px-4 py-2">{{ user.id }}</td>
                      <td class="px-4 py-2">{{ user.name }}</td>
                      <td class="px-4 py-2">{{ user.email }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Pagination Controls -->
            <div class="flex justify-between items-center mt-4">
              <div>Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, users.length) }} of {{ users.length }} employees</div>
              <div class="flex items-center">
                <button :disabled="currentPage === 1" @click="prevPage" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Previous</button>
                <button :disabled="currentPage === totalPages" @click="nextPage" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow ml-2">Next</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>
  

  