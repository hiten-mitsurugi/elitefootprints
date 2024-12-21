<template>
    <Head title="Create User" />

    <FrontendLayout>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between mb-6">
                    <h5 class="text-2xl font-semibold">Create User</h5>
                </div>
                <form @submit.prevent="saveUser">
                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter user name"
                        />
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="role" class="block text-lg font-medium text-gray-700">Role</label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="Customer">Customer</option>
                            <option value="Admin">Admin</option>
                            <option value="Seller">Seller</option>
                        </select>
                        <div v-if="errors.role" class="text-red-500">{{ errors.role }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block text-lg font-medium text-gray-700">Address</label>
                        <input
                            type="text"
                            id="address"
                            v-model="form.address"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter address"
                        />
                        <div v-if="errors.address" class="text-red-500">{{ errors.address }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="contactNumber" class="block text-lg font-medium text-gray-700">Contact Number</label>
                        <input
                            type="text"
                            id="contactNumber"
                            v-model="form.contactNumber"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter contact number"
                        />
                        <div v-if="errors.contactNumber" class="text-red-500">{{ errors.contactNumber }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            id="email"
                            v-model="form.email"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter email"
                        />
                        <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                        <input
                            type="password"
                            id="password"
                            v-model="form.password"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter password"
                        />
                        <div v-if="errors.password" class="text-red-500">{{ errors.password }}</div>
                    </div>

                    <div class="mb-5">
                        <label for="avatar" class="block text-lg font-medium text-gray-700">Avatar</label>
                        <input
                            type="file"
                            id="avatar"
                            @change="handleFileChange"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        <div v-if="errors.avatar" class="text-red-500">{{ errors.avatar }}</div>
                    </div>

                    <div class="flex justify-between gap-4">
                        <Link
                            :href="route('user.index')"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300"
                        >
                            Back
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Save</span>
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
    errors: Object,
});

const form = useForm({
    name: '',
    role: '',
    address: '',
    contactNumber: '',
    email: '',
    password: '',
    avatar: null, // Start with null to store file
});

const handleFileChange = (event) => {
    const file = event.target.files[0]; // Get the first file selected
    form.avatar = file; // Assign it to form data
};

const saveUser = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('role', form.role);
    formData.append('address', form.address);
    formData.append('contactNumber', form.contactNumber);
    formData.append('email', form.email);
    formData.append('password', form.password);

    if (form.avatar) {
        formData.append('avatar', form.avatar); // Add the file to FormData
    }

    form.post(route('user.store'), {
        data: formData, // Send FormData instead of JSON
        onSuccess: () => {
            form.reset(); // Reset form after successful submission
        },
    });
};
</script>
