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
    laporan: string[];
}
const props = defineProps<{
    tugas: Data;
    user: { id: number; username: string; job: Number };
    date: { month: number; year: number };
}>();
console.log(props.tugas.target[0].laporan);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.tugas.jabatan.name,
        href: 'tugas',
    },
];

console.log(props.tugas);


const image = ref<File[]>([]);
const previewUrl = ref<string[]>([]);
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
        alert('isi foto dulu Bolo...');
        return;
    }

    isUploading.value[index] = true;
    const reader = new FileReader();
    reader.onload = async () => {
        const base64Image = (reader.result as string).split(',')[1];
        const fileName = `${Date.now()}_${props.user.username}_${slug}.jpg`;

        try {
            const response = await axios.put(
                `https://api.github.com/repos/OgySatya/seloaji/contents/foto/${fileName}`,
                {
                    message: `Upload image: ${fileName}`,
                    content: base64Image,
                    branch: 'main',
                },
                {
                    headers: {
                        Authorization: `token ${import.meta.env.VITE_GITHUB_TOKEN}`,
                        Accept: 'application/vnd.github.v3+json',
                    },
                },
            );

            form.image = response.data.content.download_url;
            form.bulan = selectedMonth.value;
            form.tahun = selectedYear.value;
            form.user_id = props.user.id;
            form.target_id = id;

        } catch (error) {
            console.error('Upload failed:', error);
        } finally {
            isUploading.value[index] = false;
            previewUrl.value = [];
            image.value = [];
            form.post(route('put'), {
                onFinish: () => form.reset(),
            });
        }
    };

    reader.readAsDataURL(image.value[index]);
};

const form = useForm({
    image: '',
    bulan: 0,
    tahun: 0,
    user_id: 0,
    target_id: 0,
});

const currentYear = new Date().getFullYear();
const years = Array.from({ length: 7 }, (_, i) => currentYear - 3 + i);
const months = [
    { id: 1, name: 'Januari' },
    { id: 2, name: 'Februari' },
    { id: 3, name: 'Maret' },
    { id: 4, name: 'April' },
    { id: 5, name: 'Mei' },
    { id: 6, name: 'Juni' },
    { id: 7, name: 'Juli' },
    { id: 8, name: 'Agustus' },
    { id: 9, name: 'September' },
    { id: 10, name: 'Oktober' },
    { id: 11, name: 'November' },
    { id: 12, name: 'Desember' },
];

const selectedYear = ref<number>(Number(props.date.year));
const selectedMonth = ref<number>(Number(props.date.month));
const redirect = (month: number, year: number) => {
    route(`/job?=${props.user.job}&month=${month}&year=${year}`)
};
const isGenerating = ref(false);

const generatePdf = (month: number, year: number) => {
    isGenerating.value = true;
    window.location.href = `/pdf?tugas=${props.user.job}&month=${month}&year=${year}`;
};
</script>

<template>

    <Head title="Rekapitulasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="mx-auto font-bold underline underline-offset-4">{{ props.tugas.name }}</h1>
            <div class="flex w-56 flex-col space-y-4">
                <div>
                    <label for="year" class="font-semibold text-gray-700">Tahun:</label>
                    <select v-model="selectedYear" id="year"
                        class="w-full rounded-lg border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
                </div>

                <div class="grid">
                    <label for="month" class="font-semibold text-gray-700">Sasih:</label>
                    <select @change="redirect(selectedMonth, selectedYear)" v-model="selectedMonth"
                        class="rounded-lg border p-2">
                        <option v-for="month in months" :key="month.id" :value="month.id">
                            {{ month.name }}
                        </option>
                    </select>
                </div>

                <p class="text-gray-600">
                    Laporan Bulan : <span class="font-semibold">{{months.find((m) => m.id === selectedMonth)?.name}}
                        {{ selectedYear }}</span>
                </p>
            </div>
            <div>
                <div v-for="(job, index) in props.tugas.target" :key="job.id">
                    <div class="border border-gray-400 px-4 py-2 hover:bg-gray-100">{{ index + 1 }}. {{ job.name }}
                    </div>
                    <div class="my-4 grid grid-cols-2 gap-4">
                        <div v-for="(link, imgIndex) in props.tugas.target[index].laporan || []" :key="imgIndex">
                            <div
                                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                                <img class="h-full w-full object-fill" :src="link" />
                            </div>
                        </div>
                        <div>
                            <div
                                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                                <div v-if="previewUrl[index]">
                                    <img :src="previewUrl[index]" alt="Preview" class="" />
                                </div>
                                <div v-else>
                                    <PlaceholderPattern />
                                </div>
                            </div>
                            <input type="file" @change="(event) => onFileChange(event, index)" accept="image/*"
                                class="mb-2" />
                            <button @click="uploadImage(job.id, job.slug, index)" :disabled="isUploading[index]"
                                class="mt-2 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-700">
                                {{ isUploading[index] ? 'Tunggu Boss...' : 'Upload Foto' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-white p-6 shadow-lg">
                <p class="text-2xl text-emerald-500">Rekap SKP jadi PDF</p>

                <button @click="generatePdf(selectedMonth, selectedYear)" :disabled="isGenerating"
                    class="mt-4 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-400">
                    {{ isGenerating ? 'Ngenteni sithik suwe BOSS...' : 'Rekap SKP' }}
                </button>
            </div>
        </div>
    </AppLayout>
</template>
