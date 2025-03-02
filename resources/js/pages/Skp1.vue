<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: '1',
        href: '/skp1',
    },
];
const selectedFile = ref(null);
const preview = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        selectedFile.value = file;

        // Preview Image
        const reader = new FileReader();
        reader.onload = () => {
            preview.value = reader.result;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Please select a valid image file.');
        selectedFile.value = null;
        preview.value = null;
    }
};

const submitForm = () => {
    if (!selectedFile.value) {
        alert('No file selected!');
        return;
    }

    // Simulate form submission
    alert('Image uploaded successfully!');
};
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg">
                <h2 class="text-xl font-bold mb-4">Upload Image</h2>

                <form @submit.prevent="submitForm">
                    <!-- Image Preview -->
                    <div v-if="preview" class="mb-4">
                        <img :src="preview" alt="Image Preview" class="w-40 h-40 object-cover rounded-lg">
                    </div>

                    <!-- File Input -->
                    <label class="block mb-2 text-gray-700 font-medium">Select an image:</label>
                    <input type="file" accept="image/*" @change="handleFileChange"
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300" />

                    <!-- Submit Button -->
                    <button type="submit"
                        class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                        Upload
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
