<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits, defineProps, ref } from 'vue';
const props = defineProps<{
    visible: boolean;
    title: string;
    name: string;
    form: {
        bulan: number;
        tahun: number;
        user_id: number;
        target_id: number;
    };
}>();

const emit = defineEmits<{
    (e: 'cancel'): void;
}>();
const previewImages = ref<string[]>([]);

const form = useForm({
    images: [] as File[],
    bulan: 0,
    tahun: 0,
    user_id: 0,
    target_id: 0,
});

// handle file change
const handleFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = target.files;
    if (files) {
        form.images = Array.from(files);
        form.bulan = props.form.bulan;
        form.tahun = props.form.tahun;
        form.user_id = props.form.user_id;
        form.target_id = props.form.target_id;
        previewImages.value = Array.from(files).map((file) => URL.createObjectURL(file));
    }
};

const submitForm = () => {
    console.log(form.target_id);
    form.post(route('multi-upload'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            previewImages.value = [];
            emit('cancel');
        },
    });
};
const cancel = () => emit('cancel');
</script>
<template>
    <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-transparent">
        <div class="w-full max-w-md rounded-lg bg-zinc-200 bg-opacity-70 p-6 dark:bg-stone-600 dark:bg-opacity-70">
            <h2 class="mb-4 rounded-sm bg-sky-500 p-2 text-center text-xl font-bold">{{ props.name }}</h2>
            <p class="mb-6 rounded-sm bg-sky-400 p-2">{{ props.title }}</p>

            <form @submit.prevent="submitForm">
                <input type="file" multiple accept="image/*" @change="handleFiles" class="mb-4 w-full rounded border border-gray-300 p-2" />

                <div v-if="previewImages.length" class="mb-4 grid grid-cols-3 gap-2">
                    <div v-for="(src, i) in previewImages" :key="i">
                        <img :src="src" class="h-24 w-full rounded object-cover shadow" />
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button @click="cancel" class="rounded bg-gray-300 px-4 py-2 text-green-600 hover:bg-gray-300">Mboten</button>
                    <button type="submit" :disabled="form.processing" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        {{ form.processing ? 'Uploading...' : 'Upload Images' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
