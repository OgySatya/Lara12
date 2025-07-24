<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

interface User {
    id: number;
    name: string;
    status: number;
}

const props = defineProps<{
    dayOfyear: number;
    interval: number;
    shift1: User[];
    shift2a: User[];
    shift2b: User[];
    libur: User[];
    admin: User[];
    failed: number;
}>();

const batal = (id: number) => {
    router.patch(route('absen.edit'), {
        absenId: id,
        status: 0,
    });
};
const absen = (id: number) => {
    router.patch(route('absen.edit'), {
        absenId: id,
        status: 1,
    });
};

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
    <main class="mx-auto mt-5 grid w-fit p-5">
        <Head title="Absen Pegawai" />

        <h1 class="mb-4 text-center text-2xl font-bold text-amber-700 dark:text-white">Daftar Pegawai ya Absen hari ini</h1>
        <div class="grid lg:flex">
            <p class="text-xl font-bold">{{ currentTime }}</p>
            <p class="ml-2 font-normal text-gray-500">( Day of Year : {{ props.dayOfyear }} ) - ( Interval : {{ props.interval }} )</p>
        </div>
        <aside class="my-2 grid w-max border-2 lg:flex">
            <div class="lg:border-r-2">
                <h2 class="border-b-2 bg-cyan-400 p-2 text-center text-xl font-bold">SHIFT 1</h2>
                <div class="grid p-2" v-for="(data, index) in props.shift1" :key="data.id">
                    <div class="flex items-center justify-between">
                        <p :class="data.status == 0 ? 'text-gray-500 line-through' : ''">{{ index + 1 }}. {{ data.name }}</p>
                        <button
                            v-if="data.status == 0"
                            @click="absen(data.id)"
                            class="ml-2 rounded-lg bg-lime-500 p-1 text-sm font-bold text-white hover:bg-lime-600"
                        >
                            Absen
                        </button>
                        <button v-else @click="batal(data.id)" class="ml-2 rounded-lg bg-red-500 p-1 text-sm font-bold text-white hover:bg-red-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            <div class="lg:border-r-2">
                <h2 class="border-b-2 bg-cyan-400 p-2 text-center text-xl font-bold">SHIFT 2 PERTAMA</h2>
                <p class="p-2 text-center text-gray-500" v-if="props.shift2a.length < 1">[Kosong]</p>
                <div class="grid p-2" v-for="(data, index) in props.shift2a" :key="data.id">
                    <div class="flex items-center justify-between">
                        <p :class="data.status == 0 ? 'text-gray-500 line-through' : ''">{{ index + 1 }}. {{ data.name }}</p>
                        <button
                            v-if="data.status == 0"
                            @click="absen(data.id)"
                            class="ml-2 rounded-lg bg-lime-500 p-1 text-sm font-bold text-white hover:bg-lime-600"
                        >
                            Absen
                        </button>
                        <button v-else @click="batal(data.id)" class="ml-2 rounded-lg bg-red-500 p-1 text-sm font-bold text-white hover:bg-red-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            <div class="lg:border-r-2">
                <h2 class="border-b-2 bg-cyan-400 p-2 text-center text-xl font-bold">SHIFT 2 KEDUA</h2>
                <p class="p-2 text-center text-gray-500" v-if="props.shift2b.length < 1">[Kosong]</p>
                <div class="grid p-2" v-for="(data, index) in props.shift2b" :key="data.id">
                    <div class="flex items-center justify-between">
                        <p :class="data.status == 0 ? 'text-gray-500 line-through' : ''">{{ index + 1 }}. {{ data.name }}</p>
                        <button
                            v-if="data.status == 0"
                            @click="absen(data.id)"
                            class="ml-2 rounded-lg bg-lime-500 p-1 text-sm font-bold text-white hover:bg-lime-600"
                        >
                            Absen
                        </button>
                        <button v-else @click="batal(data.id)" class="ml-2 rounded-lg bg-red-500 p-1 text-sm font-bold text-white hover:bg-red-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            <div class="lg:border-r-2">
                <h2 class="border-b-2 bg-cyan-400 p-2 text-center text-xl font-bold">LEPAS JAGA</h2>
                <p class="p-2 text-center text-gray-500" v-if="props.libur.length < 1">[Liburan]</p>
                <div class="grid p-2" v-for="(data, index) in props.libur" :key="data.id">
                    <div class="flex items-center justify-between">
                        <p :class="data.status == 0 ? 'text-gray-500 line-through' : ''">{{ index + 1 }}. {{ data.name }}</p>
                        <button
                            v-if="data.status == 0"
                            @click="absen(data.id)"
                            class="ml-2 rounded-lg bg-lime-500 p-1 text-sm font-bold text-white hover:bg-lime-600"
                        >
                            Absen
                        </button>
                        <button v-else @click="batal(data.id)" class="ml-2 rounded-lg bg-red-500 p-1 text-sm font-bold text-white hover:bg-red-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            <div class="">
                <h2 class="border-b-2 bg-cyan-400 p-2 text-center text-xl font-bold">ADMIN</h2>
                <div class="grid p-2" v-for="(data, index) in props.admin" :key="data.id">
                    <div class="flex items-center justify-between">
                        <p :class="data.status == 0 ? 'text-gray-500 line-through' : ''">{{ index + 1 }}. {{ data.name }}</p>
                        <button
                            v-if="data.status == 0"
                            @click="absen(data.id)"
                            class="ml-2 rounded-lg bg-lime-500 p-1 text-sm font-bold text-white hover:bg-lime-600"
                        >
                            Absen
                        </button>
                        <button v-else @click="batal(data.id)" class="ml-2 rounded-lg bg-red-500 p-1 text-sm font-bold text-white hover:bg-red-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <div class="mb-5 grid items-center justify-between space-y-1 lg:flex">
            <h2 class="text rounded-sm border-2 border-red-700 px-4 py-2">Gagal Absen : {{ failed }} Orang</h2>
            <Link :href="route('retry')" class="rounded-sm bg-yellow-400 px-4 py-2 text-center font-bold text-white hover:bg-yellow-600">
                Ulangi Absen
            </Link>
            <Link :href="route('clear')" class="rounded-sm bg-red-500 px-4 py-2 text-center font-bold text-white hover:bg-red-800">
                Bersihkan Absen
            </Link>
        </div>
        <Link :href="route('home')">
            <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium text-white">Kembali</span>
        </Link>
        <div class="mt-5 rounded-sm border-2 border-orange-500 bg-yellow-200 p-5">
            <h3 class="text-center text-lg font-bold text-orange-700">
                Absen ini hanya untuk membatu Pegawai yang lupa absen
                <br />
                Terkadang Pembantu Absen ini tidak berjalan dengan baik
                <br />
                Kadang - kadang juga Ngak Berguna
                <br />
                Jadi jangan terlalu mengandalkan Pembantu Absen ini, tetaplah Absen Mandiri ya BOSS!!
            </h3>
        </div>
    </main>
</template>
