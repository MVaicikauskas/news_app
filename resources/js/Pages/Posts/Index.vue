<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    posts: Object,
    filters: Object,
});

const form = useForm({});

const deletePost = (id) => {
    if (confirm('Ar tikrai norite ištrinti šį įrašą?')) {
        form.delete(route('posts.destroy', id));
    }
};

const restorePost = (id) => {
    form.post(route('posts.restore', id));
};

const forceDeletePost = (id) => {
    if (confirm('Ar tikrai norite ištrinti šį įrašą VISAM LAIKUI? Šio veiksmo atšaukti negalėsite.')) {
        form.delete(route('posts.force-delete', id));
    }
};
</script>

<template>
    <Head title="Įrašai" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ filters.trashed ? 'Ištrinti įrašai' : 'Įrašai' }}
                </h2>
                <div class="flex space-x-2">
                    <Link
                        v-if="!filters.trashed"
                        :href="route('posts.index', { trashed: true })"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Šiukšlinė
                    </Link>
                    <Link
                        v-else
                        :href="route('posts.index')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Atgal į sąrašą
                    </Link>
                    <Link
                        v-if="$page.props.can.create_post"
                        :href="route('posts.create')"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Sukurti įrašą
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.message }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nuotrauka</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pavadinimas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autorius</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sukurta</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Veiksmai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="post in posts.data" :key="post.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img v-if="post.media && post.media.length > 0" :src="post.media[0].original_url" class="h-10 w-10 rounded-full object-cover" />
                                        <div v-else class="h-10 w-10 rounded-full bg-gray-200"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ post.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ post.author.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ new Date(post.created_at).toLocaleDateString('lt-LT') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <template v-if="!filters.trashed">
                                            <Link :href="route('posts.show', post.slug)" class="text-blue-600 hover:text-blue-900 mr-2">Peržiūrėti</Link>
                                            <Link v-if="$page.props.roles.includes('admin') || post.user_id === $page.props.auth.user.id" :href="route('posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">Redaguoti</Link>
                                            <button v-if="$page.props.roles.includes('admin') || post.user_id === $page.props.auth.user.id" @click="deletePost(post.id)" class="text-red-600 hover:text-red-900">Ištrinti</button>
                                        </template>
                                        <template v-else>
                                            <button v-if="$page.props.roles.includes('admin') || post.user_id === $page.props.auth.user.id" @click="restorePost(post.id)" class="text-green-600 hover:text-green-900 mr-2">Atkurti</button>
                                            <button v-if="$page.props.roles.includes('admin') || post.user_id === $page.props.auth.user.id" @click="forceDeletePost(post.id)" class="text-red-600 hover:text-red-900">Ištrinti visam laikui</button>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div v-if="posts.links && posts.links.length > 3" class="mt-4 flex justify-center">
                            <div class="flex space-x-1">
                                <template v-for="(link, key) in posts.links" :key="key">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        class="px-3 py-1 text-sm border rounded"
                                        :class="{'bg-blue-500 text-white border-blue-500': link.active, 'text-gray-700 bg-white hover:bg-gray-50 border-gray-300': !link.active}"
                                        v-html="link.label"
                                    />
                                    <span
                                        v-else
                                        class="px-3 py-1 text-sm text-gray-400 border border-gray-300 rounded bg-white cursor-not-allowed"
                                        v-html="link.label"
                                    />
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
