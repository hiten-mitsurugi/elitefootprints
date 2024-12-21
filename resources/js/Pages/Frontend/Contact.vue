<template>

    <Head title="Contact Us" />


    <section class="main-home relative w-full h-screen overflow-hidden">
        <!-- Video Background -->
        <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover -z-10">
            <source src="@/Components/Assets/bg.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <!-- Header -->
        <header class="flex items-center justify-between p-5">
            <!-- Brand Name -->
            <h1 class="text-white text-xl font-light pl-8">Elite Foorprints</h1>
            <nav class="flex space-x-6">
                <Link :href="route('myHome')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                Home
                </Link>
                <Link :href="route('aboutUs')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                About
                </Link>
                <Link :href="route('contactUS')"
                    class="text-white text-lg font-medium transition hover:text-teal-400 hover:underline">
                Contact Us
                </Link>
            </nav>


            <!-- Navigation -->
            <nav class="flex space-x-6 pr-8">
                <Link :href="route('login')"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Login
                </Link>
                <Link :href="route('register')"
                    class="text-white text-lg font-medium transition hover:bg-teal-400 hover:text-white hover:underline px-4 py-2 border border-white rounded">
                Register
                </Link>
            </nav>
        </header>

        <!-- Main Text -->
        <div class="main-text text-center px-10 py-36">
            <h5 class="bg-teal-500 bg-opacity-70 text-white text-lg px-4 py-2 rounded-md inline-block shadow-md">
                Elite Foorprints Shoe Collection
            </h5>
            <h1 class="text-white text-4xl lg:text-7xl font-bold mt-2 mb-4">
                Elevate Your Style with Our Exquisite Collection
            </h1>
            <p class="text-teal-400 italic text-lg mb-6">
                Discover the Perfect Pair for Every Trend
            </p>
            <a href="#trending"
                class="main-btn inline-block bg-red-600 text-white text-base font-medium px-6 py-3 rounded-md shadow-md hover:bg-teal-500 hover:text-black transition-all">
                Shop now <i class="bx bx-shopping-bag"></i>
            </a>
        </div>
    </section>
    <section class="py-32 px-8 bg-black text-black mb-0">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl  text-white font-bold mb-12 opacity-90 inline-block border-b-2 border-black pb-2">Contact Us</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="p-6 rounded-lg shadow-2xl bg-gray-200">
                    <h3 class="text-2xl text-black font-semibold mb-4 opacity-80">Get In Touch</h3>
                    <form @submit.prevent="handleSubmit">
                        <div class="mb-4">
                            <label for="name" class="block text-black text-left font-medium opacity-70">Name</label>
                            <input type="text" id="name" v-model="name" placeholder="Enter your name"
                                class="w-full p-3 border border-gray-300 rounded-lg mt-2" required
                                pattern="^[a-zA-Z ]{2,50}$"
                                title="Name should be 2-50 characters long and contain only letters and spaces" />
                        </div>
                        <div class="mb-4">
                            <label for="email" class="text-black block text-left font-medium opacity-70">Email</label>
                            <input type="email" id="email" v-model="email" placeholder="Enter your email"
                                class="w-full p-3 border border-gray-300 rounded-lg mt-2" required
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                title="Please enter a valid email address" />
                        </div>
                        <div class="mb-4">
                            <label for="message"
                                class="text-black block text-left font-medium opacity-70">Message</label>
                            <textarea id="message" placeholder="Write your message" v-model="message"
                                class="w-full p-3 border border-gray-300 rounded-lg mt-2" required minlength="10"
                                maxlength="500"
                                title="Message should be between 10 and 500 characters and contain only alphanumeric characters, common punctuation, and line breaks"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-900">Send
                            Message</button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="p-6 rounded-lg shadow-2xl bg-gray-200 flex flex-col">
                    <h3 class="text-2xl font-semibold mb-4 opacity-80">Find Us</h3>

                    <iframe class="w-full h-full rounded-lg border border-gray-300"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6353923.972621374!2d121.15741893535583!3d7.831231121073893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f552fc1d482cdd%3A0x14c5088d630e63f7!2sMindanao%2C%20Philippines!5e0!3m2!1sen!2sus!4v1631234567890!5m2!1sen!2sus"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!--Footer-->
    <footer class="bg-white text-black py-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 opacity-80 text-sm">
                <!-- ABOUT ELITE FOOTPRINTS -->
                <div>
                    <h3 class="font-semibold mb-3">ABOUT ELITE FOOTPRINTS</h3>
                    <p>
                        At Elite Footprints, we take pride in crafting exceptional footwear that blends style, comfort,
                        and durability. Our mission is to provide you with shoes that leave an unforgettable mark on the
                        world.
                    </p>
                </div>

                <!-- CUSTOMER CARE -->
                <div>
                    <h3 class="font-semibold mb-3">CUSTOMER CARE</h3>
                    <ul class="space-y-2">
                        <li>Contact</li>
                        <li>Returns/Exchange</li>
                        <li>Gift Voucher</li>
                        <li>Wishlist</li>
                        <li>Special</li>
                        <li>Customer Services</li>
                        <li>Site Maps</li>
                    </ul>
                </div>

                <!-- INFORMATION -->
                <div>
                    <h3 class="font-semibold mb-3">INFORMATION</h3>
                    <ul class="space-y-2">
                        <li>About Us</li>
                        <li>Delivery Information</li>
                        <li>Privacy Policy</li>
                        <li>Support</li>
                        <li>Order Tracking</li>
                    </ul>
                </div>

                <!-- CONTACT INFORMATION -->
                <div>
                    <h3 class="font-semibold mb-3">CONTACT INFORMATION</h3>
                    <p>123 Street, Butuan City, Philippines</p>
                    <p class="mt-2">+1235 2355 98</p>
                    <p class="mt-2">cats@elitefootprints.com</p>
                    <p class="mt-2">elitefootprints.com</p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';

// Define props
defineProps({
    products: {
        type: Array,
        required: true,
    },
    userId: {
        type: Number,
        required: false,
    },
    canLogin: Boolean,
    canRegister: Boolean,
});

// Form state
const name = ref('');
const email = ref('');
const message = ref('');

const handleSubmit = () => {
  if (validateForm()) {
    // Handle form submission logic
    alert(`Message sent by ${name.value}`);
    
    // Refresh the page after a short delay
    setTimeout(() => {
      window.location.reload();
    }, 1000); // 1 second delay
  }
};

const validateForm = () => {
  const nameRegex = /^[a-zA-Z ]{2,50}$/;
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  const messageRegex = /^[a-zA-Z0-9\s.,!?'"()-]{10,500}$/;

  if (!nameRegex.test(name.value)) {
    alert('Please enter a valid name (2-50 characters, letters and spaces only)');
    return false;
  }

  if (!emailRegex.test(email.value)) {
    alert('Please enter a valid email address');
    return false;
  }

  if (!messageRegex.test(message.value)) {
    alert('Message should be between 10 and 500 characters and contain only alphanumeric characters, common punctuation, and line breaks');
    return false;
  }

  return true;
};

// Redirect to login
const redirectToLogin = () => {
    Inertia.visit('/login'); // Replace with the correct URL to your login page
};
</script>

<style scoped>
/* Optional: Customize the styles for ContactUs.vue here if needed */
</style>