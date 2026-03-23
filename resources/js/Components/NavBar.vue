<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <header class="flex justify-between items-center py-10">
        <div class="flex items-center">
            <Link href="/" class="text-2xl font-bold text-[#FF2D20]">NewsApp</Link>
        </div>
        <nav v-if="canLogin" class="flex space-x-4">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black transition hover:text-[#FF2D20]/70 dark:text-white"
            >
                Valdymo skydas
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black transition hover:text-[#FF2D20]/70 dark:text-white"
                >
                    Prisijungti
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black transition hover:text-[#FF2D20]/70 dark:text-white"
                >
                    Registruotis
                </Link>
            </template>
        </nav>
    </header>
</template>
