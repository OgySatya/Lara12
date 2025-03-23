<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
const props = defineProps<{
    jabatan: { name: string; id: number }[];
}>();
console.log(props.jabatan);
const form = useForm({
    name: '',
    username: '',
    NIP: '',
    jabatan: '',
    group: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AuthBase title="Buat Data Pegawai" description="Isi data dengan benar dan baik ojo ke susu">

        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Nama</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                        v-model="form.name" placeholder="Nama Lengkap" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="username">User Name</Label>
                    <Input id="username" type="text" required :tabindex="2" autocomplete="name" v-model="form.username"
                        placeholder="nama panggilan" />
                    <InputError :message="form.errors.username" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">NIP</Label>
                    <Input id="NIP" type="number" required :tabindex="2" v-model="form.NIP" placeholder="123456" />
                    <InputError :message="form.errors.NIP" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Jabatan</Label>
                    <select v-model="form.jabatan" :tabindex="3" id="jabatan" name="jabatan"
                        class="border border-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="job in props.jabatan" :value=job.id>{{ job.name }}</option>
                    </select>
                    <InputError :message="form.errors.jabatan" />
                </div>

                <div class="grid gap-2">
                    <Label for="group">Group</Label>
                    <select v-model="form.group" :tabindex="4" id="group" name="group"
                        class="border border-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value='A'>Group A</option>
                        <option value='B'>Group B</option>
                        <option value='C'>Group C</option>
                        <option value='Admin'>Group Admin</option>
                    </select>
                    <InputError :message="form.errors.group" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Buat Akun Anyar
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Kembali ke Login
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
