<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Valdymo skydas" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Valdymo skydas
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Verification Alert for Authors -->
                <div v-if="$page.props.roles.includes('author') && !$page.props.auth.user.is_verified_by_admin"
                    class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow-sm"
                >
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">
                                Jūsų paskyra laukia administratoriaus patvirtinimo.
                            </p>
                            <p class="text-sm text-yellow-600 mt-1">
                                Kol kas jūsų galimybės yra ribotos: negalite kurti naujų įrašų ar redaguoti esamų, kol administratorius nepatvirtins jūsų tapatybės.
                            </p>
                        </div>
                    </div>
                </div>

                <div v-if="$page.props.flash.message" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.message }}</span>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Sėkmingai prisijungėte!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
