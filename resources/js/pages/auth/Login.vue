<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, defineProps } from 'vue';

interface User {
    id: number;
    name: string;
    username: string;
    NIP: string;
    group: string;
}

const props = defineProps<{
    users: User[];
}>();
const form = useForm({
    username: '',
    password: '',
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
    <AuthBase title="Log in dulu" description="Silahkan Pilih Pegawai">
        <Head title="Log in" />
        <div class="flex justify-between">
            <Link :href="route('home')">
                <span class="mx-auto rounded-sm bg-sky-500 px-5 py-2 font-medium text-white">Kembali</span>
            </Link>
            <Link :href="route('register')">
                <span class="mx-auto rounded-sm bg-stone-500 px-5 py-2 font-medium text-white">Buat Pegawai Anyar</span>
            </Link>
        </div>
        <main class="mx-auto grid w-auto grid-cols-1 gap-8 md:grid-cols-2">
            <div v-if="groupA.length > 0">
                <h1 class="mb-4 text-center text-2xl font-bold text-amber-300 dark:text-white">Group A</h1>
                <table class="w-min border text-xs">
                    <thead>
                        <tr class="bg-amber-300 dark:bg-gray-800">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">NIP</th>
                            <th class="border p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in groupA" :key="user.id" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="border p-2">{{ index + 1 }}</td>
                            <td class="border p-2">{{ user.name }}</td>
                            <td class="border p-2">{{ user.NIP }}</td>
                            <td class="border p-2">
                                <Button
                                    @click="masuk(user.username, user.NIP)"
                                    type="submit"
                                    class="d dark:text-whiteark:bg-gray-800 w-full bg-amber-300"
                                >
                                    Log in
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="groupB.length > 0">
                <h1 class="mb-4 text-center text-2xl font-bold text-lime-300 dark:text-white">Group B</h1>
                <table class="w-min border text-xs">
                    <thead>
                        <tr class="bg-lime-300 dark:bg-gray-800">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">NIP</th>
                            <th class="border p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in groupB" :key="user.id" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="border p-2">{{ index + 1 }}</td>
                            <td class="border p-2">{{ user.name }}</td>
                            <td class="border p-2">{{ user.NIP }}</td>
                            <td class="border p-2">
                                <Button
                                    @click="masuk(user.username, user.NIP)"
                                    type="submit"
                                    class="da dark:text-whiterk:bg-gray-800 w-full bg-lime-300"
                                >
                                    Log in
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="groupC.length > 0">
                <h1 class="mb-4 text-center text-2xl font-bold text-teal-300 dark:text-white">Group C</h1>
                <table class="w-min border text-xs">
                    <thead>
                        <tr class="bg-teal-300 dark:bg-gray-800">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">NIP</th>
                            <th class="border p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in groupC" :key="user.id" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="border p-2">{{ index + 1 }}</td>
                            <td class="border p-2">{{ user.name }}</td>
                            <td class="border p-2">{{ user.NIP }}</td>
                            <td class="border p-2">
                                <Button
                                    @click="masuk(user.username, user.NIP)"
                                    type="submit"
                                    class="da dark:text-whiterk:bg-gray-800 w-full bg-teal-300"
                                >
                                    Log in
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="groupAdmin.length > 0">
                <h1 class="mb-4 text-center text-2xl font-bold text-fuchsia-300 dark:text-white">Group Admin</h1>
                <table class="w-min border text-xs">
                    <thead>
                        <tr class="bg-fuchsia-300 dark:bg-gray-800">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">NIP</th>
                            <th class="border p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in groupAdmin" :key="user.id" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="border p-2">{{ index + 1 }}</td>
                            <td class="border p-2">{{ user.name }}</td>
                            <td class="border p-2">{{ user.NIP }}</td>
                            <td class="border p-2">
                                <Button @click="masuk(user.username, user.NIP)" type="submit" class="w-full bg-fuchsia-300 dark:text-white">
                                    Log in
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </AuthBase>
</template>
