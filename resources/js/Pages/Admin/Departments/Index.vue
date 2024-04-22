<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import EditButton from '@/Components/SecondaryButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';

const props = defineProps({
  departments: {
    type: Array,
    required: true,
  },
  department: {
    type: Object,
    required: true,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const departments = ref(pageProps.departments || []);

function deleteDepartment(id) {
  if (confirm('Are you sure you want to delete this role?'+ id)) {
    form.delete(route('normaladmin.departments.destroy', id), {
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
</script>

<template>
  <Head title="Departments" />
  <AdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="flex items-center justify-between py-2">
              <h2 class="text-lg font-medium text-gray-900 mb-4">All Departments</h2>
              <div class="flex items-center">
                  <TertiallyButton :href="route('normaladmin.departments.create')">Create department</TertiallyButton>
              </div>
          </div>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
                  <thead>
                      <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                          <th class="px-4 py-2 text-left">Id</th>
                          <th class="px-4 py-2 text-left">Name</th>
                          <th class="px-4 py-2 text-left">Short Code</th>
                          <th class="px-4 py-2 mr-4 text-right">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(department, index) in departments" :key="index" class="border-b hover:bg-gray-50 text-sm">
                          <td class="px-4 py-2">{{ department.id }}</td>
                          <td class="px-4 py-2">{{ department.name }}</td>
                          <td class="px-4 py-2">{{ department.shortcode }}</td>
                          <td class="flex justify-end mr-2 py-2" >
                              <div class="flex space-x-2">
                                  <EditButton :href="route('normaladmin.departments.edit', department.id)">Edit</EditButton>
                                  <DeleteButton @click="deleteDepartment(department.id)">Delete</DeleteButton>
                              </div>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>