<script setup>
import {ref} from 'vue';
import {Head, useForm} from '@inertiajs/vue3';
import {useNotification} from '@/Composables/useNotification.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Containers/Container.vue';
import CommonCard from '@/Components/CommonCard.vue';
import Label from '@/Components/FormLabel.vue';
import Input from '@/Components/FormInput.vue';
import CommonButton from '@/Components/CommonButton.vue';

const {showNotification} = useNotification();

const props = defineProps({
    user: Object,
    errors: Object,
});

const form = useForm({
    first_name: props.user?.first_name ?? '',
    last_name: props.user?.last_name ?? '',
    address: props.user?.address ?? '',
    email: props.user?.email ?? '',
    phone: props.user?.phone ?? '',
});

const loading = ref(false);

const profileUpdate = () => {
    loading.value = true;

    form.patch('/profile/update', {
        onError: () => {
            showNotification('Ошибка при обработке данных... попробуйте еще раз.')
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>

<template>
    <Head>
        <title>Inertia Pizza – ваш профиль</title>
        <meta name="description" content="Оформите заказ пиццы с доставкой">
    </Head>
    <AppLayout>
        <Container>
            <h1 class="text-4xl font-bold dark:text-white my-12">Настройки профиля</h1>
            <div class="flex gap-10">
                <CommonCard width-class="w-4xl">
                    <div class="text-white grid grid-cols-2 gap-x-6 gap-y-10 py-8">
                        <div>
                            <Label for="first_name">Имя</Label>
                            <Input name="first_name" type="text" v-model="form.first_name" :errors="errors"/>
                        </div>
                        <div>
                            <Label for="last_name">Фамилия</Label>
                            <Input name="last_name" type="text" v-model="form.last_name" :errors="errors"/>
                        </div>
                        <div>
                            <Label for="email">Email</Label>
                            <Input name="email" type="email" v-model="form.email" :errors="errors" disabled/>
                        </div>
                        <div>
                            <Label for=phone>Телефон</Label>
                            <Input name="phone" type="tel" v-model="form.phone" :errors="errors"/>
                        </div>
                        <div class="col-span-2">
                            <Label for=address>Адрес</Label>
                            <Input name="address" type="text" v-model="form.address" :errors="errors"/>
                        </div>
                    </div>
                    <CommonButton
                        @click="profileUpdate"
                        :disabled="loading"
                        width-class="w-max">
                        Сохранить данные
                    </CommonButton>
                </CommonCard>
            </div>
        </Container>
    </AppLayout>
</template>
