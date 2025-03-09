<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
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
    users: User[]
}>();
const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
const masuk = (name: string, pass: string) => {

    form.username = name
    form.password = pass

    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">

        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="username">Username</Label>
                    <Input id="username" type="text" required autofocus :tabindex="1" autocomplete="username"
                        v-model="form.username" placeholder="username" />
                    <InputError :message="form.errors.username" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm"
                            :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input id="password" type="password" required :tabindex="2" autocomplete="current-password"
                        v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between" :tabindex="3">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Log in
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>
            </div>
        </form>
    </AuthBase>
    <div>
        <h1 class="text-2xl font-bold mb-4">User List</h1>
        <table class="border-collapse border border-gray-400 w-full">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 px-4 py-2">ID</th>
                    <th class="border border-gray-400 px-4 py-2">Name</th>
                    <th class="border border-gray-400 px-4 py-2">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in props.users" :key="user.id" class="hover:bg-gray-100">
                    <td class="border border-gray-400 px-4 py-2">{{ user.id }} </td>
                    <td class="border border-gray-400 px-4 py-2">{{ user.username }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ user.NIP }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        <Button @click="masuk(user.username, user.NIP)" type="submit" class="mt-4 w-full" :tabindex="4"
                            :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Log in
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
