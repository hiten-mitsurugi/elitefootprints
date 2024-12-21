<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';


// Define props
const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    userId: {
        type: Number,
        required: true,
    },
    canLogin: Boolean,
    canRegister: Boolean,
});

// Cart state
const cartItems = ref([]);
const isCartOpen = ref(false);
const form = useForm({
    cart: [],
});

// Function to add item to cart
const userId = props.userId; // Assuming userId is passed as a prop

const addToCart = (product) => {
    localStorage.setItem('userId', userId); // Store user ID in local storage
    const existingItem = cartItems.value.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cartItems.value.push({
            ...product,
            quantity: 1,
            image: product.product_image // Make sure this matches your product image property name
        });
    }
    updateLocalStorage();
};

// Function to remove item from cart
const removeFromCart = (productId) => {
    cartItems.value = cartItems.value.filter(item => item.id !== productId);
    updateLocalStorage();
};

// Function to toggle cart visibility
const toggleCart = () => {
    isCartOpen.value = !isCartOpen.value;
};

// Function to update localStorage


// Load cart from localStorage on component mount
onMounted(() => {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cartItems.value = JSON.parse(savedCart);
    }
});

// Computed property for cart items count
const cartItemsCount = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity, 0);
});
const increaseQuantity = (item) => {
    item.quantity += 1;
    updateLocalStorage();
};

// Function to decrease item quantity
const decreaseQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity -= 1;
    } else {
        removeFromCart(item.id);
    }
    updateLocalStorage();
};

// Computed property for total cost
const totalCost = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0).toFixed(2);
});
// New state for modal
const selectedProduct = ref(null);
const isModalOpen = ref(false);

// Function to open modal
const openModal = (product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
};

// Function to close modal
const closeModal = () => {
    isModalOpen.value = false;
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

//checkout
const checkout = async () => {
    console.log('Checkout function triggered');

    // Check if the cart is empty
    if (cartItems.value.length === 0) {
        alert('Your cart is empty!');
        console.log('Alert: Cart is empty');
        return;
    }

    // Prepare the cart data
    const cartData = cartItems.value.map(item => ({
        product_id: item.id,
        quantity: item.quantity,
        price: item.price,
    }));
    console.log('Cart data to send:', cartData);

    try {
        // Send cart data to the backend
        await Inertia.post(route('checkout'), { cart: cartData, userId }, {
            preserveState: false,
            preserveScroll: false,
        });

        // If successful, clear all storage and cart
        console.log('Checkout successful.');

        // Clear all localStorage
        localStorage.clear();
        console.log('All localStorage cleared.');

        // Clear cart in memory
        cartItems.value = [];
        console.log('Cart items in memory after clearing:', cartItems.value);

        // Re-trigger reactivity to ensure UI updates
        cartItems.value = [...cartItems.value];
        console.log('Reactivity triggered for cart items.');

        // Optional: Close and re-open modal to ensure UI refresh
        isCartOpen.value = false;
        setTimeout(() => {
            isCartOpen.value = true;
        }, 100);

        // Show success alert
        alert('Checkout successfully!');
    } catch (error) {
        // Handle errors from the backend
        console.error('Checkout failed:', error);
        alert('Checkout failed! Please try again.');
    }
};





// Helper function to update local storage
const updateLocalStorage = () => {

    localStorage.setItem('cart', JSON.stringify(cartItems.value)); // Update cart
    console.log('LocalStorage updated:', localStorage.getItem('cart'));

};


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
                <Link :href="route('shop')"
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
                                {{ $page.props.auth.user?.name || 'User' }} <!-- Display user name or default text -->
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
                        <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                        <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                    </template>
                </Dropdown>

            </nav>
        </header>

        <!-- Main Text -->
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
    </section>

    <!-- Trending Section -->

    <section id="trending" class="trending bg-black text-white py-8 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Trending Products</h2>
        <div class="listProduct grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            <div v-for="product in paginatedProducts" :key="product.id"
                class="item bg-gray-200 p-5 rounded-xl flex flex-col justify-between shadow-lg border">

                <!-- Display product image dynamically with shadow -->
                <div class="flex-shrink-0 relative cursor-pointer" @click="openModal(product)">
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
                    <button @click="addToCart(product)"
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

    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-lg max-w-md w-full overflow-hidden shadow-xl transform transition-all">
            <div class="relative">
                <img v-if="selectedProduct.product_image" :src="`/storage/${selectedProduct.product_image}`"
                    :alt="selectedProduct.name" class="w-full h-64 object-cover">
                <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No image available</span>
                </div>
                <button @click="closeModal"
                    class="absolute top-2 right-2 bg-white rounded-full p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <h3 class="text-2xl font-bold mb-2">{{ selectedProduct?.name }}</h3>
                <p class="text-xl font-semibold mb-4">${{ selectedProduct?.price }}</p>
                <p class="text-gray-600 mb-4">{{ selectedProduct?.description }}</p>
                <button @click="addToCart(selectedProduct); closeModal()"
                class="w-[90%] object-contain transform hover:scale-110 transition-transform duration-400 ease-in-out 
                drop-shadow-[0_50px_20px_#0009] border-none" >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>

    <!-- Cart Tab -->
    <div class="fixed top-4 right-4 z-50">
        <button @click="toggleCart"
            class="relative p-2 bg-teal-500 rounded-full shadow-lg hover:bg-gray-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span v-if="cartItemsCount > 0"
                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ cartItemsCount }}
            </span>
        </button>
    </div>

    <!-- Cart Sidebar -->
    <div v-if="isCartOpen"
        class="cartTab fixed top-0 right-0 bottom-0 bg-white bg-opacity-70 backdrop-blur-md border-l border-gray-300 shadow-lg w-80 overflow-hidden transition-all">
        <header class="flex items-center justify-between px-6 py-4">
            <h1 class="text-lg font-medium">Your Cart</h1>
            <button @click="toggleCart" class="text-2xl font-bold text-red-600">&times;</button>
        </header>
        <div class="listCart overflow-y-auto px-6">
            <div v-for="item in cartItems" :key="item.id" class="item flex py-4 border-b">
                <div class="flex-shrink-0 mr-4">
                    <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name"
                        class="w-16 h-16 object-cover rounded-md">
                    <div v-else class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center">
                        <span class="text-gray-500 text-xs">No image</span>
                    </div>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h3 class="font-medium">{{ item.name }}</h3>
                        <p>${{ (item.price * item.quantity).toFixed(2) }}</p>
                    </div>
                    <div class="flex items-center mt-2">
                        <button @click="decreaseQuantity(item)"
                            class="bg-gray-200 text-gray-700 rounded-full w-6 h-6 flex items-center justify-center">
                            -
                        </button>
                        <span class="mx-2">{{ item.quantity }}</span>
                        <button @click="increaseQuantity(item)"
                            class="bg-gray-200 text-gray-700 rounded-full w-6 h-6 flex items-center justify-center">
                            +
                        </button>
                        <button @click="removeFromCart(item.id)"
                            class="remove bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center ml-auto">
                            &times;
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <footer class="px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <span class="font-medium">Total:</span>
                <span class="font-bold">${{ totalCost }}</span>
            </div>
            <button @click="checkout"
                class="w-full bg-red-600 text-white py-3 rounded-md text-lg font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
                Checkout
            </button>
        </footer>
    </div>
</template>