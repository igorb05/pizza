<script setup>
import {computed, ref} from 'vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {useNotification} from '@/Composables/useNotification.js';
import {useCartStore} from '@/Stores/cart.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Containers/Container.vue';
import CommonButton from '@/Components/CommonButton.vue';
import CommonCard from '@/Components/CommonCard.vue';
import Label from '@/Components/FormLabel.vue';
import Input from '@/Components/FormInput.vue';
import Textarea from '@/Components/FormTextarea.vue';
import StatusBlock from '@/Components/StatusBlock.vue';

const props = defineProps({
    user: Object,
    errors: Object,
});

const {showNotification} = useNotification();
const cartStore = useCartStore();

const cart = computed(() => cartStore.items);

const DELIVERY_COST = 120;

const totalPrice = computed(() =>
    cart.value.reduce((sum, item) => sum + item.price * item.quantity + DELIVERY_COST, 0)
);

const increment = (index) => {
    cartStore.incrementQuantity(index)
};

const decrement = (index) => {
    cartStore.decrementQuantity(index)
};

const orderData = {
    total_price: totalPrice.value,
    items: cart.value.map(item => ({
        pizza_id: item.pizza_id,
        size: item.size,
        crust: item.crust,
        addons: item.addons,
        quantity: item.quantity,
        unit_price: item.price,
        full_price: item.price * item.quantity,
    })),
};

const form = useForm({
    first_name: props.user?.first_name ?? '',
    last_name: props.user?.last_name ?? '',
    address: props.user?.address ?? '',
    email: props.user?.email ?? '',
    phone: props.user?.phone ?? '',
    comment: '',
    ...orderData
});

const loading = ref(false);

const orderStore = () => {
    loading.value = true;

    form.post('/order/store', {
        onSuccess: () => {
            cartStore.clearCart();
        },
        onError: () => {
            showNotification('Ошибка в обработке полей формы! Проверьте правильность заполнения данных.');
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>

<template>
    <AppLayout>
        <Head>
            <title>Inertia Pizza – оформление заказа</title>
        </Head>
        <Container v-auto-animate>
            <h1 v-if="cart.length >= 1" class="text-4xl font-bold dark:text-white my-12">Оформление заказа</h1>
            <div class="flex gap-10 mb-12" v-if="cart.length >= 1">
                <div class="flex flex-col gap-10 dark:text-white w-3xl">
                    <CommonCard>
                        <div class="flex justify-between items-center pb-6 border-b-1 border-stone-900/20">
                            <div class="text-2xl font-bold">1. Корзина</div>
                            <div
                                class="flex items-center gap-x-1.5 text-stone-400 hover:text-jaffa-400 transition cursor-pointer"
                                @click="cartStore.clearCart()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                                Очистить корзину
                            </div>
                        </div>
                        <div v-auto-animate>
                            <div v-for="(pizza, index) in cart" :key="index"
                                 class="flex justify-between items-center gap-x-12 py-8">
                                <div class="flex flex-1 items-center gap-x-5">
                                    <img :src="pizza.image" :alt="pizza.name" class="w-20 h-20">
                                    <div>
                                        <div class="text-lg font-bold">{{ pizza.name }}</div>
                                        <div class="text-sm text-stone-400">{{ pizza.crust }} / {{ pizza.size }}
                                            <span v-if="pizza.addons && pizza.addons.length >= 1">
                                                / Добавки — {{ pizza.addons.join(', ').toLowerCase() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="font-bold">{{ pizza.price }} ₽</div>
                                <div class="flex items-center gap-x-2 font-bold ">
                                    <div @click="decrement(index)"
                                         class="select-none border border-jaffa-500 hover:bg-jaffa-500 transition rounded-lg cursor-pointer text-xl px-2">
                                        −
                                    </div>
                                    <div>{{ pizza.quantity }}</div>
                                    <div @click="increment(index)"
                                         :class="['select-none border border-jaffa-500 hover:bg-jaffa-500 transition rounded-lg cursor-pointer text-xl px-2', pizza.quantity >= 5 ? 'bg-jaffa-500' : '']">
                                        +
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CommonCard>
                    <CommonCard>
                        <div class="flex justify-between items-center pb-6 border-b-1 border-stone-900/20">
                            <div class="text-2xl font-bold">2. Персональная информация</div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-10 py-8">
                            <div>
                                <Label for="first_name">Имя</Label>
                                <Input name="first_name" type="text" :errors="errors" v-model="form.first_name"/>
                            </div>
                            <div>
                                <Label for="last_name">Фамилия</Label>
                                <Input name="last_name" type="text" :errors="errors" v-model="form.last_name"/>
                            </div>
                            <div>
                                <Label for="email">Email</Label>
                                <Input name="email" type="email" :errors="errors" v-model="form.email"/>
                            </div>
                            <div>
                                <Label for=Label>Телефон</Label>
                                <Input name="phone" type="tel" :errors="errors" v-model="form.phone"/>
                            </div>
                        </div>
                    </CommonCard>
                    <CommonCard>
                        <div class="flex justify-between items-center pb-6 border-b-1 border-stone-900/20">
                            <div class="text-2xl font-bold">3. Адрес доставки</div>
                        </div>
                        <div class="grid gap-x-6 gap-y-8 py-8">
                            <div>
                                <Label for="address">Адрес</Label>
                                <Input name="address" type="text" :errors="errors" v-model="form.address"/>
                            </div>
                            <div>
                                <Label for="comment">Комментарий</Label>
                                <Textarea v-model="form.comment" type="text" id="comment"/>
                            </div>
                        </div>
                    </CommonCard>
                </div>
                <div class="flex flex-col flex-grow text-white">
                    <CommonCard>
                        <div class="pb-6 border-b-1 border-stone-900/20">
                            <div class="text-xl">Итого:</div>
                            <div class="text-3xl font-bold">{{ totalPrice }} ₽</div>
                        </div>
                        <div class="flex items-center justify-between mt-7">
                            <div class="flex items-center gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                                </svg>
                                Доставка
                            </div>
                            <b>{{ DELIVERY_COST }} ₽</b>
                        </div>
                        <CommonButton
                            @click="orderStore"
                            :disabled="loading"
                            margin-class="mt-10"
                        >
                            Заказать
                        </CommonButton>
                    </CommonCard>
                </div>
            </div>
            <div v-else
                 class="flex flex-col my-28">
                <StatusBlock
                    image="/images/icons/empty-order.png"
                    title="Ууупс :("
                    description="кажется, вы попали на страницу заказа с пустой корзиной"
                />
                <Link class="text-jaffa-500 hover:text-jaffa-400 text-center transition" href="/">Вернуться к выбору
                </Link>
            </div>
        </Container>
    </AppLayout>
</template>
