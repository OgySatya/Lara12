<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Wellcome" />
    <div class="h-screen w-full bg-[url('/storage/terminal.png')] bg-cover bg-center">
        <section>
            <div class="mx-auto max-w-screen-xl px-4 py-4 text-center lg:py-8">
                <div class="absolute bottom-8 left-1/2 flex -translate-x-1/2 transform flex-col gap-4 sm:flex-row sm:space-y-1">
                    <Link
                        :href="route('login')"
                        class="inline-flex items-center justify-center rounded-lg bg-sky-500 px-8 py-3 text-center text-lg font-medium text-white hover:bg-blue-500"
                    >
                        Log In
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-flex items-center justify-center rounded-lg bg-lime-500 px-8 py-3 text-center text-lg font-medium text-white hover:bg-green-500"
                    >
                        Gae Pagawai Anyar
                    </Link>
                </div>
            </div>
        </section>
    </div>
</template>
