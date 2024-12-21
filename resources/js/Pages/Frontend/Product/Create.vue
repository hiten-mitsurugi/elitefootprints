<template>

    <Head title="Create Products" />

    <FrontendLayout>

        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between mb-6">
                    <h5 class="text-2xl font-semibold">Create Product</h5>
                </div>
                <form @submit.prevent="saveProduct">
                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Product Name</label>
                        <input type="text" id="name" v-model="form.name"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product name" />
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="price" class="block text-lg font-medium text-gray-700">Product Price</label>
                        <input type="number" id="price" v-model="form.price"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product price" />
                        <div v-if="errors.price" class="text-red-500">{{ errors.price }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-lg font-medium text-gray-700">Product
                            Description</label>
                        <input type="text" id="description" v-model="form.description"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product description" />
                        <div v-if="errors.description" class="text-red-500">{{ errors.description }}</div>
                    </div>
                    <div class="mb-5">
                        <label for="category" class="block text-lg font-medium text-gray-700">Category</label>
                        <select
                            id="category"
                            v-model="form.category"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="Open For Bid">Open For Bid</option>
                            <option value="Fix Price">Fix Price</option>
                        </select>
                        <div v-if="errors.category" class="text-red-500">{{ errors.category }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="quantity" class="block text-lg font-medium text-gray-700">Product Quantity</label>
                        <input type="number" id="quantity" v-model="form.quantity"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product quantity" />
                        <div v-if="errors.quantity" class="text-red-500">{{ errors.quantity }}</div>
                    </div>

                    <!-- Product Image Field -->
                    <div class="mb-5">
                        <label for="picture" class="block text-lg font-medium text-gray-700">Product Picture</label>
                        <input type="file" id="picture" @change="handleFileChange"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <div v-if="errors.picture" class="text-red-500">{{ errors.picture }}</div>
                    </div>

                    <div class="flex justify-between gap-4">
                        <Link :href="route('product.index')"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                        Back
                        </Link>

                        <button type="submit" :disabled="form.processing"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            <span v-if="form.processing"> Saving...</span>
                            <span v-else> Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/inertia-vue3';

defineProps({
    errors: Object
});

const form = useForm({
    name: '',
    price: '',
    description: '',
    quantity: '',
    category: '',
    product_image: null,  // Start with null to store file
});

const handleFileChange = (event) => {
    const file = event.target.files[0];  // Get the first file selected
    form.product_image = file;  // Assign it to form data
};

// Function to handle form submission
const saveProduct = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('price', form.price);
    formData.append('description', form.description);
    formData.append('quantity', form.quantity);
    formData.append('category', form.category);

    if (form.product_image) {
        formData.append('product_image', form.product_image);  // Add the file to FormData
    }

    form.post(route('product.store'), {
        data: formData,  // Send FormData instead of JSON
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
