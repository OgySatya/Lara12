<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Wellcome" />
    <div class="h-screen w-full bg-[url('/storage/seloaji.jpg')] bg-cover bg-center">
        <section>
            <div class="mx-auto max-w-screen-xl px-4 py-4 text-center lg:py-8">
                <div class="absolute bottom-8 left-1/2 inline-flex -translate-x-1/2 rounded-xl border-2 border-white/20 bg-white/10 bg-opacity-50">
                    <Link :href="route('login')" class="rounded-l-xl px-6 py-2 text-xl font-bold text-white shadow-md transition hover:bg-white/20"
                        >Masuk
                    </Link>
                    <Link :href="route('register')" class="rounded-r-xl px-6 py-2 text-xl font-bold text-white shadow-md transition hover:bg-white/20"
                        >Daftar
                    </Link>
                </div>
            </div>
        </section>
    </div>
</template>
