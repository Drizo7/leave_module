<template>
    <div class="sidenav">
      <div class="sidenav-header">
        <div class="shrink-0 flex items-center text-white">
                                <Link :href="route('dashboard')">
                                    Kumsoft
                                </Link>
                            </div>
      </div>
      <nav>
        <div>
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('chirps.index')" :active="route().current('chirps.index')">
                                    Chirps
                                </NavLink>
                            </div> 
        
      </nav>
    </div>
  </template>
  
  <script  setup>
  import { Link } from '@inertiajs/vue3';
  import ApplicationLogo from '@/Components/ApplicationLogo.vue';
  import NavLink from '@/Components/NavLink.vue';
  </script>
  
  <style>
  .sidenav {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 200px; /* Adjust the width as needed */
    background-color: #0D2C49;
    padding: 20px;
  }
  
  .sidenav-header {
    margin-bottom: 20px;
  }
  
  .sidenav nav ul {
    list-style-type: none;
    padding: 0;
  }
  
  .sidenav nav a {
    display: block;
    padding: 8px 16px;
    text-decoration: none;
    color: #fff;
  }
  
  .sidenav nav a:hover {
    color: #ddd;
  }
  </style>