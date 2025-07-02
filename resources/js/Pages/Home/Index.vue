<script setup>
import {ref} from 'vue';
import {Head} from '@inertiajs/vue3';
import {useCartStore} from '@/Stores/cart.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Containers/Container.vue';
import ProductCard from '@/Components/ProductCard.vue';
import ProductCardList from '@/Components/ProductCardList.vue';
import ProductPriceSort from '@/Components/ProductPriceSort.vue';
import ProductFilterPanel from '@/Components/ProductFilterPanel.vue';

const cartStore = useCartStore();

const pizzasLoaded = ref([]);
const pizzasSortBy = ref('default');

const handlePizzasLoaded = (pizzas) => {
    pizzasLoaded.value = pizzas;
};

const handleAddToCart = (item) => {
    cartStore.addToCart(item)
};
</script>

<template>
    <Head>
        <title>Inertia Pizza – вью, как вкусно! :)</title>
    </Head>
    <AppLayout>
        <Container>
            <ProductPriceSort
                v-model:sort-by="pizzasSortBy"
            />
        </Container>
        <Container>
            <div class="flex gap-[60px] my-10">
                <div class="flex flex-col min-w-3xs">
                    <ProductFilterPanel
                        @pizzas-loaded="handlePizzasLoaded"
                        :sort-by="pizzasSortBy"
                    />
                </div>
                <ProductCardList>
                    <ProductCard
                        v-for="pizza in pizzasLoaded"
                        :key="pizza.id"
                        :pizza-id="pizza.id"
                        :name="pizza.name"
                        :description="pizza.description"
                        :image="pizza.image"
                        :price="pizza.price"
                        :config="pizza.config"
                        @add-to-cart="handleAddToCart"
                    />
                </ProductCardList>
            </div>
        </Container>
    </AppLayout>
</template>


