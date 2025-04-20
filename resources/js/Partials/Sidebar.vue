<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isOpen = ref(false)

function toggleMenu() {
    isOpen.value = !isOpen.value
}
</script>

<template>
    <!-- @php
        $user = auth()->guard('web')->user();
        $filieres = $user->filieres()->with('site')->get();
        
        $universites = [];
        foreach ($filieres as $filiere) {
            if (!in_array($filiere->site->universite, $universites)) {
                $universites[] = $filiere->site->universite;
            }
        }

        $mesUniv = collect($universites)->sortBy('nomUniv');
    @endphp -->

    <div class="sidebar" data-background-color="white">
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
                    <li class="nav-item <?= (isset($active) && $active == 'accueil') ? 'active' : '' ?>">
                        <Link :href="route('dashboard')">
                            <i class="fas fa-home"></i>
                            <p class="text-uppercase">Accueil</p>
                        </Link>
                    </li>

                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Menu</h4>
                    </li>

                    <li class="nav-item <?= (isset($active) && $active == 'calendrier') ? 'active' : '' ?>">
                        <Link :href="route('calendrier')">
                            <i class="fas fa-calendar-alt"></i>
                            <p class="text-uppercase">Calendrier</p>
                        </Link>
                    </li>

                    <!-- @if (!isset($mesUniv) || $mesUniv->count() == 0) -->
                    
                        <li class="nav-item <?= (isset($active) && $active == 'universites') ? 'active' : '' ?>">
                            <Link :href="route('dashboard')">
                                <i class="fas fa-school"></i>
                                <p class="text-uppercase">Les universités</p>
                            </Link>
                        </li>

                    <!-- @else -->

                        <li class="nav-item <?= (isset($active) && $active == 'universites') ? 'active' : '' ?>">
                            <a href="#" @click="toggleMenu">
                                <i class="fas fa-school"></i>
                                <p class="text-uppercase mb-0">Mes universités</p>
                                <span class="ms-auto caret" :class="{ 'rotate-180': isOpen }"></span>
                            </a>

                            <transition name="collapse">
                                <div v-if="isOpen">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <Link :href="route('dashboard')">
                                                <span class="sub-item">Liste des universités</span>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link :href="route('dashboard')">
                                                <span class="sub-item">HARVARD</span>
                                            </Link>
                                        </li>
                                    </ul>
                                </div>         
                            </transition>
                        </li>

                    <!-- @endif -->

                    <li class="nav-item <?= (isset($active) && $active == 'rappels') ? 'active' : '' ?>">
                        <Link :href="route('dashboard')">
                            <i class="fas fa-envelope"></i>
                            <p class="text-uppercase">Notifications</p>
                        </Link>
                    </li>

                    <li class="nav-item <?= (isset($active) && $active == 'donnees') ? 'active' : '' ?>">
                        <Link :href="route('dashboard')">
                            <i class="fas fa-chart-bar"></i>
                            <p class="text-uppercase">Données</p>
                        </Link>
                    </li>

                    <li class="nav-item <?= (isset($active) && $active == 'profil') ? 'active' : '' ?>">
                        <Link :href="route('profile.edit')">
                            <i class="fas fa-user-gear"></i>
                            <p class="text-uppercase">Paramètres du profil</p>
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