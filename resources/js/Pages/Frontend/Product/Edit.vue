<template>
    <Head title="Edit Products" />
    <FrontendLayout>
        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>

        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between mb-6">
                    <h5 class="text-2xl font-semibold">Update Product</h5>
                </div>

                <form @submit.prevent="updateProduct">
                    <!-- Product Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Product Name</label>
                        <input type="text" id="name" v-model="form.name" autocomplete="name"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product name" />
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>

                    <!-- Product Price -->
                    <div class="mb-5">
                        <label for="price" class="block text-lg font-medium text-gray-700">Product Price</label>
                        <input type="number" id="price" v-model="form.price" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product price" />
                        <div v-if="errors.price" class="text-red-500">{{ errors.price }}</div>
                    </div>

                    <!-- Product Description -->
                    <div class="mb-5">
                        <label for="description" class="block text-lg font-medium text-gray-700">Product Description</label>
                        <input type="text" id="description" v-model="form.description" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product description" />
                        <div v-if="errors.description" class="text-red-500">{{ errors.description }}</div>
                    </div>
                    <div class="mb-5">
                        <label for="category" class="block text-lg font-medium text-gray-700">Product Category</label>
                        <select
                            id="role"
                            v-model="form.category"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="Open For Bid">Open For Bid</option>
                            <option value="Fix Price">Fix Price</option>
                        </select>
                        <div v-if="errors.category" class="text-red-500">{{ errors.category }}</div>
                    </div>
                    <!-- Product Quantity -->
                    <div class="mb-5">
                        <label for="quantity" class="block text-lg font-medium text-gray-700">Product Quantity</label>
                        <input type="number" id="quantity" v-model="form.quantity" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product quantity" />
                        <div v-if="errors.quantity" class="text-red-500">{{ errors.quantity }}</div>
                    </div>

                    <!-- Product Image Upload (with default value if no new image) -->
                    <div class="mb-5">
                        <label for="picture" class="block text-lg font-medium text-gray-700">Product Picture</label>

                        <!-- Default Image URL Display -->
                        <div v-if="form.product_image_url" class="mb-3">
                            <img :src="form.product_image_url" alt="Current Product Image" class="w-32 h-32 object-cover" />
                        </div>

                        <!-- File Upload -->
                        <input type="file" id="picture" @change="handleImageUpload" class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />

                        <div v-if="errors.product_image" class="text-red-500">{{ errors.product_image }}</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between gap-4">
                        <Link :href="route('product.index')"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            Back
                        </Link>
                        <button type="submit" :disabled="form.processing"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            <span v-if="form.processing">Updating...</span>
                            <span v-else>Update</span>
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

const props = defineProps({
    errors: Object,
    product: Object,
});

// Initialize the form with the current product data
const form = useForm({
    name: props.product.name,
    price: props.product.price,
    description: props.product.description,
    category: props.product.category,
    quantity: props.product.quantity,
    product_image_url: props.product.product_image_url || '', // Default image URL from DB
});

// Function to handle image upload (replace the URL with the new image)
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Store the file itself in the form data, not the URL
        form.product_image = file;
    }
};

// Update the form submission to include the image file
// Update product method (form submission)
const updateProduct = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('price', form.price);
    formData.append('description', form.description);
    formData.append('category', form.category);
    formData.append('quantity', form.quantity);

    // Only append the image if it's been updated
    if (form.product_image) {
        formData.append('product_image', form.product_image);  // Ensure this contains the image file
    }

    // Send the FormData object with the actual file
    form.put(route('product.update', props.product.id), {
        data: formData,  // Send as form data
        onSuccess: () => {
            form.reset(); // Reset the form after successful submission
        },
        onError: (errors) => {
            console.error(errors); // Log errors for debugging
        },
    });
};

</script>
