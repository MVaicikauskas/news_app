<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    can: Object,
});

const voteForm = useForm({
    type: 0,
});

const submitVote = (type) => {
    voteForm.type = type;
    voteForm.post(route('posts.vote', props.post.id), {
        preserveScroll: true,
    });
};

const deletePost = (id) => {
    if (confirm('Ar tikrai norite ištrinti šį įrašą?')) {
        voteForm.delete(route('posts.destroy', id));
    }
};
</script>

<template>
    <Head :title="post.title" />

    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen font-sans">
        <div class="relative w-full max-w-7xl mx-auto px-6">
            <NavBar :can-login="canLogin" :can-register="canRegister" />

            <main class="max-w-4xl mx-auto py-12">
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800">
                    <!-- Featured Image -->
                    <div class="relative h-[400px] w-full overflow-hidden">
                        <img
                            v-if="post.media && post.media.length > 0"
                            :src="post.media[0].original_url"
                            class="h-full w-full object-cover"
                        />
                        <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center dark:bg-zinc-800">
                            <span class="text-gray-400">Nėra nuotraukos</span>
                        </div>
                    </div>

                    <div class="p-8 md:p-12">
                        <div class="flex items-center text-sm text-gray-500 mb-6 dark:text-zinc-400">
                            <span class="font-semibold text-zinc-900 dark:text-zinc-100">Autorius: {{ post.author.name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ new Date(post.created_at).toLocaleDateString('lt-LT') }}</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold text-zinc-900 dark:text-white mb-8 leading-tight">
                            {{ post.title }}
                        </h1>

                        <div v-if="post.excerpt" class="text-xl text-zinc-600 dark:text-zinc-300 mb-8 font-medium leading-relaxed border-l-4 border-[#FF2D20] pl-6 italic">
                            {{ post.excerpt }}
                        </div>

                        <div class="prose prose-lg dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">
                            {{ post.content }}
                        </div>

                        <div class="mt-12 flex items-center space-x-6 border-t border-gray-100 dark:border-zinc-800 pt-8">
                            <button
                                @click="submitVote(1)"
                                class="flex items-center space-x-2 px-6 py-3 bg-gray-50 dark:bg-zinc-800 hover:bg-gray-100 dark:hover:bg-zinc-700 rounded-full transition group"
                            >
                                <span class="text-xl group-hover:scale-110 transition">👍</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300">{{ post.likes_count }}</span>
                            </button>
                            <button
                                @click="submitVote(-1)"
                                class="flex items-center space-x-2 px-6 py-3 bg-gray-50 dark:bg-zinc-800 hover:bg-gray-100 dark:hover:bg-zinc-700 rounded-full transition group"
                            >
                                <span class="text-xl group-hover:scale-110 transition">👎</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300">{{ post.dislikes_count }}</span>
                            </button>
                        </div>

                        <div v-if="can.update_post || can.delete_post" class="mt-8 pt-8 border-t border-gray-100 dark:border-zinc-800 flex space-x-4">
                            <Link
                                v-if="can.update_post"
                                :href="route('posts.edit', post.id)"
                                class="inline-flex items-center px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold rounded-xl hover:bg-zinc-700 dark:hover:bg-zinc-200 transition shadow-lg"
                            >
                                Redaguoti įrašą
                            </Link>
                            <button
                                v-if="can.delete_post"
                                @click="deletePost(post.id)"
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg"
                            >
                                Ištrinti įrašą
                            </button>
                        </div>
                    </div>
                </article>
            </main>

            <footer class="py-16 text-center text-sm text-black/40 border-t mt-12 dark:text-white/40 dark:border-zinc-800">
                &copy; {{ new Date().getFullYear() }} NewsApp. Visos teisės saugomos.
            </footer>
        </div>
    </div>
</template>
