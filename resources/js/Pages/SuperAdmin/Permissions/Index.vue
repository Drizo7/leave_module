<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import EditButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
  permissions: {
    type: Array,
    required: true,
  },
  permission: {
    type: Object,
    required: true,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const permissions = ref(pageProps.permissions || []);


function deletePermission(id) {
  if (confirm('Are you sure you want to delete this permission?'+ id)) {
    form.delete(route('admin.permissions.destroy', id), {
      onSuccess: (page) => {
        permissions.value = page.props.permissions;
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
    <Head title="Permissions" />
    <SuperAdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="flex justify-end p-2">
                            <TertiallyButton :href="route('admin.permissions.create')">Create permission</TertiallyButton>
                        </div>
                        <table class="w-full table-auto">
                            <thead class="">
                                <tr>
                                <th class="px-4 py-2 text-left font-bold">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(permission, index) in permissions" :key="index" class="border-b">
                                    <td class="px-4 py-2 text-black">{{ permission.name }}</td>
                                    <td>
                                        <div class="flex justify-end px-4 py-2">
                                            <div class="space-x-2">
                                                <EditButton :href="route('admin.permissions.edit', permission.id)">Edit</EditButton>
                                                <DeleteButton @click="deletePermission(permission.id)">Delete</DeleteButton>
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
