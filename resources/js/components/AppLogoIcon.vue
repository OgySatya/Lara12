<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img src="https://images.seeklogo.com/logo-png/43/1/ditjen-kemenhub-logo-png_seeklogo-431056.png">
</template>
