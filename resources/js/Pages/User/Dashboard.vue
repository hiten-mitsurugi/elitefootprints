<script setup>
import { defineProps, ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    user: Object,
    orderItems: {
        type: Object,
        default: () => ({ data: [], links: [] })
    },
});

const formatPrice = (price) => {
    if (typeof price === 'number') {
        return price.toFixed(2);
    } else if (typeof price === 'string') {
        return parseFloat(price).toFixed(2);
    }
    return '0.00';   
}

const currentPage = ref(1);
const itemsPerPage = 7;

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.orderItems.data.slice(start, end);
});

const totalPages = computed(() => Math.ceil(props.orderItems.data.length / itemsPerPage));

const pageNumbers = computed(() => {
    return Array.from({ length: totalPages.value }, (_, i) => i + 1);
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="py-12 bg-gray-100 text-black">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Profile Section -->
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 flex items-center space-x-6">
                        <!-- Profile Image -->
                        <div class="flex-shrink-0">
                            <img v-if="props.user.avatar && props.user.avatar.startsWith('http')"
                                :src="props.user.avatar" alt="Google Avatar"
                                class="h-16 w-16 rounded-full object-cover" />
                            <img v-else-if="props.user.avatar" :src="`/storage/${props.user.avatar}`" alt="User Avatar"
                                class="h-16 w-16 rounded-full object-cover" />
                            <img v-else src="/path/to/fallback-avatar.jpg" alt="No Avatar"
                                class="h-16 w-16 rounded-full object-cover" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ props.user.name }}</h3>
                            <p class="text-sm text-gray-500">{{ props.user.email }}</p>
                            <p class="text-sm text-gray-500">{{ props.user.contactNumber || 'No contact number' }}</p>
                            <p class="text-sm text-gray-500">{{ props.user.address || 'No address available' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table Section -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Your Order Items</h3>
                        <table v-if="paginatedItems.length > 0" class="min-w-full table-auto">
                            <thead>
                                <tr class="border-b text-left">
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Order #</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Product Image</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Product</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Quantity</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Price</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-500">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in paginatedItems" :key="item.id" class="border-b">
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ item.order_id }}</td>
                                    <td class="py-4 px-6 border-b text-center">
                                        <img v-if="item.product_image" :src="`/storage/${item.product_image}`"
                                            alt="Product Image" class="w-12 h-12 object-cover rounded-full mx-auto" />
                                        <img v-else src="/path/to/fallback-image.jpg" alt="No Image"
                                            class="w-12 h-12 object-cover rounded-full mx-auto" />
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ item.product ? item.product.name : 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ item.quantity }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">${{ formatPrice(item.price) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">${{ formatPrice(item.quantity * item.price) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p v-else class="text-gray-500">No order items found.</p>

                        <!-- Manual Pagination -->
                        <div v-if="totalPages > 1" class="mt-4 flex justify-center space-x-2">
                            <button 
                                v-for="page in pageNumbers" 
                                :key="page"
                                @click="currentPage = page"
                                class="px-4 py-2 border rounded"
                                :class="{ 'bg-blue-500 text-white': currentPage === page }"
                            >
                                {{ page }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Optional: Additional customization for the dashboard */
</style>
