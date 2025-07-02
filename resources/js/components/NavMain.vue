<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { CalendarRange } from 'lucide-vue-next';

defineProps<{
    items: NavItem[];
    tugas: string;
}>();

const page = usePage<SharedData>();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>{{ tugas }}</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton class="h-fit" as-child :is-active="item.href === page.url">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span class="text-xs">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
            <SidebarMenuButton class="h-fit" as-child :is-active="page.url === '/rekap'">
                <Link href="/rekap">
                    <component :is="CalendarRange" />
                    <span class="font-bold">Rekap Absen Skemaraja</span>
                </Link>
            </SidebarMenuButton>
        </SidebarMenu>
    </SidebarGroup>
</template>
