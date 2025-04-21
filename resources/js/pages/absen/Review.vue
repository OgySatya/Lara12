<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, defineProps, ref, onMounted } from 'vue';

interface User {
    id: number;
    name: string;
    status: number;
    tanggal: Date
    NIP: string;
    user: {
        id: number;
        name: string;
    };
}

const props = defineProps<{
    staff: User[];
}>();

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
            <div class="text-center mb-4">
                <p class="text-xl font-bold"> {{ currentTime }}</p>
            </div>
            <div v-if="props.staff.length > 0">
                <h1 class="mb-4 text-2xl font-bold text-center text-amber-300 dark:text-white">Daftar Pegawai </h1>
                <section class="flex justify-center w-full">
                    <table class="w-fit border">
                        <thead>
                            <tr class="bg-amber-300 dark:bg-gray-800">
                                <th class="border p-2">No</th>
                                <th class="border p-2">Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in props.staff" :key="data.id">
                                <td class="border p-2">{{ index + 1 }}</td>
                                <td class="border p-2">{{ data.user.name }}</td>

                            </tr>
                        </tbody>
                    </table>
                    <div>
                    </div>
                </section>
            </div>
            <Link :href="route('active')">
            <span class="mx-auto rounded-sm bg-amber-300 px-5 py-2 font-medium text-white mt-5">Absen Manual</span>
            </Link>

        </main>
    </AuthBase>
</template>
