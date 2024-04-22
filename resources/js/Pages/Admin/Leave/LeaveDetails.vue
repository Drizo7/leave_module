<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { usePage,router } from '@inertiajs/vue3';


const props = defineProps({
    leave: {
        type: Object,
        required: true
    }
});

const { post } = usePage();


const approveLeave = () => {
    const url = route('normaladmin.admin-leaves.approve', props.leave.id);
    router.visit(url, { method: 'post' });
};

const rejectLeave = () => {
    const url = route('normaladmin.admin-leaves.reject', props.leave.id);
    router.visit(url, { method: 'post' });
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
                                <form @submit.prevent="approveLeave">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-300"
                                >
                                    Approve
                                </button>
                            </form>
                                <button
                                    @click="rejectLeave"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-300"
                                >
                                    Reject
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Employee ID</p>
                                <p class="text-gray-800">{{ leave.employee_id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Type</p>
                                <p class="text-gray-800">{{ leave.type }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Start Date</p>
                                <p class="text-gray-800">{{ leave.start_date }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">End Date</p>
                                <p class="text-gray-800">{{ leave.end_date }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-600 font-semibold mb-2">Reason</p>
                                <p class="text-gray-800">{{ leave.reason }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Status</p>
                                <p class="text-gray-800">{{ leave.status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>