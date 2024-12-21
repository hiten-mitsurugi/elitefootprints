<template>

    <Head title="Show Product" />

    <FrontendLayout>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-lg flex">
                <div class="flex-1 mr-8"> <!-- This will take the remaining space on the left -->
                    <div class="flex justify-between mb-6">
                        <h5 class="text-2xl font-semibold">Show Product</h5>
                    </div>

                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Product Name</label>
                        <p class="text-gray-800">{{ product.name }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="price" class="block text-lg font-medium text-gray-700">Product Price</label>
                        <p class="text-gray-800">{{ product.price }}</p> <!-- Assuming a custom currency filter -->
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-lg font-medium text-gray-700">Product
                            Description</label>
                        <p class="text-gray-800">{{ product.description }}</p>
                    </div>
                    <div class="mb-5">
                        <label for="category" class="block text-lg font-medium text-gray-700">Product
                            Category</label>
                        <p class="text-gray-800">{{ product.category }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="quantity" class="block text-lg font-medium text-gray-700">Product Quantity</label>
                        <p class="text-gray-800">{{ product.quantity }}</p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <Link :href="route('product.index')"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                        Back
                        </Link>
                    </div>

                </div>

                <!-- Product Image Field -->
                <div class="flex-shrink-0">
                    <img v-if="product.product_image" :src="`/storage/${product.product_image}`" alt="Product Image"
                        class="w-72 h-72 object-cover rounded-lg shadow-md" />
                    <span v-else class="text-gray-500">No image available</span>
                </div>
            </div>
        </div>

        <div class="flex justify-between gap-4 mt-6">
            <Link :href="route('product.index')"
                class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
            Back
            </Link>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    errors: Object,
    product: Object,
});
</script>
