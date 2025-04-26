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
        <div class="flex justify-between items-center">
            <p class="text-xl font-bold ">{{ currentTime }}</p>
            <Link :href="route('login')">
            <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium text-white">Kembali</span>
            </Link>
        </div>

        <main class="grid">
            <div>
                <h1 class="mb-4 text-center text-2xl font-bold text-amber-700 dark:text-white">Daftar Pegawai ya Absen
                    hari ini</h1>
                <section class="flex w-max justify-center gap-5">
                    <table v-if="props.staff.length > 0" class="border-2 w-fit text-center rounded-sm">
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
                                <td class="border p-2">
                                    <select @change="(event) => newShift(event, data.id)"
                                        class="w-fit rounded border p-2 bg-background" v-model="data.shift">
                                        <option value="1">Shift 1</option>
                                        <option value="2">Shift 2</option>
                                    </select>
                                </td>
                                <td class="border p-2">
                                    <button class="w-fit rounded-sm bg-red-500 px-2 pt-1 text-white"
                                        @click="batal(data.id)">Gak Jadi</button>
                                </td>
                            </tr>
                            <tr class="bg-red-500 text-white text-center">
                                <td></td>
                                <td>Gagal Absen</td>
                                <td>{{ failed }} Orang</td>
                                <td class="border p-2">
                                    <Link :href="route('active')"
                                        class="bg-gray-100 text-gray-800 p-1 rounded-md font-semibold  hover:text-blue-500 ">

                                    <span>Ulangi Absen</span>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mx-auto text-center">
                        <br />
                        <Link :href="route('active')"
                            class="mx-auto mt-5 rounded-xl border-2 border-stone-600 px-5 py-2 font-medium hover:bg-gray-400 hover:text-slate-100 ">

                        <span>Absen
                            Manual</span>
                        </Link>
                        <br />
                        <p class="mt-6 mb-3 text-xl font-bold">Tambah Absen</p>
                        <select @change="newAbsen" class="w-fit rounded border p-2 bg-background" v-model="form.id"
                            placeholder="Pilih Pegawai">
                            <option value="0" disabled selected hidden>Pilih Pegawai :</option>
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
