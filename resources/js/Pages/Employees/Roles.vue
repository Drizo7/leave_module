<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  roles: {
    type: Array,
    required: true,
  },
  permissions: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  role: null,
  permission: null,
});

const roleToAssign = ref(null);
const permissionToAssign = ref(null);

const submit = () => {
  form.post(route('admin.users.assign-role', props.user.id), {
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const assignRole = () => {
  form.role = roleToAssign.value;
  form.post(route('admin.users.assign-role', props.user.id), {
    onSuccess: () => {
      form.reset();
      roleToAssign.value = null;
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const removeRole = (role) => {
  form.delete(route('admin.users.remove-role', [props.user.id, role.id]), {
    onSuccess: () => {
      // Refresh the user data, including the updated roles
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const assignPermission = () => {
  form.permission = permissionToAssign.value;
  form.post(route('admin.users.give-permission', props.user.id), {
    onSuccess: () => {
      form.reset();
      permissionToAssign.value = null;
      // Refresh the user data, including the updated permissions
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const revokePermission = (permission) => {
  form.delete(route('admin.users.revoke-permission', [props.user.id, permission.id]), {
    onSuccess: () => {
      // Refresh the user data, including the updated permissions
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const deleteUser = () => {
  form.delete(route('admin.users.destroy', props.user.id), {
    onSuccess: () => {
      // Redirect or handle the user deletion
    },
    onError: (errors) => {
      console.log('Form errors:', errors);
    },
  });
};

const userIsAdmin = computed(() => props.user.roles.some((role) => role.name === 'admin'));
</script>

<template>
  <Head title="Edit User Roles" />
  <SuperAdminLayout>
    <div class="py-8">
      <div class="max-w-6xl sm:px-3 lg:px-8">
        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Assign Role</h2>
          <form @submit.prevent="assignRole">
            <select v-model="roleToAssign" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
              <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
            </select>
            <InputError :name="form.errors.role" class="mt-2" />
            <button type="submit" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
              Assign Role
            </button>
          </form>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Remove Role</h2>
          <div class="flex flex-wrap gap-2 mb-4">
            <div v-for="role in props.user.roles" :key="role.id" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
              <button @click="removeRole(role)" class="ml-2 text-white hover:text-gray-300">
                {{ role.name }}
              </button>
            </div>
          </div>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Assign Permission</h2>
          <form @submit.prevent="assignPermission">
            <select v-model="permissionToAssign" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
              <option v-for="permission in permissions" :key="permission.id" :value="permission.name">{{ permission.name }}</option>
            </select>
            <InputError :name="form.errors.permission" class="mt-2" />
            <button type="submit" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
              Assign Permission
            </button>
          </form>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Revoke Permission</h2>
          <div class="flex flex-wrap gap-2 mb-4">
            <div v-for="permission in props.user.permissions" :key="permission.id" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
              <button @click="revokePermission(permission)" class="ml-2 text-white hover:text-gray-300">
                {{ permission.name }}
              </button>
            </div>
          </div>
        </div>

        <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
          <h2 class="text-lg font-bold mb-4">Delete User</h2>
          <button @click="deleteUser" :disabled="userIsAdmin" class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-md text-white">
            Delete User
          </button>
        </div>
      </div>
    </div>
  </SuperAdminLayout>
</template>