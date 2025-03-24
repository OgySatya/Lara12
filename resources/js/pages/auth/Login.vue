<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { defineProps } from 'vue';

interface User {
    id: number;
    username: string;
    NIP: string;
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
        <span
            class="mx-auto bg-red-100 text-red-800 font-medium me-2 px-5 py-2 rounded-sm dark:bg-red-900 dark:text-red-300">Anyar</span>
        </Link>
        <div>
            <h1 class="mb-4 text-2xl font-bold">Group A</h1>
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">ID</th>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in props.users" :key="user.id" class="hover:bg-gray-100">
                        <td class="border border-gray-400 px-4 py-2">{{ user.id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.username }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full"
                                :tabindex="4" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Log in
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Link :href="route('register')">
        <span
            class="mx-auto bg-red-100 text-red-800 font-medium me-2 px-5 py-2 rounded-sm dark:bg-red-900 dark:text-red-300">Anyar</span>
        </Link>
    </AuthBase>
</template>
