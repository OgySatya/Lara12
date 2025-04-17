<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Absen {
    id: number;
    nip: number;
    tanggal: Date;
    status: number;
}

const props = defineProps<{
    users: { absen: Absen[]; name: string };
}>();

const date = ref<Date[]>(props.users.absen.map((user) => new Date(user.tanggal)));

const form = useForm({
    tanggal: '',
    absenId: -1,
});

const submit = (index: number, id: number) => {
    form.tanggal = date.value[index].toISOString().split('T')[0]; // 'YYYY-MM-DD'
    form.absenId = id;
    form.patch(route('absen.update'));
};
</script>
<template>
    <main>
        <h1 class="mb-4 text-center text-2xl font-bold text-amber-300 dark:text-white">{{ users.name }}</h1>
        <table class="border">
            <thead>
                <tr class="bg-amber-300 dark:bg-gray-800">
                    <th class="border p-2">No</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users.absen" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                    <td class="border p-2">{{ index + 1 }}</td>
                    <td class="border p-2"><Input type="date" v-model="date[index]" /></td>
                    <td class="border p-2">{{ user.status }}</td>
                    <td class="border p-2">
                        <Button @click="submit(index, user.id)" class="d dark:text-whiteark:bg-gray-800 w-full bg-amber-300"> Active </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</template>
