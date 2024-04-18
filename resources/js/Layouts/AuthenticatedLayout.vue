<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import DashboardIcon from '@/Assets/dashboard.png';
import DepartmentsIcon from '@/Assets/department.png';
import EmployeesIcon from '@/Assets/ph-users.png';
import LeavetypesIcon from '@/Assets/leave.png';
import AdminsettingsIcon from '@/Assets/settings.png';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import 'primeicons/primeicons.css'
import axios from 'axios';

const showingNavigationDropdown = ref(false);
const value1 = ref('');

const toggleNavigation = () => {
  showingNavigationDropdown.value = !showingNavigationDropdown.value;
};

</script>

<template>
    <div>
      <!-- Navigation -->
      <nav class="bg-white border-b border-gray-200 shadow-md fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4m sm:px-6 lg:ml-48 flex justify-between h-16 items-center">
          <!-- Left side content -->
          <div class="flex items-center">
            <span>{{ $page.props.pageName }}</span>
          </div>
  
          <!-- Right side content -->
          <div class="flex items-center">
            <!-- Search Input -->
            <div class="relative">
              <i class="pi pi-search absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></i>
              <InputText v-model="value1" placeholder="Quick Search" class="h-8 pl-10 pr-2 rounded-md border border-gray-300 focus:ring-indigo-200 focus:border-indigo-300 focus:ring-opacity-50 text-sm shadow-sm" />
            </div>
  
            <!-- Settings Dropdown -->
            <div class="ms-3 relative">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                      {{ $page.props.auth.user.name }}
                      <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </span>
                </template>
  
                <template #content>
                  <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                </template>
              </Dropdown>
            </div>
  
            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
              <button @click="toggleNavigation" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                  <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </nav>
  
      <!-- Side Navigation -->
      <transition name="slide">
      <div v-show="showingNavigationDropdown" class="lg:hidden relative top-16 left-0 w-auto h-auto bg-[#0D2C49] p-5">
        <nav>
          <div class="flex flex-col items-center"> <!-- Added flex and flex-col classes -->
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block py-2 text-white hover:text-gray-300">
                <img :src="DashboardIcon" class="inline-block h-5 w-5 mr-2" alt="Dashboard Icon" />
                Dashboard
              </NavLink>
              <NavLink :href="route('employee-leaves.create')" :active="route().current('employee-leaves.create')" class="block py-2 text-white hover:text-gray-300">
                <img :src="EmployeesIcon" class="inline-block h-5 w-5 mr-2" alt="Employees Icon" />
                Apply leave
              </NavLink>
              <NavLink class="block py-2 text-white hover:text-gray-300">
                <img :src="AdminsettingsIcon" class="inline-block h-5 w-5 mr-2" alt="AdminSettings Icon" />
                Settings
              </NavLink>
            </div>
          </nav>
        </div>
        </transition>

        <!-- Side Navigation (visible on large screens) -->
      <div class="hidden lg:block top-0 left-0 h-screen overflow-y-auto w-48 bg-[#0D2C49] p-5 fixed z-10 flex flex-col justify-between">
        <div>
          <h2 class="text-white">App Name</h2>
        
            <!-- Side navigation content -->
            <nav>  
              <div class="mt-8">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block py-2 text-white hover:text-gray-200">
                  <img :src="DashboardIcon" class="inline-block h-5 w-5 mr-2" alt="Dashboard Icon" />
                  Dashboard
                </NavLink>
                <NavLink :href="route('employee-leaves.create')" :active="route().current('employee-leaves.create')" class="block py-2 text-white hover:text-gray-200">
                  <img :src="EmployeesIcon" class="inline-block h-5 w-5 mr-2" alt="Employees Icon" />
                  Apply leave
                </NavLink>
                <NavLink :href="route('employee-leaves.index')" :active="route().current('employee-leaves.index')" class="block py-2 text-white hover:text-gray-200">
                  <img :src="EmployeesIcon" class="inline-block h-5 w-5 mr-2" alt="Employees Icon" />
                  Leave History
                </NavLink>
              </div>
            </nav>
          </div>
            <div class="absolute bottom-2">
                <NavLink class="block py-2 text-white hover:text-gray-300">
                  <img :src="AdminsettingsIcon" class="inline-block h-5 w-5 mr-2" alt="Settings Icon" />
                  Settings
                </NavLink>
              </div>
          </div>
      
       <!-- Main content -->
       <div class="lg:ml-48 mt-0 pt-16 pb-16 overflow-y-auto">
        
          <!-- Page content -->
          
          
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
              <!-- Header content -->
              <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
              </div>
            </header>
            <div>
            <!-- Page Content -->
            <main>
              <!-- Main content -->
              <div>
              <slot />
            </div>
            </main>
          </div>
        </div>
    </div>
</template>  
<style>
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter, .slide-leave-to {
  transform: translateX(-100%);
}
</style>
  




