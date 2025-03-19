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
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/13/Direktorat_Jenderal_Perhubungan_Darat.png" />
</template>
