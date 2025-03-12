<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, ref } from 'vue';

interface Data {
    name: string;
    target: Job[];
    id: number;
    jabatan: { name: string };
}
interface Job {
    id: number;
    name: string;
    slug: string;
}
const props = defineProps<{
    tugas: Data;
    user: { id: number; username: string };
    link: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.tugas.jabatan.name,
        href: 'tugas1',
    },
];

console.log(props.tugas);
console.log(props.user);
console.log(props.link);
const GITHUB_USERNAME = import.meta.env.VITE_GITHUB_USERNAME;
const GITHUB_REPO = import.meta.env.VITE_GITHUB_REPO;
const GITHUB_BRANCH = import.meta.env.VITE_GITHUB_BRANCH;
const GITHUB_ACCESS_TOKEN = import.meta.env.VITE_GITHUB_ACCESS_TOKEN;
const GITHUB_API_URL = `https://api.github.com/repos/${GITHUB_USERNAME}/${GITHUB_REPO}/contents/foto/`;

const image = ref<File[]>([]);
const previewUrl = ref<string[]>([]);
const uploadedImageUrl = ref<string[]>([]);
const isUploading = ref<boolean[]>([]);

const onFileChange = (event: Event, index: number) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        image.value[index] = target.files[0];
        previewUrl.value[index] = URL.createObjectURL(target.files[0]);
    }
};

const uploadImage = async (id: number, slug: string, index: number) => {
    if (!image.value[index]) {
        alert('Please select an image first!');
        return;
    }

    isUploading.value[index] = true;
    const reader = new FileReader();
    reader.onload = async () => {
        const base64Image = (reader.result as string).split(',')[1];
        const fileName = `${Date.now()}_${props.user.username}_${slug}.jpg`;

        try {
            const response = await axios.put(
                `${GITHUB_API_URL}${fileName}`,
                {
                    message: `Upload image: ${fileName}`,
                    content: base64Image,
                    branch: GITHUB_BRANCH,
                },
                {
                    headers: {
                        Authorization: `token ${GITHUB_ACCESS_TOKEN}`,
                        Accept: 'application/vnd.github.v3+json',
                    },
                },
            );

            uploadedImageUrl.value[index] = response.data.content.download_url;
            form.link = response.data.content.download_url;
            form.user_id = props.user.id;
            form.target_id = id;
            form.post(route('upload'), {
                onFinish: () => form.reset(),
            });
        } catch (error) {
            console.error('Upload failed:', error);
        } finally {
            isUploading.value[index] = false;
        }
    };

    reader.readAsDataURL(image.value[index]);
};

const form = useForm({
    link: '',
    user_id: 0,
    target_id: 0,
});
// Generate years dynamically (last 30 years + next 10 years)
const currentYear = new Date().getFullYear();
const years = Array.from({ length: 7 }, (_, i) => currentYear - 3 + i);

// List of months
const months = [
    { id: 1, name: 'January' },
    { id: 2, name: 'February' },
    { id: 3, name: 'March' },
    { id: 4, name: 'April' },
    { id: 5, name: 'May' },
    { id: 6, name: 'June' },
    { id: 7, name: 'July' },
    { id: 8, name: 'August' },
    { id: 9, name: 'September' },
    { id: 10, name: 'October' },
    { id: 11, name: 'November' },
    { id: 12, name: 'December' },
];

// Default selections
const selectedYear = ref<number>(currentYear);
const selectedMonth = ref<number>(new Date().getMonth() + 1);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="mx-auto font-bold underline underline-offset-4">{{ props.tugas.name }}</h1>
            <div class="flex w-56 flex-col space-y-4">
                <!-- Year Picker -->
                <div>
                    <label for="year" class="font-semibold text-gray-700">Select Year:</label>
                    <select
                        v-model="selectedYear"
                        id="year"
                        class="w-full rounded-lg border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
                </div>

                <!-- Month Picker -->
                <div>
                    <label for="month" class="font-semibold text-gray-700">Select Month:</label>
                    <select
                        v-model="selectedMonth"
                        id="month"
                        class="w-full rounded-lg border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option v-for="month in months" :key="month.id" :value="month.id">
                            {{ month.name }}
                        </option>
                    </select>
                </div>

                <!-- Selected Date Display -->
                <p class="text-gray-600">
                    Selected: <span class="font-semibold">{{ months.find((m) => m.id === selectedMonth)?.name }} {{ selectedYear }}</span>
                </p>
            </div>
            <div>
                <div v-for="(job, index) in props.tugas.target" :key="job.id">
                    <div class="border border-gray-400 px-4 py-2 hover:bg-gray-100">{{ index + 1 }}. {{ job.name }}</div>
                    <div class="my-4 grid grid-cols-2 gap-4">
                        <div>
                            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                                <div v-if="previewUrl[index]">
                                    <img :src="previewUrl[index]" alt="Preview" class="" />
                                </div>
                                <div v-else>
                                    <PlaceholderPattern />
                                </div>
                            </div>
                            <input type="file" @change="(event) => onFileChange(event, index)" accept="image/*" class="mb-2" />
                            <button
                                @click="uploadImage(job.id, job.slug, index)"
                                :disabled="isUploading[index]"
                                class="mt-2 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                {{ isUploading[index] ? 'Tunggu Boss...' : 'Upload Foto' }}
                            </button>

                            <!-- Uploaded Image URL -->
                            <div v-if="uploadedImageUrl[index]" class="mt-2">
                                <p>Uploaded Image:</p>
                                <a :href="uploadedImageUrl[index]" target="_blank" class="text-blue-500 underline">{{ uploadedImageUrl[index] }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
