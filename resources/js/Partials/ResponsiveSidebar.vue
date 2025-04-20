<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="logo-header" data-background-color="dark">
        <Link :href="route('dashboard')" class="logo">
            <span class="text-dark">
                {{ $page.props.appName }}
            </span>
        </Link>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
</template>