<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Tally1, Tally2, Tally3, Tally4 } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { usePage } from '@inertiajs/vue3';
import { type SharedData, type Job } from '@/types';


const page = usePage<SharedData>();
const jobList = page.props.jobList.tugas as Job[];
const jobName: string = page.props.jobList.name;

console.log(jobList);
const mainNavItems: NavItem[] = [
    {
        title: jobList[0].name,
        href: '/job?job=1',
        icon: Tally1,
    },
    {
        title: jobList[1].name,
        href: '/job?job=2',
        icon: Tally2,
    },
    {
        title: jobList[2].name,
        href: '/job?job=3',
        icon: Tally3,
    },
    {
        title: jobList[3].name,
        href: '/job?job=4',
        icon: Tally4,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('job')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" :job="jobName" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
