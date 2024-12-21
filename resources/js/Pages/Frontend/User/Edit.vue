<template>

    <Head title="Edit User" />
    <FrontendLayout>
        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>

        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between mb-6">
                    <h5 class="text-2xl font-semibold">Update User</h5>
                </div>

                <form @submit.prevent="updateUser">
                    <!-- User Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="form.name" autocomplete="name"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter user name" />
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>

                    <!-- User Role (Dropdown) -->
                    <div class="mb-5">
                        <label for="role" class="block text-lg font-medium text-gray-700">Role</label>
                        <select id="role" v-model="form.role"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Customer">Customer</option>
                            <option value="Admin">Admin</option>
                            <option value="Seller">Seller</option>
                        </select>
                        <div v-if="errors.role" class="text-red-500">{{ errors.role }}</div>
                    </div>

                    <!-- User Address -->
                    <div class="mb-5">
                        <label for="address" class="block text-lg font-medium text-gray-700">Address</label>
                        <input type="text" id="address" v-model="form.address" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter user address" />
                        <div v-if="errors.address" class="text-red-500">{{ errors.address }}</div>
                    </div>

                    <!-- User Contact Number -->
                    <div class="mb-5">
                        <label for="contactNumber" class="block text-lg font-medium text-gray-700">Contact
                            Number</label>
                        <input type="text" id="contactNumber" v-model="form.contactNumber" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter contact number" />
                        <div v-if="errors.contactNumber" class="text-red-500">{{ errors.contactNumber }}</div>
                    </div>

                    <!-- User Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                        <input type="email" id="email" v-model="form.email" autocomplete="off"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter email address" />
                        <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
                    </div>

                    <!-- User Avatar Upload -->
                    <div class="mb-5">
                        <label for="avatar" class="block text-lg font-medium text-gray-700">Avatar</label>

                        <!-- Display Current Avatar -->
                        <div v-if="form.avatar_url" class="mb-3">
                            <img :src="form.avatar_url" alt="Current Avatar"
                                class="w-32 h-32 object-cover rounded-md" />
                        </div>

                        <!-- File Upload -->
                        <input type="file" id="avatar" @change="handleImageUpload"
                            class="mt-1 py-2 px-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />

                        <div v-if="errors.avatar" class="text-red-500">{{ errors.avatar }}</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between gap-4">
                        <Link :href="route('user.index')"
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
    user: Object,
});

const form = useForm({
    name: props.user.name,
    role: props.user.role,
    address: props.user.address,
    contactNumber: props.user.contactNumber,
    email: props.user.email,
    avatar_url: props.user.avatar || '', // Default avatar URL
});

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.avatar = file;
    }
};

const updateUser = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('role', form.role);
    formData.append('address', form.address);
    formData.append('contactNumber', form.contactNumber);
    formData.append('email', form.email);

    if (form.avatar) {
        formData.append('avatar', form.avatar);
    }

    form.put(route('user.update', props.user.id), {
        data: formData,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>
