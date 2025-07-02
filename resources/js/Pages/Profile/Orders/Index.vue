<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {format} from 'date-fns';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Containers/Container.vue';
import CommonCard from '@/Components/CommonCard.vue';
import StatusBlock from '@/Components/StatusBlock.vue';

const props = defineProps({
    orders: Object
});

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
        <title>Inertia Pizza – список ваших заказов</title>
        <meta name="description" content="Your page description">
    </Head>
    <AppLayout>
        <Container>
            <h1 v-if="orders.length"
                class="text-4xl font-bold dark:text-white my-12">Мои заказы</h1>
            <div v-if="orders.length"
                 class="flex flex-col gap-y-10 mb-12">
                <CommonCard
                    v-for="order in props.orders"
                    :key="order.id"
                    width-class="max-w-4xl"
                >
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <div class="text-white font-bold text-lg">Заказ №{{ order.id }}
                                <span class="text-sm text-stone-400 font-medium">от {{
                                        format(new Date(order.created_at), 'dd.MM.yyyy HH:mm')
                                    }}</span>
                            </div>
                            <div class="text-white text-sm">Статус:
                                <span
                                    :class="['text-neutral-800 font-bold px-2 ms-1 rounded-2xl', statusClasses[order.status] || 'bg-gray-500']"
                                >
                            {{ statusLabels[order.status] || 'неизвестен' }}
                            </span>
                            </div>
                        </div>
                        <div class="text-jaffa-500 font-bold text-xl">{{ order.total_price }} ₽</div>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="item in order.items"
                            :key="item.id"
                            class="flex items-center gap-4 border-t border-stone-900/20 pt-4"
                        >
                            <img :src="item.pizza.image" class="w-20 h-20 object-cover" :alt="item.pizza.name "/>
                            <div class="flex-1">
                                <div class="text-jaffa-400 text-xl font-bold">{{ item.pizza.name }}</div>
                                <div class="text-sm text-stone-400">
                                    {{ item.size }} / {{ item.crust }}
                                    <span v-if="item.addons && item.addons.length >= 3">
                                        / Добавки — {{ JSON.parse(item.addons).join(', ').toLowerCase() }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-stone-400 font-semibold">{{ item.unit_price }} ₽ × {{ item.quantity }}</div>
                        </div>
                    </div>
                </CommonCard>
            </div>
            <div v-else
                 class="flex flex-col my-28">
                <StatusBlock
                    image="/images/icons/user-block.png"
                    title="У вас нет заказов"
                    description="возвращайтесь в этот раздел, когда что-нибудь купите"
                />
                <Link class="text-jaffa-500 hover:text-jaffa-400 text-center transition" href="/">Вернуться на главную
                </Link>
            </div>
        </Container>
    </AppLayout>
</template>
