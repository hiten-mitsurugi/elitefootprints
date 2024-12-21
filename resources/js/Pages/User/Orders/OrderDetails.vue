<template>

    <Head title="Order Details" />
    <FrontendLayout>
        <div>

            <Head title="Order Details" />
            <div class="min-h-screen bg-white text-gray-900">
                <div class="max-w-7xl mx-auto py-8 px-4">
                    <h1 class="text-3xl font-bold text-center mb-8">Order Details</h1>

                    <!-- Order Summary -->
                    <div class="bg-gray-800 text-white border-b shadow-md rounded-lg p-6 mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>
                        <p><strong>Order ID:</strong> {{ order.id }}</p>
                        <p><strong>Order Date:</strong> {{ formatDate(order.created_at) }}</p>
                        <p><strong>Total Amount:</strong> ₱{{ Number(order.total_amount).toFixed(2) }}</p>
                        <p><strong>Status:</strong> {{ order.status }}</p>
                    </div>

                    <!-- Order Items Table -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <!-- Table Header -->
                            <thead class=" bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold border-b border-gray-300">Product Image
                                    </th>
                                    <th class="px-4 py-2 text-left font-semibold border-b border-gray-300">Name</th>
                                    <th class="px-4 py-2 text-left font-semibold border-b border-gray-300">Price</th>
                                    <th class="px-4 py-2 text-left font-semibold border-b border-gray-300">Quantity</th>
                                    <th class="px-4 py-2 text-left font-semibold border-b border-gray-300">Total</th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody>
                                <tr v-for="item in orderItems" :key="item.id"
                                    class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 border-b text-center">
                                        <img v-if="item.product.product_image"
                                            :src="`/storage/${item.product.product_image}`" alt="Product Image"
                                            class="w-12 h-12 object-cover rounded-full mx-auto" />
                                        <img v-else src="/path/to/fallback-image.jpg" alt="No Image"
                                            class="w-12 h-12 object-cover rounded-full mx-auto" />
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-300">{{ item.product.name }}</td>
                                    <td class="px-4 py-2 border-b border-gray-300">₱{{ Number(item.price).toFixed(2) }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-300">{{ item.quantity }}</td>
                                    <td class="px-4 py-2 border-b border-gray-300">
                                        ₱{{ (Number(item.price) * item.quantity).toFixed(2) }}
                                    </td>
                                </tr>
                            </tbody>
                            <!-- Table Footer -->
                            <tfoot class=" bg-gray-800 text-white">
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-right font-semibold">Total:</td>
                                    <td class="px-4 py-2 font-semibold">
                                        ₱{{ Number(order.total_amount).toFixed(2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    orderItems: {
        type: Array,
        required: true
    }
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>