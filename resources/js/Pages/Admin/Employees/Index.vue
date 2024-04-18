<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import { ref } from 'vue';

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

function deleteUser(id) {
  if (confirm('Are you sure you want to delete this user?'+ id)) {
    form.delete(route('admin.users.destroy', id), {
      onSuccess: (page) => {
        users.value = page.props.users;
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
  <Head title="Users" />
  <AdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 mr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index" class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ user.name }}</td>
                            <td class="px-6 py-4">{{ user.email }}</td>
                            <td class="flex justify-end mr-2 py-4" >
                                <div class="flex space-x-2">
                                    <TertiallyButton :href="route('normaladmin.adminusers.show', user.id)">View</TertiallyButton>
                                    <TertiallyButton @click="deleteUser(user.id)">Delete</TertiallyButton>
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