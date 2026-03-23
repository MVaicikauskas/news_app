<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: [File, null],
    accept: {
        type: String,
        default: 'image/*'
    }
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

const handleChange = (e) => {
    emit('update:modelValue', e.target.files[0]);
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        type="file"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
        @input="handleChange"
        :accept="accept"
        ref="input"
    />
</template>
