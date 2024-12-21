// resources/js/Components/VideoBackground.vue

<template>
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover">
            <source src="@/Assets/bg.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
    </div>
</template>
