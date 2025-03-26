<script setup lang="ts">
import { ref } from "vue";
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const rencanaAksi = ref<{ name: string; subJobs: { name: string }[] }[]>([
    {
        name: '',
        subJobs: [{ name: '' }]
    }
]);
const addRencanaAksi = () => {
    rencanaAksi.value.push({
        name: '',
        subJobs: [{ name: '' }],
    });

};
const addSubjobs = (index: number) => {
    rencanaAksi.value[index].subJobs.push({ name: '' });

};
const form = useForm({
    jabatan: '',
    slug: '',
    rencanaAksi: [] as { name: string, subJobs: { name: string }[] }[],
});

const submit = () => {
    form.rencanaAksi = rencanaAksi.value;
    console.log(form.rencanaAksi);
    form.post(route('newjob'), {
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
                    <Label class="text-lg font-semibold" for="name">NAMA JABATAN ANYAR:</Label>
                    <Input class="ring-2 ring-offset-2" id="name" type="text" required autofocus v-model="form.jabatan"
                        placeholder="Kates Entah" />
                </div>
                <div class="flex gap-2">
                    <p class="text-sm font-semibold" for="name">Nama pendek jabatan : </p>
                    <Input class="ring-2 ring-offset-2" id="name" type="text" required autofocus v-model="form.slug"
                        placeholder="contoh : Lalin" />
                </div>
                <ul v-for="(job, index) in rencanaAksi || []">
                    <li class="grid gap-2 ring-2 ring-offset-2 rounded-md p-4">
                        <div class="grid gap-2">
                            <Label class="text-center underline" for="username">RENCANA AKSI {{ index + 1 }}</Label>
                            <Input class="w-full" id="username" type="text" v-model="rencanaAksi[index].name"
                                placeholder="mangan turu" />
                        </div>
                        <p class="text-sm">Sub Tugas :</p>
                        <div v-for="(subJob, subIndex) in rencanaAksi[index].subJobs || []">

                            <div class="flex gap-2">
                                <label class="my-auto">{{ subIndex + 1 }}</label><Input id="NIP" type="text"
                                    v-model="rencanaAksi[index].subJobs[subIndex].name" placeholder="ngopi" />
                            </div>
                        </div>
                        <button type="button" class="bg-lime-400 w-fit mx-auto px-3 py-1 rounded-md mt-4 text-white"
                            @click="addSubjobs(index)">Tambah
                            Tugas</button>
                    </li>
                </ul>
                <button type="button" class="bg-teal-400 py-1 rounded-md mt-2 text-white" @click="addRencanaAksi">Tambah
                    Rencana
                    Aksi</button>
                <button type="submit"
                    class="m-4 p-1 rounded-full from-rose-500 via-lime-500 to-teal-500 bg-gradient-to-r">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    <span
                        class="block text-black px-4 py-2 font-semibold rounded-full bg-white hover:bg-transparent hover:text-white transition">Buat
                        Jabatan Baru</span>
                </button>
            </div>
            <div class="text-center text-sm text-muted-foreground">

                <TextLink :href="route('register')" class="underline underline-offset-4" :tabindex="6">Kembali Buat
                    Pegawai</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
