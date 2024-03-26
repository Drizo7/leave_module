<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import 'primeicons/primeicons.css'
import axios from 'axios';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Side Navigation -->
            <div class="fixed top-0 left-0 h-full w-48 bg-[#0D2C49] p-5">
                <div class="mb-5">
                    <div class="shrink-0 flex items-center text-white">
                        <Link :href="route('dashboard')">
                            Kumsoft
                        </Link>
                    </div>
                </div>
                <nav>
                    <div>
                        <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block py-2 text-white hover:text-gray-300">
                            Dashboard
                        </NavLink>
                        <NavLink :href="route('employees')" :active="route().current('employees')" class="block py-2 text-white hover:text-gray-300">
                            Employees
                        </NavLink>
                        <NavLink :href="route('departments')" :active="route().current('departments')" class="block py-2 text-white hover:text-gray-300">
                            Departments
                        </NavLink>
                        <NavLink :href="route('leavetypes')" :active="route().current('leavetypes')" class="block py-2 text-white hover:text-gray-300">
                            Leave Types
                        </NavLink>
                        <NavLink class="block py-2 text-white hover:text-gray-300">
                            Admin Settings
                        </NavLink>
                        <!-- <NavLink :href="route('chirps.index')" :active="route().current('chirps.index')" class="block py-2 text-white hover:text-gray-300">
                            Chirps
                        </NavLink> -->
                    </div>
                </nav>
            </div>

            <div class="flex-1 pl-48">
                <nav class="bg-white border-b border-gray-100">
                    <!-- Primary Navigation Menu -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Left side content (if any) -->
                                <div class="flex items-center">
                                    <span>Directory...</span>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- Search Input -->
                                <span class="relative mr-4 flex items-center">
                                    <div class="relative">
                                        <i class="pi pi-search absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></i>
                                        <InputText v-model="value1" placeholder="Quick Search" class="h-8 pl-10 pr-2 rounded-md border border-gray-300 focus:ring-indigo-200 focus:border-indigo-300 focus:ring-opacity-50 text-sm shadow-sm" />
                                    </div>
                                </span>

                                <!-- Settings Dropdown -->
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {{ $page.props.auth.user.name }}

                                                    <svg
                                                        class="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                            <DropdownLink :href="route('logout')" method="post" as="button">
                                                Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                >
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path
                                            :class="{
                                                hidden: showingNavigationDropdown,
                                                'inline-flex': !showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{
                                                hidden: !showingNavigationDropdown,
                                                'inline-flex': showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>




