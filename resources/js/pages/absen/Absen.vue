<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Absen',
        href: '/settings/absen',
    },
];
interface Absen {
    id: number;
    nip: number;
    shift: number;
    tanggal: string;
    pagi: boolean;
    malam: boolean;
    status: number;
}

const props = defineProps<{
    users: { absen: Absen[]; name: string };
}>();
console.log(props.users.absen);
const date = ref<string[]>(props.users.absen.map((user) => user.tanggal));

const form = useForm({
    tanggal: '',
    absenId: -1,
    pagi: false as boolean,
    malam: false as boolean,
    shift: 0,
});

const submit = (index: number, id: number, status: number, pagi: boolean, malam: boolean) => {
    if (status) {
        form.absenId = id;
        form.patch(route('absen.revoke'));
    } else {
        form.tanggal = date.value[index];
        form.shift = props.users.absen[index].shift;
        form.absenId = id;
        form.pagi = pagi;
        form.malam = malam;
        form.patch(route('absen.update'));
    }
};

function onDateChange(index: number) {
    console.log('Date changed to:', date.value[index]);
}
const pagi = ref<boolean>(true);
console.log('pgi: ' + pagi.value);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Absen" />
        <main class="p-5">
            <h1 class="mb-6 mt-4 text-center text-2xl font-bold">{{ users.name }}</h1>
            <table class="mx-auto w-1/2 border text-center md:mx-0">
                <thead>
                    <tr class="bg-amber-300 dark:bg-gray-800">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Shift</th>
                        <th class="border p-2">Waktu</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.absen" class="hover:bg-gray-100 dark:hover:bg-stone-600">
                        <td class="border p-2">{{ index + 1 }}</td>
                        <td class="border p-2">
                            <input
                                class="rounded-sm p-2 dark:bg-slate-500"
                                type="date"
                                v-model="date[index]"
                                @change="onDateChange(index)"
                                id="date"
                            />
                        </td>
                        <td class="border p-2">
                            <div v-if="!user.status" class="space-y-2">
                                <div class="flex cursor-pointer items-center space-x-3">
                                    <input
                                        type="radio"
                                        id="shift1"
                                        value="1"
                                        v-model="users.absen[index].shift"
                                        class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500"
                                    />
                                    <label for="shift1">Shift 1</label>
                                </div>

                                <div class="flex cursor-pointer items-center space-x-3">
                                    <input
                                        type="radio"
                                        id="shift2"
                                        value="2"
                                        v-model="users.absen[index].shift"
                                        class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-500"
                                    />
                                    <label for="shift2">Shift 2</label>
                                </div>
                            </div>
                            <div v-else class="flex items-center justify-center space-x-2">
                                <p class="font-bold">Shift {{ users.absen[index].shift }}</p>
                                <LoaderCircle class="h-4 w-4 animate-spin" />
                            </div>
                        </td>
                        <td class="grid gap-2 border p-2">
                            <div class="flex cursor-pointer items-center space-x-3">
                                <input
                                    :disabled="user.status === 1"
                                    type="checkbox"
                                    v-model="users.absen[index].pagi"
                                    :true-value="1"
                                    :false-value="0"
                                />
                                <label>Pagi</label>
                            </div>
                            <div class="flex cursor-pointer items-center space-x-3">
                                <input
                                    :disabled="user.status === 1"
                                    type="checkbox"
                                    v-model="users.absen[index].malam"
                                    :true-value="1"
                                    :false-value="0"
                                />
                                <label>Malam</label>
                            </div>
                        </td>
                        <td class="justify-center border p-2 text-center text-white">
                            <div class="w-fit rounded-sm p-2" :class="user.status ? 'animate-pulse bg-blue-500' : 'bg-gray-500'">
                                <span>{{ user.status ? 'Proses...' : 'Standby' }}</span>
                            </div>
                        </td>
                        <td class="border p-2">
                            <button
                                @click="submit(index, user.id, user.status, user.pagi, user.malam)"
                                :class="user.status ? 'bg-red-500' : 'bg-emerald-500'"
                                class="w-fit rounded-sm p-2 text-white"
                            >
                                {{ user.status ? 'Berhenti' : 'Jalankan' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </AppLayout>
</template>
