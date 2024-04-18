<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
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
    form.delete(route('normaladmin.admindepartments.destroy', id), {
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
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex justify-end p-2">
              <TertiallyButton :href="route('normaladmin.admindepartments.create')">Create department</TertiallyButton>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Code</th>
                <th class="px-6 py-3 text-left">Hod</th>
                <th class="px-6 py-3 mr-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(department, index) in departments" :key="index" class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ department.name }}</td>
                <td class="px-6 py-4">{{ department.shortcode }}</td>
                <td class="px-6 py-4">{{ department.hod }}</td>
                <td class="flex justify-end mr-2 py-4" >
                    <div class="flex space-x-2">
                        <TertiallyButton :href="route('normaladmin.admindepartments.edit', department.id)">Edit</TertiallyButton>
                        <TertiallyButton @click="deleteDepartment(department.id)">Delete</TertiallyButton>
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