<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import {useModalStore} from '@/Stores/modal.js';
import {useClickOutside} from '@/Composables/useClickOutside.js';
import Input from '@/Components/FormInput.vue';
import CommonButton from '@/Components/CommonButton.vue';

const modalStore = useModalStore();
const loginRef = ref(null);
const loading = ref(false);

const form = useForm({
    email: '',
});

const sendCode = () => {
    loading.value = true;
    form.post('/auth/send-code', {
        onSuccess: () => {
            setTimeout(() => {
                modalStore.closeEmailAuth();
                modalStore.openVerificationCode(form.email);
            }, 300);
        },
        onFinish: () => {
            loading.value = false;
        },
    })
};

useClickOutside(loginRef, modalStore.closeEmailAuth, true);
</script>

<template>
    <div
        class="fixed inset-0 bg-stone-700/70 z-10 flex justify-center items-center">
        <div ref="loginRef" class="relative max-w-xs w-full bg-neutral-800 rounded-2xl px-11 py-12 sm:max-w-md">
            <button @click="modalStore.closeEmailAuth"
                    class="absolute top-2.5 right-5 z-10 text-3xl font-bold text-white cursor-pointer transition hover:text-jaffa-400 hover:scale-150 sm:top-0 sm:-right-8">
                ×
            </button>
            <div class="flex items-center">
                <div>
                    <div class="text-4xl text-white">Вход в&nbsp;аккаунт</div>
                    <div class="text-stone-400 mt-2.5">Введите ваш адрес электронной почты, чтобы войти или
                        зарегистрироваться
                    </div>
                </div>
                <img src="/images/icons/email.png" class="w-16 h-16" alt="Email Icon">
            </div>
            <div class="mt-5">
                <form @submit.prevent="sendCode">
                    <Input type="email" id="email" v-model="form.email" placeholder="pizza@lover.com" required/>
                    <CommonButton type="submit" :disabled="loading" margin-class="mt-5">
                        Получить код
                    </CommonButton>
                </form>
            </div>
        </div>
    </div>
</template>
