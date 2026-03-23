<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    post: {
        type: Object,
        required: true
    },
    isHero: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div v-if="isHero" class="mb-12">
        <Link :href="route('posts.show', post.slug)" class="group block">
            <div class="relative overflow-hidden rounded-xl bg-white shadow-lg h-[500px]">
                <img
                    v-if="post.media && post.media.length > 0"
                    :src="post.media[0].original_url"
                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                />
                <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Nėra nuotraukos</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                    <h1 class="text-4xl font-bold text-white mb-4 group-hover:text-[#FF2D20] transition">{{ post.title }}</h1>
                    <p class="text-white/80 line-clamp-2 text-lg">{{ post.excerpt }}</p>
                    <div class="mt-4 flex items-center text-sm text-white/60">
                        <span>Autorius: {{ post.author.name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ new Date(post.created_at).toLocaleDateString('lt-LT') }}</span>
                    </div>
                </div>
            </div>
        </Link>
    </div>

    <div v-else class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
        <Link :href="route('posts.show', post.slug)" class="group overflow-hidden">
            <img
                v-if="post.media && post.media.length > 0"
                :src="post.media[0].original_url"
                class="h-64 w-full object-cover transition duration-300 group-hover:scale-105"
            />
            <div v-else class="h-64 w-full bg-gray-100 flex items-center justify-center text-gray-400">
                Nėra nuotraukos
            </div>
        </Link>
        <div class="p-6 flex-1 flex flex-col bg-white dark:bg-zinc-900">
            <h2 class="text-2xl font-bold mb-3">
                <Link :href="route('posts.show', post.slug)" class="text-zinc-900 dark:text-white hover:text-[#FF2D20] transition">{{ post.title }}</Link>
            </h2>
            <p class="text-gray-600 line-clamp-3 mb-4 flex-1 text-sm/relaxed">{{ post.excerpt }}</p>
            <div class="flex items-center justify-between text-xs text-gray-500 mt-auto pt-4 border-t">
                <span class="font-semibold">Autorius: {{ post.author.name }}</span>
                <span>{{ new Date(post.created_at).toLocaleDateString('lt-LT') }}</span>
            </div>
        </div>
    </div>
</template>
