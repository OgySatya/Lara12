<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-3xl">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="mb-1 flex size-20 items-center justify-center rounded-md lg:size-32">
                        <AppLogoIcon class="fill-current text-[var(--foreground)] dark:text-white" />
                    </div>
                    <span class="sr-only">{{ title }}</span>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-white">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
