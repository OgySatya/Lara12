<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Absen',
        href: '/settings/absen',
    },
];
interface Absen {
    id: number;
    nip: number;
    tanggal: string;
    status: number;
}

const props = defineProps<{
    users: { absen: Absen[]; name: string };
    test: Absen[];
}>();
console.log(props.test)
const date = ref<string[]>(props.users.absen.map((user) => user.tanggal));

const form = useForm({
    tanggal: '',
    absenId: -1,
});

const submit = (index: number, id: number, status: number) => {
    if (status) {
        form.absenId = id;
        form.patch(route('absen.revoke'));
    } else {
        form.tanggal = date.value[index]
        form.absenId = id;
        form.patch(route('absen.update'));
    }

};


function onDateChange(index: number) {
    console.log('Date changed to:', date.value[index]);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Absen" />
        <main class="p-5">
            <h1 class="mb-6 mt-4 text-center text-2xl font-bold ">{{ users.name }}</h1>
            <table class="border w-1/2 text-center mx-auto md:mx-0">
                <thead>
                    <tr class="bg-amber-300 dark:bg-gray-800">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.absen" class="hover:bg-gray-100 dark:hover:bg-stone-600">
                        <td class="border p-2">{{ index + 1 }}</td>
                        <td class="border p-2">
                            <input class="dark:bg-slate-500 p-2 rounded-sm" type="date" v-model="date[index]"
                                @change="onDateChange(index)" id="date" />
                        </td>
                        <td class="border p-2 text-white">
                            <div class="p-2 rounded-sm flex  justify-center"
                                :class="user.status ? 'bg-blue-500' : 'bg-gray-500'">
                                <LoaderCircle v-if="user.status" class="h-5 w-5 mx-2 animate-spin" />
                                <span>{{ user.status ? 'Proses...' : 'Standby' }}</span>
                            </div>
                        </td>
                        <td class="border p-2">
                            <button @click="submit(index, user.id, user.status)"
                                :class="user.status ? 'bg-red-500' : ' bg-emerald-500'"
                                class="text-white p-2 rounded-sm"> {{ user.status ? 'Berhenti' :
                                    'Jalankan' }} </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </AppLayout>
</template>
