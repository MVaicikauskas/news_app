<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="El. pašto patvirtinimas" />

        <div class="mb-4 text-sm text-gray-600">
            Ačiū, kad užsiregistravote! Prieš pradedant, patvirtinkite savo el. pašto adresą paspausdami nuorodą, kurią ką tik išsiuntėme jums el. paštu. Jei negavote el. laiško, mes mielai atsiųsime kitą.
        </div>

        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            Nauja patvirtinimo nuoroda buvo išsiųsta el. pašto adresu, kurį nurodėte registracijos metu.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Persiųsti patvirtinimo el. laišką
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Atsijungti</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
