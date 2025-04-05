<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Wellcome" />
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-3 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link v-if="$page.props.auth.user" :href="route('job')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                Masuk
                </Link>
            </nav>
        </header>
        <section class="bg-white dark:bg-gray-900">
            <div class="py-4 px-4 mx-auto max-w-screen-xl text-center lg:py-8">
                <img src="https://hubdat.dephub.go.id/media/original_images/Black_White_Elegant_Monogram_Initial_Name_Logo-removebg-preview.png"
                    alt="">
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Ubur Ubur Ikan Lele</h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Login
                    dulu ya le</p>
                <div class="flex flex-col gap-4 sm:flex-row sm:justify-center sm:space-y-1">
                    <Link :href="route('login')"
                        class="inline-flex justify-center items-center py-3 px-8 text-lg font-medium text-center text-white rounded-lg bg-sky-500 hover:bg-blue-500 ">
                    Log In
                    </Link>
                    <Link :href="route('register')"
                        class="inline-flex justify-center items-center py-3 px-8 text-lg font-medium text-center text-white rounded-lg bg-lime-500 hover:bg-green-500 ">
                    Gae Pagawai Anyar
                    </Link>

                </div>
            </div>
        </section>
    </div>

</template>
