<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});
const { post } = usePage();

const approveLeave = () => {
    post(route('normaladmin.leaves.approve', props.leave.id), {
        onSuccess: () => {
            console.log('Leave approved');
            // Add any additional logic or state updates here
        }
    });
};

const rejectLeave = () => {
    post(route('normaladmin.leaves.reject', props.leave.id), {
        onSuccess: () => {
            console.log('Leave rejected');
            // Add any additional logic or state updates here
        }
    });
};
</script>

<template>
    <Head title="Leave Details" />
    <AdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
                    <div class="flex flex-col gap-6 mb-8 ml-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-semibold text-gray-800">Leave Details</h2>
                            <div class="flex gap-4">
                                <button
                                    @click="approveLeave"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-300"
                                >
                                    Approve
                                </button>
                                <button
                                    @click="rejectLeave"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-300"
                                >
                                    Reject
                                </button>
                            </div>
                        </div>
                        <div  class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Employee Id</p>
                                <p class="text-gray-800">{{ user.id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Employee Name</p>
                                <p class="text-gray-800">{{ user.name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Employee Email</p>
                                <p class="text-gray-800">{{ user.email }}</p>
                            </div>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>