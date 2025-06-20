<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between text-xs">
            <nav class="pull-left">
                <Link :href="route('dashboard')" class="nav-link">
                    {{ $page.props.appName }}
                </Link>
            </nav>
            <div class="copyright">
                &copy; 2025, par
                <a href="mailto:moiseguenolekossou@gmail.com">KOSSOU Moïse-Guénolé</a>
            </div>
            <div>
                Distribué par
                <a target="_blank" href="https://newbrainfactory.com/">New Brain Factory</a>.
            </div>
        </div>
    </footer>
</template>
