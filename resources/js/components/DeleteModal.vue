<script lang="ts" setup>
import { LoaderCircle } from 'lucide-vue-next';
import { defineEmits, defineProps } from 'vue';

const props = defineProps<{
    visible: boolean;
    deleting: boolean;
    title?: string;
    message: string;
}>();

const emit = defineEmits<{
    (e: 'confirm'): void;
    (e: 'cancel'): void;
}>();

const confirm = () => emit('confirm');
const cancel = () => emit('cancel');
</script>
<template>
    <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="w-full max-w-md rounded-lg bg-background p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">{{ title }}</h2>
            <p class="mb-6">{{ message }}</p>

            <div class="flex justify-end space-x-4">
                <button @click="cancel" class="rounded bg-gray-300 px-4 py-2 text-green-600 hover:bg-gray-300">Mboten</button>
                <button @click="confirm" class="inline-flex items-center rounded bg-red-500 px-4 py-2 text-white hover:bg-red-600">
                    Iyo!
                    <LoaderCircle v-if="props.deleting" class="h-5 w-5 animate-spin" />
                </button>
            </div>
        </div>
    </div>
</template>
