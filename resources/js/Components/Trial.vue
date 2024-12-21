<template>
  <div class="flex">
    <!-- Sidebar -->
    <aside class="flex flex-col w-64 bg-gray-700 text-white h-screen">
      <!-- Logo Section -->
      <div class="px-8 py-6">
        <a href="https://www.loopple.com">
          <img
            src="https://raw.githubusercontent.com/Loopple/loopple-public-assets/main/riva-dashboard-tailwind/img/logos/loopple.svg"
            alt="Logo" />
        </a>
      </div>

      <!-- User Info Section -->
      <div class="flex items-center gap-x-4 px-8 py-4">
        <img v-if="$page.props.auth.user?.avatar" :src="`/storage/${$page.props.auth.user.avatar}`" alt="User Avatar"
          class="w-12 h-12 object-cover rounded-full" />
        <img v-else src="/images/fallback-avatar.jpg" alt="Fallback Avatar"
          class="w-12 h-12 object-cover rounded-full" />
        <div>
          <p class="text-lg font-medium">{{ $page.props.auth.user.name || 'Guest' }}</p>
          <span class="text-sm text-gray-400">{{ $page.props.auth.user.role || 'No Role' }}</span>
        </div>
      </div>

      <!-- Navigation Section -->
      <div class="mt-4">
        <nav class="space-y-4">
          <Link href="/user" class="block px-4 py-2 text-lg hover:text-gray-300">
          Users
          </Link>
          <Link href="/product" class="block px-4 py-2 text-lg hover:text-gray-300">
          Product
          </Link>
          <Link href="/orders" class="block px-4 py-2 text-lg hover:text-gray-300">
          Orders
          </Link>
          <!-- Logout link using Inertia method POST -->
          <Link :href="route('logout')" method="post" class="block px-4 py-2 text-lg hover:text-gray-300">
          Log Out
          </Link>
        </nav>

      </div>
    </aside>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
