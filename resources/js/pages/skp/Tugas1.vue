<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { defineProps } from 'vue';
import { User } from 'lucide-vue-next';
import { useForm } from "@inertiajs/vue3";
import axios from 'axios';

interface Data {
    name: any[];
    target: object
}
interface User {
    id: number;
    username: string;
}

const props = defineProps<{
    tugas: Data[];
    user: User[]
}>();
const data = props.tugas.target;
const jabatan = props.tugas.jabatan.name;
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: jabatan,
        href: 'tugas1',
    },
];

console.log(props.tugas)
console.log(props.user)
const GITHUB_USERNAME = "OgySatya";
const GITHUB_REPO = "seloaji";
const GITHUB_BRANCH = "main";
const GITHUB_ACCESS_TOKEN = "";
const GITHUB_API_URL = `https://api.github.com/repos/${GITHUB_USERNAME}/${GITHUB_REPO}/contents/Foto/`;

const image = ref<File | null>(null);
const previewUrl = ref<string[]>([]);
const uploadedImageUrl = ref<string | null>(null);
const isUploading = ref(false);

const onFileChange = (event: Event, index: number) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        image.value = target.files[0];
        previewUrl.value[index] = URL.createObjectURL(target.files[0]);
    }
};

const uploadImage = async (id: number, slug: string) => {
    if (!image.value) {
        alert("Please select an image first!");
        return;
    }

    isUploading.value = true;
    const reader = new FileReader();
    reader.onload = async () => {
        const base64Image = (reader.result as string).split(",")[1];
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
                        Accept: "application/vnd.github.v3+json",
                    },
                }
            );

            uploadedImageUrl.value = response.data.content.download_url;
            form.link = response.data.content.download_url
            form.user_id = props.user.id;
            form.target_id = id;
            form.post(route('upload'), {
                onFinish: () => form.reset(),
            });
        } catch (error) {
            console.error("Upload failed:", error);
        } finally {
            isUploading.value = false;
        }
    };

    reader.readAsDataURL(image.value);
};

const form = useForm({
    link: '',
    user_id: 0,
    target_id: 0,
});


// Handle file upload
// const uploadImage = (job: number, slug: string) => {
//     form.username = props.user.use/     form.user_id = props.user.id;
//     form.target_id = job;
//     form.slug = slug;
//     form.post(route('upload'), {
//         onFinish: () => form.reset(),
//     });
// };
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="mx-auto font-bold underline underline-offset-4">{{ props.tugas.name }}</h1>
            <div>
                <div v-for="(job, index) in data" :key="job.id">
                    <div class="border border-gray-400 px-4 py-2 hover:bg-gray-100">{{ index + 1 }}. {{ job.name }}
                    </div>
                    <div class="grid grid-cols-2 gap-4 my-4">
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
                            <button @click="uploadImage(job.id, job.slug)" :disabled="isUploading"
                                class="bg-blue-500 text-white px-4 py-2 mt-2 rounded-lg hover:bg-blue-700">
                                {{ isUploading ? "Uploading..." : "Upload to GitHub" }}
                            </button>

                            <!-- Uploaded Image URL -->
                            <div v-if="uploadedImageUrl" class="mt-2">
                                <p>Uploaded Image:</p>
                                <a :href="uploadedImageUrl" target="_blank" class="text-blue-500 underline">{{
                                    uploadedImageUrl }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>
