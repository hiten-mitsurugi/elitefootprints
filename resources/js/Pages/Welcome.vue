<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';



// Define props
const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    userId: {
        type: Number,
        required: false,
    },
    canLogin: Boolean,
    canRegister: Boolean,
});

// Cart state
// Assuming userId is passed as a prop

const redirectToLogin = () => {
    Inertia.visit('/login');  // Replace with the correct URL to your login page
};
// Pagination
const currentPage = ref(1);
const productsPerPage = 8;

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * productsPerPage;
    const end = start + productsPerPage;
    return props.products.slice(start, end);
});

const totalPages = computed(() => Math.ceil(props.products.length / productsPerPage));

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const goToPage = (page) => {
    currentPage.value = page;
};

// Add this new code for checkout functionality

const page = usePage();




// Handle image load errors
</script>

<template>

    <Head title="Welome to Elite Footprints" />


    <section class="main-home relative w-full h-screen overflow-hidden">
        <!-- Video Background -->
        <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover -z-10">
            <source src="@/Components/Assets/bg.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <!-- Header -->
        <header class="flex items-center justify-between p-5">
            <!-- Brand Name -->
            <h1 class="text-white text-xl font-light pl-8">Elite Footprints</h1>
            <nav class="flex space-x-6">
                <Link :href="route('myHome')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                Home
                </Link>
                <Link :href="route('aboutUs')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                About
                </Link>
                <Link :href="route('contactUS')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                Contact Us
                </Link>
            </nav>


            <!-- Navigation -->
            <nav class="flex space-x-6 pr-8">
                <Link :href="route('login')"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Login
                </Link>
                <Link :href="route('register')"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Register
                </Link>
            </nav>
        </header>

        <!-- Main Text -->
        <div class="main-text text-center px-10 py-36">
            <h5 class="bg-teal-500 bg-opacity-70 text-white text-lg px-4 py-2 rounded-md inline-block shadow-md">
                Elite Footprints Shoe Collection
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
    </section>

    <!-- Trending Section -->

    <section id="trending" class="trending bg-black text-white py-8 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Trending Products</h2>
        <div class="listProduct grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            <div v-for="product in paginatedProducts" :key="product.id"
                class="item bg-gray-200 p-5 rounded-xl flex flex-col justify-between shadow-lg border">

                <!-- Display product image dynamically with shadow -->
                <div class="flex-shrink-0 relative cursor-pointer" @click="redirectToLogin">
                    <img v-if="product.product_image" :src="`/storage/${product.product_image}`" alt="Product Image"
                        class="w-[90%] object-contain transform hover:scale-110 transition-transform duration-400 ease-in-out 
                drop-shadow-[0_50px_20px_#0009] border-none" />
                    <span v-else class="text-black">No image available</span>
                </div>


                <!-- Product name and price with black text -->
                <div class="flex items-center justify-between mt-4 text-black">
                    <h5 class="text-lg font-medium">{{ product.name }}</h5>
                    <p class="text-lg font-medium">${{ product.price }}</p>
                </div>

                <!-- Add to Cart button -->
                <div class="mt-4">
                    <button @click="redirectToLogin"
                        class="bg-black text-white font-medium py-2 px-4 rounded-md shadow-md transform transition duration-300 ease-in-out hover:scale-110 hover:shadow-lg w-full">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination controls -->
        <div class="flex justify-center items-center mt-8 space-x-2">
            <button @click="prevPage" :disabled="currentPage === 1"
                class="px-4 py-2 bg-gray-800 text-white rounded-md disabled:opacity-50">
                Previous
            </button>
            <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
                :class="['px-4 py-2 rounded-md', currentPage === page ? 'bg-red-600 text-white' : 'bg-gray-800 text-white']">
                {{ page }}
            </button>
            <button @click="nextPage" :disabled="currentPage === totalPages"
                class="px-4 py-2 bg-gray-800 text-white rounded-md disabled:opacity-50">
                Next
            </button>
        </div>
    </section>



    <!-- Cart Tab -->
    <div class="fixed top-4 right-4 z-50">
        <button @click="redirectToLogin"
            class="relative p-2 bg-teal-500 rounded-full shadow-lg hover:bg-gray-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

        </button>
    </div>

    <footer class="bg-white text-black py-8">
        <div class="container mx-auto px-6">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8 opacity-80 text-sm">
            <!-- ABOUT ELITE FOOTPRINTS -->
            <div>
              <h3 class="font-semibold mb-3">ABOUT ELITE FOOTPRINTS</h3>
              <p>
                At Elite Footprints, we take pride in crafting exceptional footwear that blends style, comfort, and durability. Our mission is to provide you with shoes that leave an unforgettable mark on the world.
              </p>
            </div>
  
            <!-- CUSTOMER CARE -->
            <div>
              <h3 class="font-semibold mb-3">CUSTOMER CARE</h3>
              <ul class="space-y-2">
                <li>Contact</li>
                <li>Returns/Exchange</li>
                <li>Gift Voucher</li>
                <li>Wishlist</li>
                <li>Special</li>
                <li>Customer Services</li>
                <li>Site Maps</li>
              </ul>
            </div>
  
            <!-- INFORMATION -->
            <div>
              <h3 class="font-semibold mb-3">INFORMATION</h3>
              <ul class="space-y-2">
                <li>About Us</li>
                <li>Delivery Information</li>
                <li>Privacy Policy</li>
                <li>Support</li>
                <li>Order Tracking</li>
              </ul>
            </div>
  
            <!-- CONTACT INFORMATION -->
            <div>
              <h3 class="font-semibold mb-3">CONTACT INFORMATION</h3>
              <p>123 Street, Butuan City, Philippines</p>
              <p class="mt-2">+1235 2355 98</p>
              <p class="mt-2">cats@elitefootprints.com</p>
              <p class="mt-2">elitefootprints.com</p>
            </div>
          </div>
        </div>
      </footer>

</template>