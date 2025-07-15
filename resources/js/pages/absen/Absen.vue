<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';

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
                <HeadingSmall title="Setting Absen" :description="props.user.name" />
            </div>

            <div class="mt-5">
                <div class="grid">
                    <p>Cobalah di ingat boss</p>
                    <p>Pajenengan Masuk Shift apa pada tanggal 01 Januari {{ currentYear }}</p>
                    <div class="flex items-center">
                        <select @change="update" v-model="props.user.awal" name="shift" class="mr-3 mt-2 w-fit rounded-sm border-2 bg-background p-1">
                            <option value="Admin">Admin</option>
                            <option value="1">Shift Pagi Pertama</option>
                            <option value="2">Shift Pagi Kedua</option>
                            <option value="3">Shift Malam Pertama</option>
                            <option value="4">Shift Malam Kedua</option>
                            <option value="5">Lepas Jaga</option>
                            <option value="0">Libur</option>
                        </select>
                    </div>

                    <div class="my-3 flex">
                        <p class="mr-4">Status Absen Otomatis :</p>
                        <label class="inline-flex cursor-pointer items-center">
                            <input type="checkbox" :checked="props.user.status === 1" class="peer sr-only" @change="onToggle" />
                            <div
                                class="peer relative h-7 w-14 rounded-full bg-gray-200 after:absolute after:start-[4px] after:top-0.5 after:h-6 after:w-6 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full"
                            ></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{
                                props.user.status === 1 ? 'Active' : 'Standby'
                            }}</span>
                        </label>
                    </div>
                    <div class="w-fit rounded-lg border-2 border-red-500 bg-red-50 p-2">
                        <h3 class="font-bold text-red-500">
                            Mohon di jaga Rahasia ini, jangan sampai bocor ke pegawai lain ya BOSS !!
                            <br />
                            Jangan terlalu percaya dengan Aplikasi Absen ini
                            <br />
                            karena ini hanya sebuah aplikasi sederhana.
                            <br />
                            Kadang sering ERROR, dan Ngak GUNA
                        </h3>
                    </div>
                </div>
            </div>
        </main>
    </AppLayout>
</template>
