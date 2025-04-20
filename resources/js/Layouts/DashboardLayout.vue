<script setup>
import Footer from '@/Partials/Footer.vue';
import Navbar from '@/Partials/Navbar.vue';
import ResponsiveSidebar from '@/Partials/ResponsiveSidebar.vue';
import Sidebar from '@/Partials/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head>
        <link rel="icon" href="/images/logo.png" type="image/x-icon">

        <!-- CSS Files -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/assets/css/plugins.min.css" />
        <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
    </Head>

    <div class="wrapper">

        <!-- Sidebar -->
        <Sidebar />

        <div class="main-panel">

            <div class="main-header">

                <div class="main-header-logo">

                    <!-- Logo Header (En responsive -- je pense ! --) -->
                    <ResponsiveSidebar />
                </div>

                <!-- Navbar Header -->
                <Navbar />
            </div>

            <div class="container">

                <div class="page-inner">
                    <slot />
                </div>

            </div>

            <Footer />
        </div>

    </div>

</template>