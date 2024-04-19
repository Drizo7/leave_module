<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import AssignButton from '@/Components/SuccessButton.vue';
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
  <SuperAdminLayout>
      <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-medium text-gray-900 mb-4">All Employees</h2>
          <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
                    <thead>
                        <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 mr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index" class="border-b hover:bg-gray-50 text-sm">
                            <td class="px-4 py-2">{{ user.name }}</td>
                            <td class="px-4 py-2">{{ user.email }}</td>
                            <td class="flex justify-end mr-2 py-2" >
                                <div class="flex space-x-2">
                                    <AssignButton :href="route('admin.users.show', user.id)">Assign Role</AssignButton>
                                    <DeleteButton @click="deleteUser(user.id)">Delete</DeleteButton>
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
  </SuperAdminLayout>
</template>