<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  permission: {
    type: Object,
    required: true,
    roles: {
      type: Array,
      required: true,
    },
  },
  roles: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  name: props.permission.name,
  role: '',
});

function submit() {
  form.patch(route('admin.permissions.update', props.permission.id), {
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
}

function revokeRole(roleId) {
  // Implement the logic to revoke a role from the permission
  // You can use the `useForm` composable and `patch` method to send the request
}

function assignRole() {
  form.role = newRole.value;
  form.post(route('admin.permissions.roles', props.permission.id), {
    onSuccess: () => {
      form.reset();
      // Refresh the permission data, including the updated roles
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
}
</script>

<template>
  <Head title="Edit Permission" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <form class="px-2 py-2" @submit.prevent="submit" novalidate>
            <label class="text-gray-700">Permission name</label>
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
              {{ props.permission.name }}
            </span>
            <input
              v-model="form.name"
              type="text"
              placeholder="name"
              class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
            <InputError :name="form.errors.name" class="mt-2" />
            <button
              type="submit"
              class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
              Update
            </button>
          </form>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Roles</h2>

          <div class="flex flex-wrap gap-2 mb-4">
            <div v-for="role in props.permission.roles":key="role.id" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
                {{ role.name }}
                <button @click="revokeRole(role.id)" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    &times;
                </button>
            </div>
          </div>

          <form @submit.prevent="assignRole">
            <label class="text-gray-700">Assign Role</label>
            <select
              v-model="newRole"
              class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
              <option v-for="role in props.roles" :key="role.id" :value="role.name">
                {{ role.name }}
              </option>
            </select>
            <InputError :name="form.errors.role" class="mt-2" />
            <button
              type="submit"
              class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
              Assign
            </button>
          </form>
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>