<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, usePage} from '@inertiajs/vue3';
import { ref, } from 'vue';

const {totalEmployees,totalDepartments,totalLeavetypes} = 
defineProps({
    users: {
        type: Array,
        required: true,
        },        
    totalEmployees: {
        type: Number,
        required: true,
        },
    totalDepartments: {
        type: Number,
        required: true,
        },
    totalLeavetypes: {
        type: Number,
        required: true,
        },
    });

const { props: pageProps, replace } = usePage();
const users = ref(pageProps.users || []);

</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
                        <div class="flex flex-col gap-6 mb-8 ml-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-purple-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Total Employees</p>
                                <p class="text-4xl font-semi-bold">{{ totalEmployees }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-blue-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Departments</p>
                                <p class="text-4xl font-semi-bold">{{ totalDepartments }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-orange-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Leave Types</p>
                                <p class="text-4xl font-semi-bold">{{ totalLeavetypes }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-yellow-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Pending</p>
                                <p class="text-4xl font-semi-bold">22</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-green-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Approved</p>
                                <p class="text-4xl font-semi-bold">15</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-red-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Rejected</p>
                                <p class="text-4xl font-semi-bold">5</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse bg-white shadow-md">
                                <thead>
                                    <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        <th class="px-4 py-2 text-left">Id</th>
                                        <th class="px-4 py-2 text-left">Name</th>
                                        <th class="px-4 py-2 text-left">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users" :key="index" class="border-b hover:bg-gray-50 text-sm">
                                        <td class="px-4 py-2">{{ user.id }}</td>
                                        <td class="px-4 py-2">{{ user.name }}</td>
                                        <td class="px-4 py-2">{{ user.email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
