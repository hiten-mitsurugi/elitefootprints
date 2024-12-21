<template>
    <AuthenticatedLayout>
    <div class="checkout-summary bg-gray-100 min-h-screen text-black">
        <div class="container mx-auto p-6 max-w-3xl">
            <h1 class="text-3xl font-bold text-black mb-6">Checkout Summary</h1>
            <div v-if="checkoutData && checkoutData.items && checkoutData.items.length > 0"
                class="bg-white rounded-lg shadow-md p-6">
                <div v-for="item in paginatedItems" :key="item.id"
                    class="mb-6 pb-6 border-b border-gray-300 last:border-b-0">
                    <div class="flex">
                        <div class="flex items-center flex-grow">
                            <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name"
                                class="w-24 h-24 object-cover rounded-md mr-4">
                            <div>
                                <h2 class="text-xl font-semibold text-black">{{ item.name }}</h2>
                                <p class="text-gray-600">Price: ${{ formatPrice(item.price) }}</p>
                                <p class="text-gray-600">Quantity: {{ item.quantity }}</p>
                                <p class="text-black font-semibold">Subtotal: ${{ formatPrice(item.subtotal) }}</p>
                            </div>
                        </div>
                        <div class="ml-4 flex-grow">
                            <h3 class="text-lg font-semibold text-black mb-2">Description:</h3>
                            <p class="text-gray-600">{{ item.description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pagination controls -->
                <div class="mt-6 flex justify-center">
                    <button @click="prevPage" :disabled="currentPage === 1"
                        class="mx-1 px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                        Previous
                    </button>
                    <span class="mx-2 py-2 text-black">Page {{ currentPage }} of {{ totalPages }}</span>
                    <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="mx-1 px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                        Next
                    </button>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-300">
                    <div class="text-2xl font-bold text-black">
                        Total Price: ${{ formatPrice(checkoutData.totalPrice) }}
                    </div>
                </div>
            </div>
            <div v-else class="bg-gray-100 rounded-lg shadow-md p-6">
                <p class="text-black">No items in checkout. Please add items to your cart.</p>
            </div>
            <div class="mt-8 flex justify-between">
                <Link :href="route('shop')"
                    class="bg-gray-200 text-black px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                Back to Shop
                </Link>
                <button @click="confirmOrder"
                    :disabled="!checkoutData || !checkoutData.items || checkoutData.items.length === 0"
                    class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 hover:scale-105 transition duration-300 disabled:cursor-not-allowed">
                    Confirm Order
                </button>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>




<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    userId: Number,
    checkoutData: {
        type: Object,
        default: () => ({ items: [], totalPrice: '0.00' })
    },
});

const currentPage = ref(1);
const itemsPerPage = 3;

const totalPages = computed(() => {
    return Math.ceil(props.checkoutData.items.length / itemsPerPage);
});

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.checkoutData.items.slice(start, end);
});

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const formatPrice = (price) => {
    return parseFloat(price).toFixed(2);
};

const confirmOrder = async () => {
    if (props.checkoutData && props.checkoutData.items && props.checkoutData.items.length > 0) {
        try {
            // Clear localStorage before sending the request
            localStorage.clear();
            console.log('All localStorage cleared.');

            // Prepare the data to send to the backend
            const payload = {
                userId: props.userId,
                cart: props.checkoutData.items.map((item) => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    price: item.price,
                })),
            };

            console.log('Sending payload:', payload);

            // Send POST request to the backend
            const response = await router.post('/purchase', payload, {
                preserveState: true,
                preserveScroll: true,
            });

            console.log('Response:', response);

            alert('Order confirmed!');
            router.visit('/dashboard'); // Redirect to dashboard after success
        } catch (error) {
            // Handle errors from the backend
            console.error('Error confirming order:', error);
            if (error.response) {
                console.error('Response data:', error.response.data);
                console.error('Response status:', error.response.status);
                console.error('Response headers:', error.response.headers);
            }
            alert('Failed to confirm the order. Please try again.');
        }
    } else {
        alert('No items to checkout.');
    }
};

console.log('Checkout Data:', props.checkoutData);
</script>
