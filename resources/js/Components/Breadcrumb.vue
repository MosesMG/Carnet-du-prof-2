<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true,
    }
})

</script>

<template>
    <nav aria-label="breadcrumb">
        <ol class="d-flex align-items-center gap-2 fw-medium text-black mb-3">
            <i class="fas fa-home text-sm"></i>
            <li class="d-flex align-items-center" v-for="(item, index) in items" :key="index">
                
                <span class="mx-1" v-if="index > 0">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
                
                <Link :href="item.url" v-if="item.url" class="text-dark ms-1">
                    {{ item.name }}
                </Link>
                
                <span class="text-dark ms-1" v-else>
                    {{ item.name }}
                </span>
            </li>
        </ol>
    </nav>
</template>
