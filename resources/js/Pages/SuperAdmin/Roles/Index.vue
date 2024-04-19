<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import EditButton from '@/Components/SecondaryButton.vue'
import { ref } from 'vue';

const props = defineProps({
  roles: {
    type: Array,
    required: true,
  },
  role: {
    type: Object,
    required: true,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const roles = ref(pageProps.roles || []);

function deleteRole(id) {
  if (confirm('Are you sure you want to delete this role?'+ id)) {
    form.delete(route('admin.roles.destroy', id), {
      onSuccess: (page) => {
        roles.value = page.props.roles;
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
  <Head title="Roles" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex justify-end p-2">
              <TertiallyButton :href="route('admin.roles.create')">Create role</TertiallyButton>
            </div>
            <table class="w-full table-auto">
              <thead class="">
                <tr>
                  <th class="px-4 py-2 text-left font-bold">Role Name</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(role, index) in roles" :key="index" class="border-b">
                  <td class="px-4 py-2 text-black">{{ role.name }}</td>
                  <td>
                    <div class="flex justify-end px-4 py-2">
                      <div class="space-x-2">
                        <EditButton :href="route('admin.roles.edit', role.id)">Edit</EditButton>
                        <DeleteButton @click="deleteRole(role.id)">Delete</DeleteButton>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>