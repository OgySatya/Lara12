<template>
    <div v-if="visible" class="fixed inset-0 flex items-center justify-center z-50">
        <div class=" bg-background p-6 rounded-lg shadow-lg w-full max-w-md ">
            <h2 class="text-lg font-semibold mb-4">{{ title }}</h2>
            <p class="mb-6">{{ message }}</p>
            <div class="flex justify-end space-x-4">
                <button @click="cancel"
                    class="px-4 py-2 bg-gray-300 text-green-600 rounded hover:bg-gray-300">Mboten</button>
                <button @click="confirm" class="px-4 py-2 bg-red-500 rounded text-white hover:bg-red-600">Iyo!</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps<{
    visible: boolean
    title?: string
    message: string
}>()

const emit = defineEmits<{
    (e: 'confirm'): void
    (e: 'cancel'): void
}>()

const confirm = () => emit('confirm')
const cancel = () => emit('cancel')
</script>