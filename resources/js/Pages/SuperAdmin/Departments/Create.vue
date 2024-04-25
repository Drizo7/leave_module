<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import SuperAdminLayout from '@/Layouts/SuperAdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    shortcode: '',
    hod: '',
});

function submit() {
  form.post(route('admin.departments.store'), {
    onSuccess: () => form.reset(),
    onError: (errors) => {
        alert(`Error: ${errors}`);
      console.log('Form errors:', errors);
    },
  });
}

</script>


<template>
    <Head title="Create Departments" />
    <SuperAdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">  
                        <form class="px-2 py-2" @submit.prevent="submit" novalidate>
                            <div class="mt-2">
                                <label class="text-gray-700">Department name</label>
                                <TextInput
                                    v-model="form.name"
                                    placeholder="name"
                                    class="mt-1 block w-full"/>
                                <InputError :name="form.errors.name" class="mt-2" />                                
                            </div>
                            <div class="mt-4">
                                <label class="text-gray-700">Department shortcode</label>
                                <TextInput
                                    v-model="form.shortcode"
                                    placeholder="shortcode"
                                    class="mt-1 block w-full"/>
                                <InputError :shortcode ="form.errors.shortcode" class="mt-2" />                               
                            </div>
                            <div class="mt-4">
                                <label class="text-gray-700">Head of Department</label>
                                <TextInput
                                    v-model="form.hod"
                                    placeholder="hod"
                                    class="mt-1 block w-full"/>
                                <InputError :hod="form.errors.hod" class="mt-2" />     
                            </div>
                            <div class="flex items-center gap-4 mt-2">
                                <button type="submit" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Submit</button>
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0">   
                                </Transition>
                            </div>
                        </form>                 
                </div>
            </div>
        </div>
    </SuperAdminLayout>
</template>
