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
    <AuthBase title="Buat Tugas Rencana Aksi" description="Isi data dengan benar dan baik ojo ke susu">

        <Head title="New Job" />

        <form @submit.prevent="submit" class="flex flex-col gap-6 w-full">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Nama Jabatan</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                        v-model="form.name" placeholder="Kates Entah" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2 ring-2 ring-offset-2 rounded-md p-4">
                    <div class="grid gap-2">
                        <Label class="text-center underline" for="username">Rencana Aksi 1</Label>
                        <Input class="w-full" id="username" type="text" required :tabindex="2" autocomplete="name"
                            v-model="form.username" placeholder="nama panggilan" />
                        <InputError :message="form.errors.username" />
                    </div>
                    <p class="text-sm">Sub Tugas</p>
                    <div class="flex gap-2">
                        <label class="my-auto">1</label><Input id="NIP" type="number" required :tabindex="2"
                            v-model="form.NIP" placeholder="123456" />
                    </div>
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
