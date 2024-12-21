<template>
      <Head title="Login" />
  <div class="flex h-screen">
    <!-- Image Section (Black background) -->
    <div class="relative flex-1 bg-black flex items-center justify-center h-full">
      <div class="absolute top-4 right-4">
        <a href="/" class="text-white text-3xl font-bold hover:text-gray-300">
          <i class="fa fa-home" aria-hidden="true"></i>
        </a>
      </div>

      <div class="absolute top-10 right-12 text-right px-8 py-10">
        <h1 class="text-white text-4xl lg:text-7xl font-bold mt-2 mb-4">
          Step Into Style, Create Your Account Now
        </h1>
        <p class="text-red-500 italic text-lg mb-6">
          Discover the Perfect Pair for Every Trend
        </p>
        <h5 class="bg-red-600 bg-opacity-70 text-white text-lg px-4 py-2 rounded-md inline-block shadow-md">
          Elite Footprints Collection
        </h5>
      </div>

      <!-- Shoes Image -->
      <img src="@/Components/Assets/nike-removebg-preview.png" alt="Shoes"
        class="absolute bottom-12 left-12 lg:bottom-4 object-contain h-1/2 transform -translate-y-1/4" />
    </div>

    <!-- Login and Sign Up Links -->
    <div class="absolute bottom-1/4 left-1/2 transform -translate-x-1/2 translate-y-1/4 flex flex-col space-y-8">
      <a href="/login"
        class="block rounded-full bg-teal-500 bg-opacity-70 px-16 py-6 text-2xl text-gray-800 font-bold hover:bg-opacity-100 text-center">
        LOGIN
      </a>
      <a href="/register"
        class="block rounded-full bg-teal-500 bg-opacity-70 px-16 py-6 text-2xl text-gray-800 font-bold hover:bg-opacity-100 text-center">
        SIGN UP
      </a>
    </div>

    <!-- Login Section (White background) -->
    <div class="flex flex-col w-full bg-white flex-1 h-full">
      <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
          <!-- Logo -->
          <div class="flex justify-center mb-6">
            <img src="@/Components/Assets/s-l1200-removebg-preview.png" alt="Logo" class="h-32" />
          </div>

          <h1 class="text-3xl font-semibold text-center text-gray-800">Sign In</h1>
          <p class="mt-2 text-center text-gray-600">Enter your email and password to access your account</p>

          <!-- Login Form -->
          <form @submit.prevent="submit">
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">
                Email*
              </label>
              <input id="email" v-model="form.email" type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="mail@example.com" required />
              <p v-if="emailError" class="mt-2 text-sm text-red-600">{{ emailError }}</p>
            </div>
            <div class="mb-4">
              <label for="password" class="block text-sm font-medium text-gray-700">
                Password*
              </label>
              <input id="password" v-model="form.password" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Enter your password" required />
              <p v-if="passwordError" class="mt-2 text-sm text-red-600">{{ passwordError }}</p>
            </div>

            <!-- Keep me logged in and Forgot Password -->
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center">
                <input id="remember" v-model="form.remember" type="checkbox"
                  class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                  Keep me logged in
                </label>
              </div>
              <a href="/forgot-password" class="text-sm text-indigo-600 hover:text-indigo-500">
                Forgot password?
              </a>
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="w-full rounded-md bg-black px-4 py-2 text-white hover:bg-gray-800 transition">
              Sign In
            </button>
          </form>

          <!-- OR Section with Border -->
          <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="bg-white px-2 text-gray-500">or</span>
            </div>
          </div>

          <!-- Sign in with Google Button -->
          <button
            class="w-full mt-6 flex items-center justify-center space-x-2 rounded-md bg-black px-4 py-2 text-white hover:bg-gray-800 transition"
            @click="signInWithGoogle" type="button">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Icon"
              class="h-5 w-5" />
            <span>Sign in with Google</span>
          </button>

          <!-- Create Account -->
          <p class="mt-6 text-center text-sm text-gray-600">
            Not registered yet?
            <a href="/register" class="text-indigo-600 hover:text-indigo-500">
              Create an Account
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { reactive, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
const form = reactive(
  useForm({
    email: '',
    password: '',
    remember: false,
  })
);

const emailError = ref('');
const passwordError = ref('');

const validateEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
};

const validatePassword = (password) => {
  const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
  return passwordRegex.test(password);
};

const submit = () => {
  emailError.value = '';
  passwordError.value = '';

  if (!validateEmail(form.email)) {
    emailError.value = 'Please enter a valid email address.';
    return;
  }

  if (!validatePassword(form.password)) {
    passwordError.value = 'Password must be at least 8 characters long and include a capital letter, a number, and a special character.';
    return;
  }

  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};

// Google Sign-In
const signInWithGoogle = () => {
  window.location.href = "/login/google"; // Trigger the Google OAuth flow
};
</script>
