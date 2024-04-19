<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import TertiallyButton from '@/Components/TertiallyButton.vue';
import DeleteButton from '@/Components/DangerButton.vue';
import EditButton from '@/Components/SecondaryButton.vue'
import { ref } from 'vue';

const props = defineProps({
    leavetypes: {
    type: Array,
    required: true,
  },
  leavetype: {
    type: Object,
    required: true,
  },
});

const form = useForm({});

const { props: pageProps, replace } = usePage();
const leavetypes = ref(pageProps.leavetypes || []);

function deleteLeavetype(id) {
  if (confirm('Are you sure you want to delete this leavetype?'+ id)) {
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
</script>

<template>
  <Head title="Leavetypes" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex justify-end p-2">
              <TertiallyButton :href="route('admin.leavetypes.create')">Create leavetype</TertiallyButton>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse bg-white shadow-md">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Description</th>
                <th class="px-6 py-3 mr-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(leavetype, index) in leavetypes" :key="index" class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ leavetype.name }}</td>
                <td class="px-6 py-4">{{ leavetype.description }}</td>
                <td class="flex justify-end px-4 py-2" >
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
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>