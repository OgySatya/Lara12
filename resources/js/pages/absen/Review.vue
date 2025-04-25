<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

interface User {
    id: number;
    name: string;
    status: number;
    shift: number;
    tanggal: Date;
    NIP: string;
    user: {
        id: number;
        name: string;
    };
}

const props = defineProps<{
    staff: User[];
    users: { name: string; id: number }[];
}>();

const form = useForm({
    id: -1,
});
const newAbsen = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const selectedId = Number(target.value);

    if (selectedId) {
        router.patch(route('absen.update'), { id: selectedId });
    }
};

const batal = (id: number) => {
    router.patch(route('absen.revoke'), {
        absenId: id,
    });
};
console.log(props.staff);
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
        <Head title="Absen Pegawi" />
        <Link :href="route('login')">
            <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium text-white">Kembali</span>
        </Link>
        <main class="grid">
            <div class="mb-4 text-center">
                <p class="text-xl font-bold">{{ currentTime }}</p>
            </div>
            <div v-if="props.staff.length > 0">
                <h1 class="mb-4 text-center text-2xl font-bold text-amber-300 dark:text-white">Daftar Pegawai ya Absen hari ini</h1>
                <section class="flex w-full justify-center">
                    <table class="w-fit border">
                        <thead>
                            <tr class="bg-amber-300 dark:bg-gray-800">
                                <th class="border p-2">No</th>
                                <th class="border p-2">Name</th>
                                <th class="border p-2">Shift</th>
                                <th class="border p-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in props.staff" :key="data.id">
                                <td class="border p-2">{{ index + 1 }}</td>
                                <td class="border p-2">{{ data.user.name }}</td>
                                <td class="border p-2">Shift {{ data.shift }}</td>
                                <td class="border p-2">
                                    <button class="w-fit rounded-sm bg-red-500 px-2 pt-1 text-white" @click="batal(data.id)">Gak Jadi</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mx-auto text-center">
                        <Link :href="route('active')">
                            <span class="mx-auto mt-5 rounded-xl bg-amber-300 px-5 py-2 font-medium text-white">Absen Manual</span>
                        </Link>
                        <br />
                        <p class="my-3 text-xl font-bold">Tambah Absen</p>
                        <select @change="newAbsen" class="w-fit rounded border p-2" v-model="form.id">
                            <option :value="-1">Pilih Pegawai</option>
                            <option v-for="option in users" :key="option.id" :value="option.id">
                                {{ option.name }}
                            </option>
                        </select>
                    </div>
                </section>
            </div>
        </main>
    </AuthBase>
</template>
