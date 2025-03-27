<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, defineProps } from 'vue';

interface User {
    id: number;
    name: string;
    username: string;
    NIP: string;
    group: string;
}

const props = defineProps<{
    status?: string;
    canResetPassword: boolean;
    users: User[];
}>();
const form = useForm({
    username: '',
    password: '',
    remember: false,
});
const groupA = computed<User[]>(() => {
    return props.users.filter((user) => user.group === 'A');
});
const groupB = computed<User[]>(() => {
    return props.users.filter((user) => user.group === 'B');
});
const groupC = computed<User[]>(() => {
    return props.users.filter((user) => user.group === 'C');
});
const groupAdmin = computed<User[]>(() => {
    return props.users.filter((user) => user.group === 'Admin');
});

const masuk = (name: string, pass: string) => {
    form.username = name;
    form.password = pass;

    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Log in dulu" description="Silahkan Pilih Pegawagi">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <Link :href="route('register')">
            <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium">Buat Pegawai Anyar</span>
        </Link>
        <main class="grid grid-cols-1 md:grid-cols-2"></main>
        <div v-if="groupA.length > 0">
            <h1 class="mb-4 text-2xl font-bold">Group A</h1>
            <table class="w-max border-collapse border border-gray-400 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">ID</th>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in groupA" :key="user.id" class="hover:bg-gray-100">
                        <td class="border border-gray-400 px-4 py-2">{{ user.id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="groupB.length > 0">
            <h1 class="mb-4 text-2xl font-bold">Group B</h1>
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">ID</th>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in groupB" :key="user.id" class="hover:bg-gray-100">
                        <td class="border border-gray-400 px-4 py-2">{{ user.id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="groupC.length > 0">
            <h1 class="mb-4 text-2xl font-bold">Group C</h1>
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">ID</th>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in groupC" :key="user.id" class="hover:bg-gray-100">
                        <td class="border border-gray-400 px-4 py-2">{{ user.id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="groupAdmin.length > 0">
            <h1 class="mb-4 text-2xl font-bold">Group Admin</h1>
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">ID</th>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in groupAdmin" :key="user.id" class="hover:bg-gray-100">
                        <td class="border border-gray-400 px-4 py-2">{{ user.id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthBase>
</template>
