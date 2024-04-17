<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

const props = defineProps({
  role: {
    type: Object,
    required: true,
    permissions: {
      type: Array,
      required: true,
    },
  },
  permissions: {
    type: Array,
    required: true,
  },
});


const form = useForm({
  name: props.role.name,
  permission: '',
});

const newPermission = ref('');

function submit() {
  form.patch(route('admin.roles.update', props.role.id), {
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
}

function revokePermission(permissionId) {
   form.post(route('admin.roles.permissions.revoke', { role: props.role.id, permission: permissionId }), {
    onSuccess: () => {
      // Refresh the role data, including the updated permissions
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
}

function assignPermission() {
  form.permission = newPermission.value;
  form.post(route('admin.roles.permissions', props.role.id), {
    onSuccess: () => {
      form.reset();
      // Refresh the role data, including the updated permissions
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
}
</script>

<template>
  <Head title="Edit Role" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <form class="px-2 py-2" @submit.prevent="submit" novalidate>
            <label class="text-gray-700">Role name</label>
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
              {{ props.role.name }}
            </span>
            <textarea
              v-model="form.name"
              placeholder="name"
              class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            ></textarea>
            <InputError :name="form.errors.name" class="mt-2" />
            <button
              type="submit"
              class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              Update
            </button>
          </form>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Role Permissions</h2>

          <div class="flex flex-wrap gap-2 mb-4">
            <div
              v-for="permission in props.role.permissions"
              :key="permission.id"
              class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
              <button @click="revokePermission(permission.id)" class="ml-2 text-white hover:text-gray-300">
                {{ permission.name }}
              </button>
            </div>
          </div>

          <form @submit.prevent="assignPermission">
            <label class="text-gray-700">Assign Permission</label>
            <select
              v-model="newPermission"
              class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
              <option v-for="permission in props.permissions" :key="permission.id" :value="permission.name">
                {{ permission.name }}
              </option>
            </select>
            <InputError :name="form.errors.permission" class="mt-2" />
            <button
              type="submit"
              class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              Assign
            </button>
          </form>
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>