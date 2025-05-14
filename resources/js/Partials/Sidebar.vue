<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const isOpen = ref(false)

function toggleMenu() {
    isOpen.value = !isOpen.value
}
const mesUniversites = usePage().props.mesUniversites;
</script>

<template>
    <div class="sidebar sidebar-style-2" data-background-color="dark">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <Link :href="route('dashboard')" class="logo">
                    <span class="text-white fs-5">
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
            <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">

                <ul class="nav nav-primary">
                    <li class="nav-item" :class="{ 'active' : $page.url === '/accueil' }">
                        <Link :href="route('dashboard')">
                            <i class="fas fa-home text-white"></i>
                            <p class="text-uppercase text-white">Accueil</p>
                        </Link>
                    </li>

                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Menu</h4>
                    </li>

                    <li class="nav-item text-white mb-3" 
                        :class="{ 'active' : $page.url === '/calendrier' }">
                        <Link :href="route('calendrier')">
                            <i class="fas fa-calendar-alt text-white"></i>
                            <p class="text-uppercase text-white">Calendrier</p>
                        </Link>
                    </li>

                    <li class="nav-item mb-3" v-if="mesUniversites.length > 0" 
                        :class="{ 'active' : $page.url.startsWith('/universite') || $page.url.startsWith('/filiere') }">
                        <a href="#" @click="toggleMenu">
                            <i class="fas fa-school text-white"></i>
                            <p class="text-uppercase text-white mb-0">Mes universités</p>
                            <span class="ms-auto caret" :class="{ 'rotate-180': isOpen }"></span>
                        </a>

                        <transition name="collapse">
                            <div v-if="isOpen">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <Link :href="route('universites')">
                                            <span class="sub-item text-white">Liste des universités</span>
                                        </Link>
                                    </li>
                                    <li v-for="univ in mesUniversites" :key="univ.id">
                                        <Link :href="route('sites.choix', univ)">
                                            <span class="sub-item text-white">{{ univ.nom }}</span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>         
                        </transition>
                    </li>

                    <li v-else class="nav-item mb-3" 
                        :class="{ 'active' : $page.url.startsWith('/universite') || $page.url.startsWith('/filiere') }">
                        <Link :href="route('universites')">
                            <i class="fas fa-school text-white"></i>
                            <p class="text-uppercase text-white">Les universités</p>
                        </Link>
                    </li>

                    <li class="nav-item mb-3" :class="{ 'active': $page.url === '/rappels' }">
                        <Link :href="route('les.rappels')">
                            <i class="fas fa-envelope text-white"></i>
                            <p class="text-uppercase text-white">Rappels</p>
                        </Link>
                    </li>

                    <li class="nav-item mb-3" :class="{ 'active' : $page.url === '/donnees' }">
                        <Link :href="route('les.donnees')">
                            <i class="fas fa-chart-bar text-white"></i>
                            <p class="text-uppercase text-white">Données</p>
                        </Link>
                    </li>

                    <li class="nav-item" :class="{ 'active' : $page.url === '/profile' }">
                        <Link :href="route('profile.edit')">
                            <i class="fas fa-user-gear text-white"></i>
                            <p class="text-uppercase text-white">Paramètres du profil</p>
                        </Link>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</template>

<style scoped>
.caret {
    transition: transform 0.3s ease;
}
.rotate-180 {
    transform: rotate(180deg);
}

.collapse-enter-active,
.collapse-leave-active {
    transition: all 0.5s ease;
}
.collapse-enter-from,
.collapse-leave-to {
    opacity: 0;
    max-height: 0;
    overflow: hidden;
}
.collapse-enter-to,
.collapse-leave-from {
    opacity: 1;
}
</style>
