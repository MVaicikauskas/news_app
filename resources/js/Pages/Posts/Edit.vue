<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import FileInput from '@/Components/FileInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
});

const form = useForm({
    _method: 'PUT',
    title: props.post.title,
    excerpt: props.post.excerpt || '',
    content: props.post.content,
    image: null,
});

const submit = () => {
    form.post(route('posts.update', props.post.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Redaguoti įrašą" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Redaguoti įrašą</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="title" value="Pavadinimas" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="excerpt" value="Ištrauka" />
                                <TextInput
                                    id="excerpt"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.excerpt"
                                />
                                <InputError class="mt-2" :message="form.errors.excerpt" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image" value="Nuotrauka (palikite tuščią, jei norite išsaugoti esamą)" />
                                <FileInput
                                    id="image"
                                    class="mt-1 block w-full"
                                    v-model="form.image"
                                    accept="image/*"
                                />
                                <InputError class="mt-2" :message="form.errors.image" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="content" value="Turinys" />
                                <TextArea
                                    id="content"
                                    class="mt-1 block w-full"
                                    v-model="form.content"
                                    rows="10"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.content" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Atnaujinti įrašą
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
