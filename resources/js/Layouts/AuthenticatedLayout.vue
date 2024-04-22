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
              <NavLink :href="route('employee-leaves.create')" :active="route().current('employee-leaves.create')" class="block py-2 text-white hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" class="inline-block h-5 w-5 mr-2" viewBox="0 0 16 16"><g fill="white"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178l1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494l-1.895 4.738a.5.5 0 1 0 .928.372zm-2.54 1.183L5.93 9.363L1.591 6.602z"/><path d="M16 12.5a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/></g></svg>
                  Apply leave
                </NavLink>
                <NavLink :href="route('employee-leaves.index')" :active="route().current('employee-leaves.index')" class="block py-2 text-white hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" class="inline-block h-5 w-5 mr-2" viewBox="0 0 24 24"><path fill="white" d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M5 19V5h2v2h10V5h2v4.68c-.91-.43-1.92-.68-3-.68H7v2h4.1c-.6.57-1.06 1.25-1.42 2H7v2h2.08c-.05.33-.08.66-.08 1c0 1.08.25 2.09.68 3zm11 2c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z"/></svg>
                  Leave History
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
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" class="inline-block h-5 w-5 mr-2" viewBox="0 0 16 16"><g fill="white"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178l1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494l-1.895 4.738a.5.5 0 1 0 .928.372zm-2.54 1.183L5.93 9.363L1.591 6.602z"/><path d="M16 12.5a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/></g></svg>
                  Apply leave
                </NavLink>
                <NavLink :href="route('employee-leaves.index')" :active="route().current('employee-leaves.index')" class="block py-2 text-white hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" class="inline-block h-5 w-5 mr-2" viewBox="0 0 24 24"><path fill="white" d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M5 19V5h2v2h10V5h2v4.68c-.91-.43-1.92-.68-3-.68H7v2h4.1c-.6.57-1.06 1.25-1.42 2H7v2h2.08c-.05.33-.08.66-.08 1c0 1.08.25 2.09.68 3zm11 2c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z"/></svg>
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
  




