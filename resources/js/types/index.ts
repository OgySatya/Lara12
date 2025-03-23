import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}
export interface Data {
    name: string;
    tugas: Job[];
    target: Job[];
    id: number;
    jabatan: { name: string };
}
export interface Job {
    id: number;
    name: string;
    slug: string;
    laporan: string[];
}

export interface SharedData extends PageProps {
    name: string;
    jobList: Data;
    auth: Auth;
}

export interface User {
    id: number;
    name: string;
    username: string;
    NIP: number;
    job: number;
    jabatan_id: number;
    group: string;
    avatar?: string;
 
}

export type BreadcrumbItemType = BreadcrumbItem;
