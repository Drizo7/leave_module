<script setup>
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import EditButton from '@/Components/SecondaryButton.vue';
import DismissibleAlert from '@/Components/DismissibleAlert.vue';
import { ref, computed } from 'vue';

const { props: pageProps, replace } = usePage();
const departments = ref(pageProps.departments || []);

const props = defineProps({
  message: {
    type: String,
    default: null,
  },
});
const form = useForm({});

const search = ref('');
const currentPage = ref(1);
const perPage = 10;

const filteredDepartments = computed(() => {
  return departments.value.filter(department =>
    department.name.toLowerCase().includes(search.value.toLowerCase())
  );
});

const totalPages = computed(() => Math.ceil(filteredDepartments.value.length / perPage));

function deleteDepartment(id) {
  if (confirm('Are you sure you want to delete this department?' + id)) {
    form.delete(route('admin.departments.destroy', id), {
      onSuccess: (page) => {
        departments.value = page.props.departments;
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
  departments.value.sort((a, b) => {
    if (a[key] < b[key]) return -1;
    if (a[key] > b[key]) return 1;
    return 0;
  });
}
</script>

<template>
  <Head title="Departments" />
  <SuperAdminLayout>
    <div class="py-8">
      <dismissible-alert v-if="props.message" :message="props.message" />
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <!-- Search Bar -->
          <div class="flex items-center justify-between py-2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">All Departments</h2>
            <div class="flex items-center mb-2">
              <input v-model="search" type="text" placeholder="Search Department..." class="border-gray-300 mr-4 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full sm:w-auto" />
              <TertiallyButton :href="route('admin.departments.create')">Create department</TertiallyButton>
            </div>
          </div>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
              <table class="table-auto w-full border-collapse bg-white shadow-md">
                <thead>
                  <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    <th class="px-4 py-2 text-left" @click="sortBy('id')">Id</th>
                    <th class="px-4 py-2 text-left" @click="sortBy('name')">Name</th>
                    <th class="px-4 py-2 text-left" @click="sortBy('shortcode')">Code</th>
                    <th class="px-4 py-2 text-left" @click="sortBy('hod')">Hod</th>
                    <th class="px-4 py-2 mr-4 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(department, index) in filteredDepartments" :key="index" class="border-b hover:bg-gray-50 text-sm">
                    <td class="px-4 py-2">{{ department.id }}</td>
                    <td class="px-4 py-2">{{ department.name }}</td>
                    <td class="px-4 py-2">{{ department.shortcode }}</td>
                    <td class="px-4 py-2">{{ department.hod }}</td>
                    <td class="flex justify-end mr-2 py-2">
                      <div class="flex space-x-2">
                        <EditButton :href="route('admin.departments.edit', department.id)">Edit</EditButton>
                        <DeleteButton @click="deleteDepartment(department.id)">Delete</DeleteButton>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Pagination Controls -->
          <div class="flex justify-between items-center mt-4">
            <div>Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, filteredDepartments.length) }} of {{ filteredDepartments.length }} departments</div>
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

