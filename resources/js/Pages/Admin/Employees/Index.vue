<template>
  <Head title="Users" />
  <AdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="flex items-center justify-between py-2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">All Employees</h2>
            <!-- Search Input -->
            <div class="flex items-center">
              <input v-model.trim="searchQuery" type="text" placeholder="Search Employee.." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full sm:w-auto mr-4" />
              </div>
          </div>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
              <table class="table-auto w-full border-collapse bg-white shadow-md">
                <thead>
                  <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    <th @click="sortBy('id')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'id' }">Id</th>  
                    <th @click="sortBy('name')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'name' }">Name</th>
                    <th @click="sortBy('email')" :class="{ 'cursor-pointer': true, 'px-4 py-2 text-left': true, 'bg-gray-100': sortColumn === 'email' }">Email</th>
                    <th class="px-4 py-2 mr-4 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in paginatedUsers" :key="index" class="border-b hover:bg-gray-50 text-sm">
                    <td class="px-4 py-2">{{ user.id }}</td>  
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.email }}</td>
                    <td class="flex justify-end mr-2 py-2" >
                      <div class="flex space-x-2">
                        <ViewButton :href="route('normaladmin.users.show', user.id)">View</ViewButton>
                        <DeleteButton @click="deleteUser(user.id)">Delete</DeleteButton>
                      </div>
                    </td>
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

<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import ViewButton from '@/Components/ViewButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const users = ref(pageProps.users || []);
const currentPage = ref(1);
const perPage = 10;
let sortColumn = '';
let sortDirection = 'asc';
const searchQuery = ref('');

function deleteUser(id) {
  if (confirm('Are you sure you want to delete this user?')) {
    form.delete(route('normaladmin.users.destroy', id), {
      onSuccess: (page) => {
        users.value = page.props.users;
        // Display a success message or redirect to the users index page
      },
      onError: (errors) => {
        console.log('Delete error:', errors);
      },
    });
  }
}

const paginatedUsers = computed(() => {
  const filteredUsers = users.value.filter(user =>
    user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
  );

  const startIndex = (currentPage.value - 1) * perPage;
  let sortedUsers = filteredUsers.slice(startIndex, startIndex + perPage);

  if (sortColumn) {
    sortedUsers = sortedUsers.sort((a, b) => {
      const modifier = sortDirection === 'asc' ? 1 : -1;
      if (sortColumn === 'id') {
        return modifier * (a.id - b.id);
      } else {
        return modifier * (a[sortColumn].localeCompare(b[sortColumn]));
      }
    });
  }

  return sortedUsers;
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

function sortBy(column) {
  if (sortColumn === column) {
    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
  } else {
    sortColumn = column;
    sortDirection = 'asc';
  }
}
</script>
