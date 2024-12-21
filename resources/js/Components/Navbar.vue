<template>
  <nav class="flex justify-between items-center p-4 bg-gray-800 shadow-md">
    <!-- Navbar title -->
    <div class="text-lg font-semibold text-white mr-4">
      Elite Footprints
    </div>

    <div class="flex gap-x-6 w-full">
      <!-- Left Side Links (Home, About Us, Contact Us) - Visible only for authenticated users -->
      <div class="flex gap-x-6 flex-grow">
        <li v-if="!$page.props.checkAuth.user" class="list-none">
          <Link class="text-white hover:text-gray-400 transition" :href="route('myHome')">Home</Link>
        </li>
        <li v-if="!$page.props.checkAuth.user" class="list-none">
          <Link class="text-white hover:text-gray-400 transition" :href="route('aboutUs')">About Us</Link>
        </li>
        <li v-if="!$page.props.checkAuth.user" class="list-none">
          <Link class="text-white hover:text-gray-400 transition" :href="route('contactUS')">Contact Us</Link>
        </li>
      </div>

      <!-- Right Side Links (Login, Register, or Dropdown) -->
      <div class="flex gap-x-6 ml-auto">
        <!-- Show Login and Register links if not authenticated -->
        <li v-if="!$page.props.checkAuth.user" class="list-none">
          <Link class="text-white hover:text-gray-400 transition" :href="route('login')">Login</Link>
        </li>
        <li v-if="!$page.props.checkAuth.user" class="list-none">
          <Link class="text-white hover:text-gray-400 transition" :href="route('register')">Register</Link>
        </li>

        <!-- Show Dropdown with user information and Log Out if authenticated -->
        <Dropdown v-if="$page.props.checkAuth.user" align="right" width="48">
          <template #trigger>
            <span class="inline-flex rounded-md">
              <button type="button"
                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                {{ $page.props.auth.user?.name || 'User' }}  <!-- Display user name or default text -->
                <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
          </template>
        </Dropdown>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
</script>

<style scoped>
/* Remove the default list bullets (dots) */
li {
  list-style: none;
}
</style>
