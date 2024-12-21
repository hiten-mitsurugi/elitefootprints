<template>
  <div class="flex h-screen">
    <Head title="Register" />
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
          Join the Elite Footprints Community
        </p>
        <h5 class="bg-red-600 bg-opacity-70 text-white text-lg px-4 py-2 rounded-md inline-block shadow-md">
          Exclusive Membership Awaits
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

    <!-- Sign Up Section (White background) -->
    <div class="flex flex-col w-full bg-white flex-1 h-full">
      <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-4">
          <!-- Logo -->
          <div class="flex justify-center mb-6">
            <img src="@/Components/Assets/s-l1200-removebg-preview.png" alt="Logo" class="h-32" />
          </div>

          <h1 class="text-3xl font-semibold text-center text-gray-800">Sign Up</h1>
          <p class="text-center text-gray-600">Enter your details to create an account</p>

          <!-- Registration Form -->
          <form @submit.prevent="submit" class="mt-4">
            <!-- Name -->
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Name*</label>
              <input id="name" v-model="form.name" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Enter your name" required @input="validateName" />
              <p v-if="errors.name" class="mt-2 text-sm text-red-600">{{ errors.name }}</p>
            </div>

            <!-- Email -->
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
              <input id="email" v-model="form.email" type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="mail@example.com" required @input="validateEmail" />
              <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email }}</p>
            </div>

            <!-- Password -->
            <div class="mb-4">
              <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
              <input id="password" v-model="form.password" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Enter your password" required @input="validatePassword" />
              <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password }}</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                Password*</label>
              <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Confirm your password" required @input="validatePasswordConfirmation" />
              <p v-if="errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ errors.password_confirmation
                }}</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full rounded-md bg-black px-4 py-2 text-white hover:bg-gray-800 transition"
              :disabled="!isFormValid">
              Sign Up
            </button>
          </form>

          <!-- Login Link -->
          <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="/login" class="text-indigo-600 hover:text-indigo-500">Login</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const errors = reactive({});

const nameRegex = /^[a-zA-Z\s]{2,30}$/;
const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

const validateName = () => {
  if (!nameRegex.test(form.name)) {
    errors.name = 'Name must be 2-30 characters long and contain only letters and spaces';
  } else {
    delete errors.name;
  }
};

const validateEmail = () => {
  if (!emailRegex.test(form.email)) {
    errors.email = 'Please enter a valid email address';
  } else {
    delete errors.email;
  }
};

const validatePassword = () => {
  if (!passwordRegex.test(form.password)) {
    errors.password = 'Password must be at least 8 characters long, include an uppercase letter, a number, and a special character';
  } else {
    delete errors.password;
  }
};

const validatePasswordConfirmation = () => {
  if (form.password !== form.password_confirmation) {
    errors.password_confirmation = 'Passwords do not match';
  } else {
    delete errors.password_confirmation;
  }
};

const isFormValid = computed(() => {
  return form.name && form.email && form.password && form.password_confirmation &&
    Object.keys(errors).length === 0;
});

const submit = () => {
  validateName();
  validateEmail();
  validatePassword();
  validatePasswordConfirmation();

  if (isFormValid.value) {
    form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
      onError: (errors) => {
        for (const [key, value] of Object.entries(errors)) {
          form.setError(key, value);
        }
      },
    });
  }
};
</script>

<style scoped>
/* Add any additional custom styles if needed */
</style>
