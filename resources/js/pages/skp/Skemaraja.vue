<script setup lang="ts">
import DeleteModal from '@/components/DeleteModal.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, ref } from 'vue';

const props = defineProps<{
    data: string;
    user: User;
    date: { month: number; year: number };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.user.name,
        href: 'job',
    },
];

const image = ref<File | null>(null);
const previewUrl = ref<string>('');
const isUploading = ref<boolean>(false);

const onFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        image.value = target.files[0];
        previewUrl.value = URL.createObjectURL(target.files[0]);
    }
};

const uploadImage = async () => {
    if (!image.value) {
        alert('isi foto dulu Bolo...');
        return;
    }
    const file = image.value;
    isUploading.value = true;
    const newFileName = `${Date.now()}_${props.user.username}.jpg`;
    const newFile = new File([file], newFileName, { type: file.type });

    const formData = new FormData();
    formData.append('image', newFile);
    formData.append('name', newFileName);
    try {
        const response = await axios.post('/rekap/store', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        form.path = newFileName;
        form.bulan = selectedMonth.value;
        form.tahun = selectedYear.value;
        form.user_id = props.user.id;
    } catch (error) {
        console.error('Upload failed:', error);
    } finally {
        isUploading.value = false;
        previewUrl.value = '';
        image.value = null;
        form.post(route('rekap.save'), {
            onFinish: () => form.reset(),
        });
    }
};
const isDeleting = ref<boolean[]>([]);
const deleteImg = ref<string>('');
const showModal = ref(false);
const modal = (link: string) => {
    showModal.value = true;
    deleteImg.value = link;
};
const deleteImage = async (index: number) => {
    isDeleting.value[index] = true;
    try {
        form.path = deleteImg.value;
        form.delete(route('rekap.delete'), {
            onFinish: () => form.reset(),
        });
    } catch (error) {
        alert('Error gak iso di hapus');
    } finally {
        isDeleting.value[index] = false;
        showModal.value = false;
        deleteImg.value = '';
    }
};
const form = useForm({
    path: '',
    bulan: 0,
    tahun: 0,
    user_id: 0,
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

const generatePdf = async (month: number, year: number) => {
    isGenerating.value = true;
    window.location.href = `/pdf?job=${props.user.job}&month=${month}&year=${year}`;
    isGenerating.value = false;
};
</script>

<template>
    <Head title="Rekap Absen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="mx-auto text-2xl font-bold underline underline-offset-4">Rekap Absen Skemaraja</h1>
            <div class="flex w-fit items-center gap-4">
                <div class="m-2 flex w-fit">
                    <label for="year" class="font-semibold">Tahun:</label>
                    <select
                        v-model="selectedYear"
                        id="year"
                        class="mx-2 rounded-lg border border-input bg-background px-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
                </div>

                <div class="m-2 flex w-fit">
                    <label for="month" class="font-semibold">Sasih:</label>
                    <select
                        @change="redirect(selectedMonth, selectedYear)"
                        v-model="selectedMonth"
                        class="mx-2 rounded-lg border border-input bg-background px-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option v-for="month in months" :key="month.id" :value="month.id">
                            {{ month.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div>
                <div>
                    <div class="mx-auto my-4 grid w-full grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid" v-for="(link, imgIndex) in props.data || []" :key="imgIndex">
                            <div
                                class="relative mx-auto mb-2 aspect-[9/20] w-2/3 overflow-hidden rounded-md border border-sidebar-border/70 dark:border-sidebar-border"
                            >
                                <img class="h-full w-full object-fill" :src="`/storage/absen/${link}`" />
                            </div>
                            <Button @click="modal(link)" class="mx-auto w-fit" variant="destructive">Hapus Foto</Button>

                            <DeleteModal
                                :visible="showModal"
                                :deleting="isDeleting[imgIndex]"
                                title="Nyuwun sewu"
                                message="Yakin Hapus Foto ini Boss?"
                                @confirm="deleteImage(imgIndex)"
                                @cancel="showModal = false"
                            />
                        </div>
                        <div>
                            <div
                                class="relative mx-auto mb-2 aspect-[9/20] w-2/3 overflow-hidden rounded-md border border-sidebar-border/70 dark:border-sidebar-border"
                            >
                                <div v-if="previewUrl">
                                    <img :src="previewUrl" alt="Preview" class="" />
                                </div>
                                <div v-else>
                                    <PlaceholderPattern />
                                </div>
                            </div>
                            <div class="mx-auto flex w-3/4 justify-between gap-2">
                                <label>
                                    <input type="file" hidden @change="(event) => onFileChange(event)" accept="image/*" />
                                    <div class="h-9 rounded-md bg-lime-500 px-4 py-2 text-center text-sm font-medium text-white hover:bg-teal-500">
                                        Isi Foto
                                    </div>
                                </label>
                                <Button v-if="previewUrl" @click="uploadImage()" :disabled="isUploading">
                                    {{ isUploading ? 'Tunggu Boss...' : 'Upload Foto' }}
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-gradient-to-r from-sky-200 via-sky-50 p-6 dark:from-slate-700">
                <p class="mb-4 text-2xl font-bold text-amber-500 dark:text-white">Rekap SKP jadi PDF</p>

                <Button
                    @click="generatePdf(selectedMonth, selectedYear)"
                    :disabled="isGenerating"
                    class="mb-2 me-2 rounded-md bg-gradient-to-br from-pink-500 to-orange-400 px-5 py-2 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-800"
                >
                    {{ isGenerating ? 'Monggo di enteni, suwe BOSS...' : 'Rekap SKP' }}
                    <LoaderCircle v-if="isGenerating" class="h-5 w-5 animate-spin" />
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
