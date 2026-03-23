<script setup>
import NavBar from '@/Components/NavBar.vue';
import PostCard from '@/Components/PostCard.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    posts: {
        type: Object,
    }
});
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <div class="relative w-full max-w-7xl mx-auto px-6">
            <NavBar :can-login="canLogin" :can-register="canRegister" />

            <main v-if="posts && posts.data.length > 0">
                <!-- Hero Post -->
                <PostCard :post="posts.data[0]" is-hero />

                <!-- Grid Posts -->
                <div class="grid gap-8 lg:grid-cols-2">
                    <PostCard v-for="post in posts.data.slice(1)" :key="post.id" :post="post" />
                </div>

                <!-- Pagination -->
                <div v-if="posts.links && posts.links.length > 3" class="mt-12 mb-16 flex justify-center">
                    <div class="flex space-x-1">
                        <template v-for="(link, key) in posts.links" :key="key">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="px-4 py-2 text-sm font-medium border rounded-md transition"
                                :class="{'bg-[#FF2D20] text-white border-[#FF2D20] shadow-sm': link.active, 'text-gray-700 bg-white hover:bg-gray-50 border-gray-300': !link.active}"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-4 py-2 text-sm font-medium text-gray-400 border border-gray-300 rounded-md bg-white cursor-not-allowed"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </main>
            <main v-else class="py-20 text-center">
                <div class="max-w-md mx-auto">
                    <p class="text-xl text-gray-500 mb-8">Naujienų kol kas nėra.</p>
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-black/40 border-t mt-12">
                &copy; {{ new Date().getFullYear() }} NewsApp. Visos teisės saugomos.
            </footer>
        </div>
    </div>
</template>
