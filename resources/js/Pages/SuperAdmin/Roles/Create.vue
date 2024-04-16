<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    name: '',
});

function submit() {
  form.post(route('admin.roles.store'), {
    onSuccess: () => form.reset(),
    onError: (errors) => {
        alert(`Error: ${errors}`);
      console.log('Form errors:', errors);
    },
  });
}

</script>


<template>
    <Head title="Create Roles" />
    <SuperAdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
                        <form class="px-2 py-2" @submit.prevent="submit" novalidate>
                            <label class="text-gray-700">Post name</label>
                            <textarea
                                v-model="form.name"
                                placeholder="name"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            ></textarea>
                            <InputError :name="form.errors.name" class="mt-2" />
                            <button type="submit" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Submit</button>
                        </form>                    
                </div>
            </div>
        </div>
    </SuperAdminLayout>
</template>
