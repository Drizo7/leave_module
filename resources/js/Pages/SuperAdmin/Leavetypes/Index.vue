<template>
  <Head title="Leavetypes" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="flex items-center justify-between py-2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">All Leave Types</h2>
            <!-- Search Bar -->
            <div class="flex items-center">
              <input v-model="search" type="text" placeholder="Search Leave Type..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full sm:w-auto" />
            </div>
          </div>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
              <table class="table-auto w-full border-collapse bg-white shadow-md">
                <thead>
                  <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    <th class="px-4 py-2 text-left" @click="sortBy('id')">Id</th>
                    <th class="px-4 py-2 text-left" @click="sortBy('name')">Name</th>
                    <th class="px-4 py-2 text-left" @click="sortBy('description')">Description</th>
                    <th class="px-4 py-2 mr-4 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(leavetype, index) in filteredLeaveTypes" :key="index" class="border-b hover:bg-gray-50 text-sm">
                    <td class="px-4 py-2">{{ leavetype.id }}</td>
                    <td class="px-4 py-2">{{ leavetype.name }}</td>
                    <td class="px-4 py-2">{{ leavetype.description }}</td>
                    <td class="flex justify-end mr-2 py-2">
                      <div class="flex space-x-2">
                        <EditButton :href="route('admin.leavetypes.edit', leavetype.id)">Edit</EditButton>
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
            <div>Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, filteredLeaveTypes.length) }} of {{ filteredLeaveTypes.length }} leave types</div>
            <div class="flex items-center">
              <button :disabled="currentPage === 1" @click="prevPage" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Previous</button>
              <button :disabled="currentPage === totalPages" @click="nextPage" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow ml-2">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>

<script setup>
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import DeleteButton from '@/Components/DangerButton.vue';
import EditButton from '@/Components/SecondaryButton.vue';
import { ref, computed } from 'vue';

const { props: pageProps, replace } = usePage();
const leavetypes = ref(pageProps.leavetypes || []);

const form = useForm({});

const search = ref('');
const currentPage = ref(1);
const perPage = 10;

const filteredLeaveTypes = computed(() => {
  return leavetypes.value.filter(leavetype =>
    leavetype.name.toLowerCase().includes(search.value.toLowerCase())
  );
});

const totalPages = computed(() => Math.ceil(filteredLeaveTypes.value.length / perPage));

function deleteLeavetype(id) {
  if (confirm('Are you sure you want to delete this leavetype?' + id)) {
    form.delete(route('admin.leavetypes.destroy', id), {
      onSuccess: (page) => {
        leavetypes.value = page.props.leavetypes;
        // Display a success message or redirect to the roles index page
      },
      onError: (errors) => {
        console.log('Delete error:', errors);
      },
    });
  }
}

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

function sortBy(key) {
  leavetypes.value.sort((a, b) => {
    if (a[key] < b[key]) return -1;
    if (a[key] > b[key]) return 1;
    return 0;
  });
}
</script>
