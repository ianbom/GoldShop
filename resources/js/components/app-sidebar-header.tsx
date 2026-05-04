import { Breadcrumbs } from '@/components/breadcrumbs';
import { Input } from '@/components/ui/input';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { Bell, Search } from 'lucide-react';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';

export function AppSidebarHeader({
    breadcrumbs = [],
}: {
    breadcrumbs?: BreadcrumbItemType[];
}) {
    return (
        <header className="sticky top-0 z-10 flex h-18 shrink-0 items-center justify-between gap-4 border-b border-border/60 bg-background/82 px-4 backdrop-blur-xl transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-14 md:px-6">
            <div className="flex items-center gap-2">
                <SidebarTrigger className="-ml-1" />
                <Breadcrumbs breadcrumbs={breadcrumbs} />
            </div>
            <div className="hidden flex-1 items-center justify-end gap-3 md:flex">
                <div className="relative w-full max-w-sm">
                    <Search className="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input className="h-10 rounded-full bg-card/80 pl-9" placeholder="Search transactions, SKU, seller..." />
                </div>
                <button className="relative inline-flex size-10 items-center justify-center rounded-full border border-border/70 bg-card/80 text-muted-foreground shadow-sm transition-colors hover:bg-accent/50 hover:text-foreground">
                    <Bell className="size-4" />
                    <span className="absolute right-2.5 top-2.5 size-2 rounded-full bg-primary" />
                </button>
            </div>
        </header>
    );
}
