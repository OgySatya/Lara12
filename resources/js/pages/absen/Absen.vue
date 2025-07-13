<script setup lang="ts">
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    user: { name: string; id: number; awal: number; status: number };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Absen settings',
        href: '/settings/absen',
    },
];


const update = (event: Event) => {
    const value = (event.target as HTMLSelectElement).value;
    router.patch(route('absen.update'), {
        Id: props.user.id,
        awal: value,
    });
};
const onToggle = (event: Event) => {
    const checked = (event.target as HTMLInputElement).checked;
    router.patch(route('absen.edit'), {
        absenId: props.user.id,
        status: checked ? 1 : 0,
    });
};
const currentYear: number = new Date().getFullYear();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Profile settings" />

        <main class="m-5">
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Setting Absen" description="Sangat Rahasia ya Boss!!" />
                {{ props.user.name }}
            </div>

            <div class="mt-5 ">
                <div class="grid">
                    <p>Cobalah di ingat boss</p>
                    <p>Pajenengan Masuk Shift apa pada tanggal 01 Januari {{ currentYear }}</p>
                    <div class="flex items-center">
                        <select @change="update" v-model="props.user.awal" name="shift"
                            class="p-1 border-2 mr-3 w-fit rounded-sm mt-2">
                            <option value="Admin">Admin</option>
                            <option value="1">Shift Pagi Pertama</option>
                            <option value="2">Shift Pagi Kedua</option>
                            <option value="3">Shift Malam Pertama</option>
                            <option value="4">Shift Malam Kedua</option>
                            <option value="5">Lepas Jaga</option>
                            <option value="0">Libur</option>
                        </select>
                    </div>

                    <div class="flex my-3">
                        <p class="mr-4">Status Absen Otomatis :</p>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="props.user.status === 1" class="sr-only peer"
                                @change="onToggle">
                            <div
                                class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ props.user.status
                                ===
                                1 ? 'Active' : 'Standby' }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </main>
    </AppLayout>

</template>
