<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DismissibleAlert from '@/Components/DismissibleAlert.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  leaves: {
    type: Array,
    required: true,
  },
  message: {
    type: String,
    default: null,
  },
});

const perPage = 10;
const currentPage = ref(1);
const search = ref('');
const sortColumn = ref('');
const sortDirection = ref('asc');

const filteredLeaves = computed(() => {
  let filtered = props.leaves.filter((leave) =>
    leave.type.toLowerCase().includes(search.value.toLowerCase())
  );

  if (sortColumn.value) {
    filtered = filtered.sort((a, b) => {
      const modifier = sortDirection.value === 'asc' ? 1 : -1;
      if (a[sortColumn.value] < b[sortColumn.value]) return -1 * modifier;
      if (a[sortColumn.value] > b[sortColumn.value]) return 1 * modifier;
      return 0;
    });
  }

  return filtered.slice((currentPage.value - 1) * perPage, currentPage.value * perPage);
});

const totalPages = computed(() => Math.ceil(props.leaves.length / perPage));

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const sortBy = (column) => {
  if (sortColumn.value === column) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortColumn.value = column;
    sortDirection.value = 'asc';
  }
};
</script>

<template>
  <Head title="Leave History" />
  <AuthenticatedLayout>
    <div class="py-12">
      <dismissible-alert v-if="props.message" :message="props.message" />
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white border border-gray-300 sm:rounded-lg">
          <section>
            <header class="flex justify-between items-center mb-4">
              <h2 class="text-lg font-medium text-gray-900">Leave History</h2>
              <div class="flex items-center">
                <input
                  v-model="search"
                  type="text"
                  placeholder="Search..."
                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full sm:w-auto"
                />
              </div>
            </header>
            <div class="overflow-x-auto">
            <table class="w-full table-auto">
              <thead>
                <tr>
                  <th
                    v-for="(column, index) in ['id','type', 'start_date', 'end_date', 'reason', 'status']"
                    :key="index"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    @click="sortBy(column)"
                  >
                    {{ column }}
                    <span v-if="sortColumn === column" :class="[sortDirection === 'asc' ? 'rotate-0' : 'rotate-180']">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 inline-block">
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="leave in filteredLeaves" :key="leave.id" class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ leave.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ leave.type }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ leave.start_date }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ leave.end_date }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ leave.reason }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ leave.status }}</td>
                </tr>
              </tbody>
            </table>
            </div>
            <div class="flex justify-between items-center mt-4">
              <div>Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, props.leaves.length) }} of {{ props.leaves.length }} entries</div>
              <div class="flex items-center">
                <button
                  :disabled="currentPage === 1"
                  @click="prevPage"
                  class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
                >
                  Previous
                </button>
                <button
                  :disabled="currentPage === totalPages"
                  @click="nextPage"
                  class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow ml-2"
                >
                  Next
                </button>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>