<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import EditButton from '@/Components/SecondaryButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import DismissibleAlert from '@/Components/DismissibleAlert.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  leavetypes: {
    type: Array,
    required: true,
  },
  leavetype: {
    type: Object,
    required: true,
  },
  message: {
    type: String,
    default: null,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const leavetypes = ref(pageProps.leavetypes || []);
const searchQuery = ref('');
const currentPage = ref(1);
const perPage = 10;
let sortColumn = '';
let sortDirection = 'asc';

function deleteLeavetype(id) {
  if (confirm('Are you sure you want to delete this leave type?')) {
    form.delete(route('admin.leavetypes.destroy', id), {
      onSuccess: (page) => {
        leavetypes.value = page.props.leavetypes;
        // Display a success message or redirect to the leave types index page
      },
      onError: (errors) => {
        console.log('Delete error:', errors);
      },
    });
  }
}

const paginatedLeaveTypes = computed(() => {
  const filteredLeaveTypes = leavetypes.value.filter(leavetype =>
    leavetype.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );

  const startIndex = (currentPage.value - 1) * perPage;
  let sortedLeaveTypes = filteredLeaveTypes.slice(startIndex, startIndex + perPage);

  if (sortColumn) {
    sortedLeaveTypes = sortedLeaveTypes.sort((a, b) => {
      const modifier = sortDirection === 'asc' ? 1 : -1;
      if (sortColumn === 'id') {
        return modifier * (a.id - b.id);
      } else {
        return modifier * (a[sortColumn].localeCompare(b[sortColumn]));
      }
    });
  }

  return sortedLeaveTypes;
});

const totalPages = computed(() => Math.ceil(leavetypes.value.length / perPage));

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

function sortBy(column) {
  if (sortColumn === column) {
    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
  } else {
    sortColumn = column;
    sortDirection = 'asc';
  }
}
</script>

<template>
  <Head title="Leavetypes" />
  <AdminLayout>
    <div class="py-8">
      <dismissible-alert v-if="props.message" :message="props.message" />
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="flex items-center justify-between py-2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">All Leave Types</h2>
            <!-- Search Input -->
            <div class="flex items-center">
              <input v-model.trim="searchQuery" type="text" placeholder="Search Leave Type.." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full sm:w-auto mr-4" />
              <TertiallyButton :href="route('normaladmin.leavetypes.create')">Create leavetype</TertiallyButton>
            </div>
          </div>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
              <table class="table-auto w-full border-collapse bg-white shadow-md">
                <thead>
                  <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    <th @click="sortBy('id')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'id' }">Id</th>
                    <th @click="sortBy('name')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'name' }">Name</th>
                    <th @click="sortBy('description')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'description' }">Description</th>
                    <th class="px-4 py-2 mr-4 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="leavetype in paginatedLeaveTypes" :key="leavetype.id" class="border-b hover:bg-gray-50 text-sm">
                    <td class="px-4 py-2">{{ leavetype.id }}</td>
                    <td class="px-4 py-2">{{ leavetype.name }}</td>
                    <td class="px-4 py-2">{{ leavetype.description }}</td>
                    <td class="flex justify-end mr-2 py-2">
                      <div class="flex space-x-2">
                        <EditButton :href="route('normaladmin.leavetypes.edit', leavetype.id)">Edit</EditButton>
                        <DeleteButton @click="deleteLeavetype(leavetype.id)">Delete</DeleteButton>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Pagination Controls -->
          <div class="flex justify-between items-center mt-4">
            <div>Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, leavetypes.length) }} of {{ leavetypes.length }} leave types</div>
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

