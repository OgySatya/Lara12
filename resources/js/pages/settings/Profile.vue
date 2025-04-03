<script setup lang="ts">
import { TransitionRoot } from '@headlessui/vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

const props = defineProps<{
    jabatan: { name: string; id: number }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;
console.log(user);

const form = useForm({
    id: user.id,
    name: user.name,
    username: user.username,
    NIP: user.NIP,
    jabatan: user.jabatan_id,
    group: user.group,
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Rubah Data Pegawai" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                            placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="username">User Name</Label>
                        <Input id="username" type="username" class="mt-1 block w-full" v-model="form.username" required
                            autocomplete="username" placeholder="username" />
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="NIP">NIP</Label>
                        <Input id="NIP" type="NIP" class="mt-1 block w-full" v-model="form.NIP" required
                            autocomplete="NIP" placeholder="NIP" />
                        <InputError class="mt-2" :message="form.errors.NIP" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">Jabatan</Label>
                        <select v-model="form.jabatan" :tabindex="3" id="jabatan" name="jabatan"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                            <option v-for="job in props.jabatan" :value="job.id">{{ job.name }}</option>
                        </select>
                        <InputError :message="form.errors.jabatan" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="group">Group</Label>
                        <select v-model="form.group" :tabindex="4" id="group" name="group"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                            <option value="A">Group A</option>
                            <option value="B">Group B</option>
                            <option value="C">Group C</option>
                            <option value="Admin">Group Admin</option>
                        </select>
                        <InputError :message="form.errors.group" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                            enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                            <p class="text-sm text-neutral-600">Saved.</p>
                        </TransitionRoot>
                    </div>
                </form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
