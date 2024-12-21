<template>

    <Head title="Show User" />

    <FrontendLayout>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-lg flex">
                <div class="flex-1 mr-8">
                    <div class="flex justify-between mb-6">
                        <h5 class="text-2xl font-semibold">Show User</h5>
                    </div>

                    <div class="mb-5">
                        <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                        <p class="text-gray-800">{{ user.name }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="role" class="block text-lg font-medium text-gray-700">Role</label>
                        <p class="text-gray-800">{{ user.role }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block text-lg font-medium text-gray-700">Address</label>
                        <p class="text-gray-800">{{ user.address }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="contactNumber" class="block text-lg font-medium text-gray-700">Contact
                            Number</label>
                        <p class="text-gray-800">{{ user.contactNumber }}</p>
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                        <p class="text-gray-800">{{ user.email }}</p>
                    </div>

                    <div class="flex justify-between gap-4">
                        <Link :href="route('user.index')"
                            class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                        Back
                        </Link>
                    </div>
                </div>

                <!-- User Avatar Field -->
                <div class="flex-shrink-0">
                    <!-- Check if the avatar is a URL (Google Avatar) -->
                    <img v-if="user.avatar && user.avatar.startsWith('http')" :src="user.avatar" alt="Google Avatar"
                        class="w-72 h-72 object-cover rounded-lg shadow-md" />

                    <!-- Check if the avatar is a local file path (Personal Avatar) -->
                    <img v-else-if="user.avatar" :src="`/storage/${user.avatar}`" alt="User Avatar"
                        class="w-72 h-72 object-cover rounded-lg shadow-md" />

                    <!-- Display fallback avatar if no avatar is available -->
                    <img v-else src="/images/default-avatar.png" alt="No Avatar"
                        class="w-72 h-72 object-cover rounded-lg shadow-md" />
                </div>

            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Define props for user data
const props = defineProps({
    errors: Object,
    user: Object, // The user object to display
});
</script>
