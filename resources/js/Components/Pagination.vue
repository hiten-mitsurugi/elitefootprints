<template>
    <div v-if="links.length > 0" class="space-y-4">
        <div class="flex flex-wrap -mb-1 space-x-3">
            <template v-for="(link, linkIndex) in links" :key="linkIndex">
                <!-- Case where the URL is null -->
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 py-2 px-4 text-sm leading-5 text-gray-500 border border-gray-300 rounded-lg shadow-sm"
                    v-html="link.label"
                ></div>

                <!-- Case where the URL is provided -->
                <Link
                    v-else
                    class="mr-1 mb-1 py-2 px-4 text-sm leading-5 text-gray-700 border border-gray-300 rounded-lg hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 inline-block transition-all duration-200 ease-in-out"
                    :class="{'bg-indigo-700 text-white': link.active}"
                    :href="link.url"
                >
                    <span v-html="link.label"></span>
                </Link>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array
});
</script>
