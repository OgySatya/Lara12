<script lang="ts" setup>
import { defineEmits, defineProps } from 'vue';

const props = defineProps<{
    visible: boolean;
}>();

const emit = defineEmits<{
    (e: 'confirm'): void;
    (e: 'cancel'): void;
}>();

const confirm = () => emit('confirm');
const cancel = () => emit('cancel');
</script>
<template>
    <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-transparent">
        <div class="w-full max-w-md rounded-lg bg-zinc-200 bg-opacity-70 p-6 dark:bg-stone-600 dark:bg-opacity-70">
            <h2 class="mb-4 text-lg font-semibold">copy</h2>
            <p class="mb-6">jabatan</p>

            <div class="flex justify-end space-x-4">
                <button @click="cancel" class="rounded bg-gray-300 px-4 py-2 text-green-600 hover:bg-gray-300">Mboten</button>
                <button @click="confirm" class="inline-flex items-center rounded bg-red-500 px-4 py-2 text-white hover:bg-red-600"></button>
            </div>
        </div>
    </div>
</template>
