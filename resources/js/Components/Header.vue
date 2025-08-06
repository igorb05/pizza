<script setup>
import {computed} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import Container from '@/Containers/Container.vue';
import HeaderControls from '@/Components/HeaderControls.vue';
import HeaderSearchBar from "@/Components/HeaderSearchBar.vue";

const page = usePage();

const hiddenPages = ['/order/create', '/profile'];

const isHiddenPage = computed(() =>
    hiddenPages.some(path => page.url.startsWith(path))
);
</script>

<template>
    <header class="sticky top-0 z-10 bg-neutral-800 border-b-1 border-stone-700 sm:[position:unset]">
        <Container>
            <div class="flex justify-between items-center py-5">
                <Link href="/">
                    <div class="flex items-center gap-x-2 sm:gap-x-4">
                        <img src="/images/icons/logo.png" alt="Logo Inertia Pizza">
                        <div class="text-white text-xl font-bold leading-5 sm:text-2xl">INERTIA PIZZA <br>
                            <span class="hidden text-base text-jaffa-400 font-normal sm:block">вкусно – когда вкусно</span>
                        </div>
                    </div>
                </Link>
                <div class="w-1/3" v-if="!isHiddenPage">
                    <HeaderSearchBar/>
                </div>
                <div class="flex gap-x-2">
                    <HeaderControls/>
                </div>
            </div>
        </Container>
    </header>
</template>
