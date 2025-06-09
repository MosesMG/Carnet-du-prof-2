<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';

const today = new Date();
const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
};
const laDate = today.toLocaleDateString('fr-FR', options);

const form = useForm({});
const submit = () => {
    localStorage.clear();
    form.post(route('logout'));
}

const rappels = usePage().props.rappels;
</script>

<template>
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">

            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <h5 class="mb-0 capitalize">
                    {{ laDate }}
                </h5>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <Link class="nav-link" :href="route('les.rappels')" title="Notifications">
                        <i class="fa fa-bell"></i>
                        <span v-if="rappels.length > 0"
                            class="notification bg-warning-gradient fw-bolder">
                            {{ rappels.length }}
                        </span>
                    </Link>
                </li>

                <li class="nav-item topbar-icon dropdown hidden-caret ms-2">
                    <Link class="nav-link" :href="route('calendrier')" title="Calendrier">
                        <i class="fas fa-calendar-alt"></i>
                    </Link>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                        class="dropdown-toggle profile-pic"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="/images/user-icon.jpg" alt="" class="avatar-img rounded-circle">
                        </div>
                        <span class="profile-username">
                            <span class="op-8 fw-bold">{{ $page.props.auth.user.name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box align-items-center">
                                    <div class="avatar-lg me-1">
                                        <img src="/images/user-icon.jpg" alt="image_profile" class="avatar-img rounded-4">
                                    </div>
                                    <div class="u-text px-0">
                                        <h4>{{ $page.props.auth.user.name }}</h4>
                                        <p class="text-muted">{{ $page.props.auth.user.email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <Link class="dropdown-item" :href="route('dashboard')">
                                    <i class="fas fa-home me-2"></i>
                                    Accueil
                                </Link>

                                <div class="dropdown-divider"></div>
                                <Link class="dropdown-item" :href="route('profile.edit')">
                                    <i class="fas fa-user-gear me-2"></i>
                                    Paramètres du profil
                                </Link>

                                <div class="dropdown-divider"></div>
                                <div class="dropdown-item">
                                    <form @submit.prevent="submit"> 
                                        <button type="submit" class="btn btn-danger w-100 text-uppercase">
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
