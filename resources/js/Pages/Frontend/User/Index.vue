<template>

    <Head title="Users" />

    <FrontendLayout>
        <!-- Flash message -->
        <div v-if="$page.props.flash.message" class="alert p-4 mb-4 text-sm bg-green-500 text-white rounded-md shadow">
            {{ $page.props.flash.message }}
        </div>

        <!-- User List Section -->
        <div class="mt-8 mx-4">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-2xl font-semibold text-gray-800">User List</h5>
                <Link :href="route('user.create')"
                    class="bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-200">
                Add User
                </Link>
            </div>

            <!-- User Table -->
            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Id</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Avatar</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Name</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Email</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Role</th>
                        <th class="py-3 px-6 text-left text-sm font-medium bg-gray-800 text-white border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.data" :key="index">
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ user.id }}</td>

                        <!-- User Avatar -->
                        <td class="py-4 px-6 border-b text-center">
                            <!-- Check if the avatar is a URL (Google Avatar) -->
                            <img v-if="user.avatar && user.avatar.startsWith('http')" :src="user.avatar"
                                alt="Google Avatar" class="w-12 h-12 object-cover rounded-full mx-auto" />

                            <!-- Check if the avatar is a local file path (Personal Avatar) -->
                            <img v-else-if="user.avatar" :src="`/storage/${user.avatar}`" alt="User Avatar"
                                class="w-12 h-12 object-cover rounded-full mx-auto" />

                            <!-- Display fallback avatar if no avatar is available -->
                            <img v-else src="/path/to/fallback-avatar.jpg" alt="No Avatar"
                                class="w-12 h-12 object-cover rounded-full mx-auto" />
                        </td>


                        <!-- User Name -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ user.name }}</td>

                        <!-- User Email -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ user.email }}</td>

                        <!-- User Role -->
                        <td class="py-4 px-6 border-b text-sm text-gray-700">{{ user.role }}</td>

                        <!-- Action Buttons -->
                        <td class="py-4 px-6 border-b text-sm">
                            <div class="flex gap-2 justify-center">
                                <!-- View -->
                                <Link :href="route('user.show', user.id)"
                                    class="text-blue-500 hover:text-blue-700 transition duration-200">
                                <i class="fas fa-eye"></i> <!-- Eye icon -->
                                </Link>

                                <!-- Edit -->
                                <Link :href="route('user.edit', user.id)"
                                    class="text-green-500 hover:text-green-700 transition duration-200">
                                <i class="fas fa-edit"></i> <!-- Edit icon -->
                                </Link>

                                <!-- Delete -->
                                <button @click="deleteUser(user.id)"
                                    class="text-red-500 hover:text-red-700 transition duration-200">
                                    <i class="fas fa-trash"></i> <!-- Trash icon -->
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="float-end">
                <Pagination class="mt-6" :links="users.links" />
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    users: [Object, Array],
});

const form = useForm({});

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        form.delete(route('user.destroy', userId));
    }
};
</script>
