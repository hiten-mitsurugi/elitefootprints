<template>
    <Head title="Order List" />

    <FrontendLayout>
        <!-- Flash message -->
        <div v-if="$page.props.flash.message" class="alert p-4 mb-4 text-sm bg-green-500 text-white rounded-md shadow">
            {{ $page.props.flash.message }}
        </div>

        <!-- Checkout List Section -->
        <div class="mt-8 mx-4">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-2xl font-semibold text-gray-800">Order List</h5>
            </div>

            <!-- Order Items Table -->
            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Order Id</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Order Number</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Customer Id</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Total Amount</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Status</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Order Date</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Check if orders exist first, then iterate over orders.data -->
                    <template v-if="orders && orders.data && orders.data.length">
                        {{ console.log(orders) }}
                        <tr v-for="(item, index) in orders.data" :key="index">
                            <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.id }}</td>
                            <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.order_number }}</td>

                            <!-- Product Name -->
                            <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.user_id }}</td>

                            <!-- Product Price -->
                            <td class="py-4 px-6 border-b text-sm text-gray-700">{{ formatCurrency(item.total_amount) }}</td>

                            <!-- Product Quantity -->
                            <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.status }}</td>

                            <!-- Total Price -->
                            <td class="py-4 px-6 border-b text-sm text-gray-700">
                                {{ formatDate(item.created_at) }}
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-6 border-b text-sm">
                                <div class="flex gap-2 justify-center">
                                    <Link :href="route('orders.show', item.id)" class="text-blue-500 hover:text-blue-700 transition duration-200">
                                    <i class="fas fa-eye"></i> <!-- Eye icon -->
                                    </Link>
                                    <!-- Update Status to Shipped -->
                                    <button v-if="item.status === 'pending'" @click="updateOrderStatus(item.id)"
                                        class="text-green-500 hover:text-green-700 transition duration-200">
                                        <i class="fas fa-check"></i> <!-- Check icon -->
                                    </button>

                                    <span v-else class="text-gray-500">Shipped</span>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <!-- Show a message if no orders exist -->
                    <template v-else>
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-center text-sm text-gray-700">No orders available.</td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Pagination -->
            <div v-if="orders?.links && orders.links.length" class="float-end mt-6">
                <Pagination :links="orders.links" />
            </div>
        </div>
    </FrontendLayout>
</template>
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

const page = usePage();
console.log('User:', page.props.user);
console.log('Order Items:', page.props.orderItems);

const props = defineProps({
    orders: {
        type: Object,
        required: true
    },
    errors: Object,
    auth: Object,
    checkAuth: {
        type: Object,
        required: true
    },
});

// Define the formatDate function to format the date
const formatDate = (date) => {
    const formattedDate = new Date(date);
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    }).format(formattedDate);
};

const form = useForm({});

const updateOrderStatus = (orderId) => {
    if (confirm('Are you sure you want to update this order to shipped?')) {
        form.post(route('orders.updateStatus', { orderId: orderId }), {
            onSuccess: () => {
                // Handle success actions
            },
            onError: () => {
                // Handle error actions
            }
        });
    }
};

const deleteOrderItem = (orderItemId) => {
    if (confirm('Are you sure you want to delete this item from your order?')) {
        form.delete(route('order.item.destroy', orderItemId), {
            onSuccess: () => {
                // Handle success actions
            },
            onError: () => {
                // Handle error actions
            }
        });
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
};

// Additional debug logging
console.log('Props:', props);
console.log('Orders:', props.orders);
</script>

