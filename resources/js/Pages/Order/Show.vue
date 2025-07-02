<script setup>
import {Head} from '@inertiajs/vue3';
import {format} from 'date-fns';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Containers/Container.vue';
import CommonCard from '@/Components/CommonCard.vue';

const props = defineProps({
    order: Object,
});

const currentOrder = props.order;

const statusClasses = {
    rejected: 'bg-red-500',
    accepted: 'bg-jaffa-400',
    cooking: 'bg-amber-400',
    delivery: 'bg-sky-400',
    finalized: 'bg-lime-400',
};

const statusLabels = {
    rejected: 'отклонён',
    accepted: 'принят',
    cooking: 'готовим',
    delivery: 'на доставке',
    finalized: 'завершен',
};
</script>

<template>
    <Head>
        <title>Inertia Pizza – просмотр статуса заказа</title>
    </Head>
    <AppLayout>
        <Container>
            <h1 class="text-4xl font-bold dark:text-white my-12">Ваш заказ</h1>
            <div class="flex sm:flex-col lg:flex-row gap-10">
                <CommonCard
                    width-class="w-3xl"
                >
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <div class="text-white font-bold text-lg">Заказ №{{ currentOrder.id }}
                                <span class="text-sm text-stone-400 font-medium">от {{
                                        format(new Date(currentOrder.created_at), 'dd.MM.yyyy HH:mm')
                                    }}</span>
                            </div>
                            <div class="text-white text-sm">Статус:
                                <span
                                    :class="['text-neutral-800 font-bold px-2 ms-1 rounded-2xl', statusClasses[currentOrder.status] || 'bg-gray-500']"
                                >
                            {{ statusLabels[currentOrder.status] || 'неизвестен' }}
                            </span>
                            </div>
                        </div>
                        <div class="text-jaffa-500 font-bold text-xl">{{ currentOrder.total_price }} ₽</div>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="item in currentOrder.items"
                            :key="item.id"
                            class="flex items-center gap-4 border-t border-stone-900/20 py-4"
                        >
                            <img :src="item.pizza.image" class="w-20 h-20 object-cover"
                                 :alt="item.pizza.name "/>
                            <div class="flex-1">
                                <div class="text-jaffa-400 text-xl font-bold">{{ item.pizza.name }}</div>
                                <div class="text-sm text-stone-400">
                                    {{ item.size }} / {{ item.crust }}
                                    <span v-if="item.addons && item.addons.length >= 3">
                                        / Добавки — {{ JSON.parse(item.addons).join(', ').toLowerCase() }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-stone-400 ">{{ item.unit_price }} ₽ × {{ item.quantity }}</div>
                        </div>
                    </div>
                </CommonCard>
                <CommonCard
                    width-class="flex-1 h-max">
                    <div class="flex items-center gap-x-2 py-4 text-white leading-5 font-bold">
                        <div class="text-jaffa-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <span>{{ currentOrder.first_name + ' ' + currentOrder.last_name }}</span>
                    </div>
                    <div class="flex items-center gap-x-2 py-4 text-white leading-5 font-bold">
                        <div class="text-jaffa-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                            </svg>
                        </div>
                        <span>{{ currentOrder.address }}</span>
                    </div>
                    <div v-if="currentOrder.comment"
                         class="text-stone-400 border-t border-stone-900/20 py-4">Ваш комментарий:
                        «{{ currentOrder.comment }}»
                    </div>
                </CommonCard>
            </div>
        </Container>
    </AppLayout>
</template>
