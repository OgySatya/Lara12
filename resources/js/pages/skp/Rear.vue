<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
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
    user: User;
    date: { month: number; year: number };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.user.name,
        href: 'job',
    },
];

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
    const file = image.value[index];
    const maxSize = 2048 * 1024;
    if (file.size > maxSize) {
        alert('Ukuran Foto Max 2MB!');
        return;
    }
    isUploading.value[index] = true;
    const newFileName = `${Date.now()}_${props.user.username}_${slug}.jpg`;
    const newFile = new File([file], newFileName, { type: file.type });

    const formData = new FormData();
    formData.append('image', newFile);
    formData.append('name', newFileName);
    try {
        const response = await axios.post('/store', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        form.image = newFileName;
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
        form.post(route('save'), {
            onFinish: () => form.reset(),
        });
    }
};

const deleteImage = async (fileName: string) => {
    if (!confirm(`yakin di hapus Boss?`)) {
        return;
    }

    try {
        form.image = fileName;
        form.delete(route('delete'), {
            onFinish: () => form.reset(),
        });

    } catch (error) {
        alert('Error gak iso di hapus');
    } finally {
        alert('Foto berhasil dihapus');
    }
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
    window.location.href = `/job?job=${props.user.job}&month=${month}&year=${year}`;
};
const isGenerating = ref(false);

const generatePdf = (month: number, year: number) => {
    isGenerating.value = true;
    window.location.href = `/pdf?job=${props.user.job}&month=${month}&year=${year}`;
};
</script>

<template>

    <Head title="Rekapitulasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="mx-auto font-bold underline underline-offset-4">{{ props.tugas.name }}</h1>
            <div class="flex w-56 flex-col space-y-4">
                <div>
                    <label for="year" class="font-semibold">Tahun:</label>
                    <select v-model="selectedYear" id="year"
                        class="w-full rounded-lg border border-input bg-background p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
                </div>

                <div class="grid">
                    <label for="month" class="font-semibold">Sasih:</label>
                    <select @change="redirect(selectedMonth, selectedYear)" v-model="selectedMonth"
                        class="rounded-lg border border-input bg-background p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option v-for="month in months" :key="month.id" :value="month.id">
                            {{ month.name }}
                        </option>
                    </select>
                </div>

                <p class="font-bold">
                    Laporan Bulan : <span>{{months.find((m) => m.id === selectedMonth)?.name}} {{ selectedYear
                    }}</span>
                </p>
            </div>
            <div>
                <div v-for="(job, index) in props.tugas.target" :key="job.id">
                    <div class="border border-gray-400 px-4 py-2 hover:bg-gray-100">{{ index + 1 }}. {{ job.name }}
                    </div>
                    <div class="my-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid" v-for="(link, imgIndex) in props.tugas.target[index].laporan || []"
                            :key="imgIndex">
                            <div
                                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                                <img class="h-full w-full object-fill" :src="`/storage/uploads/${link}`" />
                            </div>
                            <button
                                class="mx-auto mt-2 w-32 rounded-lg bg-red-500 px-4 py-1 text-white hover:bg-red-700"
                                @click="deleteImage(link)">
                                Hapus Foto
                            </button>
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
                            <div class="mx-auto mt-2 flex w-3/4 justify-between gap-2">
                                <label>
                                    <input type="file" hidden @change="(event) => onFileChange(event, index)"
                                        accept="image/*" />
                                    <div
                                        class="w-32 rounded-lg bg-lime-500 px-3 py-1 text-center text-white hover:bg-lime-700">
                                        Isi Foto</div>
                                </label>
                                <button @click="uploadImage(job.id, job.slug, index)" :disabled="isUploading[index]"
                                    class="rounded-lg bg-gray-500 px-3 py-1 text-white hover:bg-blue-700">
                                    {{ isUploading[index] ? 'Tunggu Boss...' : 'Upload Foto' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-teal-100 p-6 shadow-lg dark:bg-slate-700">
                <p class="text-2xl text-emerald-500 dark:text-white">Rekap SKP jadi PDF</p>

                <button @click="generatePdf(selectedMonth, selectedYear)" :disabled="isGenerating"
                    class="mt-4 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-400">
                    {{ isGenerating ? 'Monggo di enteni, suwe BOSS...' : 'Rekap SKP' }}
                </button>
            </div>
        </div>
    </AppLayout>
</template>
