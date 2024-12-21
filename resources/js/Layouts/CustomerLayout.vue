<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { computed } from 'vue'


const page = usePage();
const isAuthenticated = computed(() => !!page.props.checkAuth.user);

</script>

<template>
    <div class="main-layout relative w-full min-h-screen overflow-hidden">

        <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover -z-10">
            <source src="@/Components/Assets/bg.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <!-- Header -->
        <header class="flex items-center justify-between p-5">
            <h1 class="text-white text-xl font-light pl-8">Elite Footprints</h1>
            <!-- Brand Name -->
            <nav class="flex space-x-6">
                <Link :href="route('myHome')" v-if="!$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition-all duration-300 ease-in-out hover:text-teal-500 hover:underline hover:scale-110 transform px-4 py-2">
                Home
                </Link>
                <Link :href="route('aboutUs')" v-if="!$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition-all duration-300 ease-in-out hover:text-teal-500 hover:underline hover:scale-110 transform px-4 py-2">
                About Us
                </Link>
                <Link :href="route('shop')" v-if="$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition-all duration-300 ease-in-out hover:text-teal-500 hover:underline hover:scale-110 transform px-4 py-2">
                Shop
                </Link>
                <Link :href="route('dashboard')" v-if="$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition-all duration-300 ease-in-out hover:text-teal-500 hover:underline hover:scale-110 transform px-4 py-2">
                Dashboard
                </Link>
                <Link :href="route('contactUS')" v-if="$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition-all duration-300 ease-in-out hover:text-teal-500 hover:underline hover:scale-110 transform px-4 py-2">
                Contact Us
                </Link>
            </nav>




            <!-- Navigation -->
            <nav class="flex space-x-6 pr-8">
                <Link :href="route('login')" v-if="!$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Login
                </Link>
                <Link :href="route('register')" v-if="!$page.props.checkAuth.user"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Register
                </Link>

                <Dropdown v-if="$page.props.checkAuth.user" align="right" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button"
                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                {{ $page.props.auth.user?.name || 'User' }}
                                <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('dashboard')">Dashboard</DropdownLink>
                        <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                    </template>
                </Dropdown>
            </nav>
        </header>

        <div class="main-text text-center px-10 py-36">
            <h5 class="bg-teal-500 bg-opacity-70 text-white text-lg px-4 py-2 rounded-md inline-block shadow-md">
                Spring Shoe Collection
            </h5>
            <h1 class="text-white text-4xl lg:text-7xl font-bold mt-2 mb-4">
                Elevate Your Style with Our Exquisite Collection
            </h1>
            <p class="text-teal-400 italic text-lg mb-6">
                Discover the Perfect Pair for Every Trend
            </p>
            <a href="#trending"
                class="main-btn inline-block bg-red-600 text-white text-base font-medium px-6 py-3 rounded-md shadow-md hover:bg-teal-500 hover:text-black transition-all">
                Shop now <i class="bx bx-shopping-bag"></i>
            </a>
        </div>


        <!-- Slot for page content -->
        <slot></slot>
    </div>
</template>
