<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    authors: Array,
});

const form = useForm({});

const verifyAuthor = (id) => {
    form.post(route('admin.verify-authors.verify', id));
};
</script>

<template>
    <Head title="Autorių patvirtinimas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Autorių patvirtinimas</h2>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vardas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">El. paštas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patvirtinta el. paštu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Būsena</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Veiksmas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="author in authors" :key="author.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ author.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ author.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ author.email_verified_at ? new Date(author.email_verified_at).toLocaleString('lt-LT') : 'Ne' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span v-if="author.is_verified_by_admin" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Patvirtinta
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Laukia
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button
                                            v-if="!author.is_verified_by_admin"
                                            @click="verifyAuthor(author.id)"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Patvirtinti
                                        </button>
                                        <span v-else class="text-gray-400">Patvirtinta {{ new Date(author.admin_verified_at).toLocaleDateString('lt-LT') }}</span>
                                    </td>
                                </tr>
                                <tr v-if="authors.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nėra autorių, laukiančių patvirtinimo.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
