<template>
    <Head title="Products" />

    <FrontendLayout>
        <!-- Flash message -->
        <div v-if="$page.props.flash.message" class="alert p-4 mb-4 text-sm bg-green-500 text-white rounded-md shadow">
            {{ $page.props.flash.message }}
        </div>

        <!-- Product List Section -->
        <div class="mt-8 mx-4">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-2xl font-semibold text-gray-800">Product List</h5>
                <Link :href="route('product.create')" class="bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-200">
                    Add Product
                </Link>
            </div>

            <!-- Product Table -->
            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Id</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Product Image</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Name</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Price</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Description</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Category</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Quantity</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in products.data" :key="index">
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.id }}</td>

                        <!-- Product Image -->
                        <td class="py-4 px-6 border-b text-center">
                            <img v-if="item.product_image" :src="`/storage/${item.product_image}`" alt="Product Image" class="w-12 h-12 object-cover rounded-full mx-auto" />
                            <img v-else src="/path/to/fallback-image.jpg" alt="No Image" class="w-12 h-12 object-cover rounded-full mx-auto" />
                        </td>

                        <!-- Product Name -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.name }}</td>

                        <!-- Product Price -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.price }}</td>

                        <!-- Product Description -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.description }}</td>
                         <!-- Product Category -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.category }}</td>
                        <!-- Product Quantity -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ item.quantity }}</td>

                        <!-- Action Buttons -->
                        <td class="py-4 px-6 border-b text-sm">
                            <div class="flex gap-2 justify-center">
                                <!-- View -->
                                <Link :href="route('product.show', item.id)" class="text-blue-500 hover:text-blue-700 transition duration-200">
                                    <i class="fas fa-eye"></i> <!-- Eye icon -->
                                </Link>

                                <!-- Edit -->
                                <Link :href="route('product.edit', item.id)" class="text-green-500 hover:text-green-700 transition duration-200">
                                    <i class="fas fa-edit"></i> <!-- Edit icon -->
                                </Link>

                                <!-- Delete -->
                                <button @click="deleteProduct(item.id)" class="text-red-500 hover:text-red-700 transition duration-200">
                                    <i class="fas fa-trash"></i> <!-- Trash icon -->
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="float-end">
                <Pagination class="mt-6" :links="products.links" />
            </div>
           
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    products: [Object, Array],
});

const form = useForm({});

const deleteProduct = (productId) => {
    if (confirm('Are you sure you want to delete this product?')) {
        form.delete(route('product.destroy', productId));
    }
};
</script>
