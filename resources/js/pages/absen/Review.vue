<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

interface User {
    id: number;
    status: number;
    shift: number;
    pagi: string;
    malam: string;
    tanggal: Date;
    NIP: string;
    user: {
        id: number;
        name: string;
        group: string;
    };
}

const props = defineProps<{
    shift1: User[];
    shift2: User[];
    admin: User[];
    failed: number;
}>();
console.log(props.failed);
const form = useForm({
    id: 0,
});
const newAbsen = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const selectedId = Number(target.value);

    if (selectedId) {
        router.patch(route('absen.update'), { id: selectedId });
    }
};
const newShift = (event: Event, id: number) => {
    const target = event.target as HTMLSelectElement;
    const value = Number(target.value);
    router.patch(route('absen.update'), { absenId: id, shift: value });
};

const batal = (id: number) => {
    router.patch(route('absen.revoke'), {
        absenId: id,
    });
};
console.log(props.shift1);
console.log(props.shift2);
console.log(props.admin);

const currentTime = ref(formatDateTime(new Date()));

function formatDateTime(date: Date): string {
    return new Intl.DateTimeFormat('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    }).format(date);
}

onMounted(() => {
    setInterval(() => {
        currentTime.value = formatDateTime(new Date());
    }, 1000);
});
</script>

<template>
    <AuthBase title="DAFTAR ABSEN PEGAWAI" description="Silahkan cek daftar pegawai yang absen pada hari ini">
        <Head title="Absen Pegawai" />
        <div class="flex items-center justify-between">
            <p class="text-xl font-bold">{{ currentTime }}</p>
            <Link :href="route('login')">
                <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium text-white">Kembali</span>
            </Link>
        </div>

        <main class="grid">
            <div>
                <h1 class="mb-4 text-center text-2xl font-bold text-amber-700 dark:text-white">Daftar Pegawai ya Absen hari ini</h1>
                    <table class="w-max rounded-sm border-2 text-center mx-auto">
                        <thead>
                            <tr class="bg-amber-300 dark:bg-gray-800">
                                <th class="border p-2">Shift 1</th>
                                <th class="border p-2">Shift 2</th>
                                <th class="border p-2">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2" v-if="props.shift1.length < 1">0</td>
                                <template v-else>
                                    <td class="border p-2" v-for="(data, index) in props.shift1" :key="data.id">
                                        <p class="flex items-center">{{ index + 1 }}. {{ data.user.name }} 
                                            <button @click="batal(data.id)" class="rounded-lg bg-red-500 p-1 text-sm font-bold ml-2">Batal</button>
                                        </p>
                                    </td>
                                </template>
                                <td class="border p-2" v-if="props.shift2.length < 1">0</td>
                                <template v-else>
                                    <td class="border p-2 " v-for="(data, index) in props.shift2" :key="data.id">
                                        <p class="flex items-center">
                                            {{ index + 1 }}. {{ data.user.name }}
                                            <div class=" ml-2 flex gap-2">
                                            <span v-if="data.pagi === '1'" class="rounded-lg bg-sky-300 p-1 text-sm font-bold">Pagi</span>
                                            <span v-if="data.malam === '1'" class="rounded-lg bg-amber-600 p-1 text-sm font-bold">Malam</span>
                                            <button @click="batal(data.id)" class="rounded-lg bg-red-500 p-1 text-sm font-bold">Batal</button>
                                            </div>
                                        </p>
                                    </td>
                                </template>
                                <td class="border p-2" v-if="props.admin.length < 1">0</td>
                                <template v-else>
                                    <td class="border p-2" v-for="(data, index) in props.admin" :key="data.id">
                                          <p class="flex items-center">{{ index + 1 }}. {{ data.user.name }} 
                                            <button @click="batal(data.id)" class="rounded-lg bg-red-500 p-1 text-sm font-bold ml-2">Batal</button>
                                        </p>
                                    </td>
                                </template>
                            </tr>
                            <tr class="bg-red-500 text-center text-white">
                                <td>Gagal Absen</td>
                                <td class="border-l">{{ failed }} Orang</td>
                                <td class="border p-2">
                                    <Link :href="route('active')" class="rounded-md bg-gray-100 p-1 font-semibold text-gray-800 hover:text-blue-500">
                                        <span>Ulangi Absen</span>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </main>
    </AuthBase>
</template>
