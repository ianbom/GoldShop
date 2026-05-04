import { Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

export function money(value: number | string | null | undefined) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(Number(value ?? 0));
}

export function StatusBadge({ status }: { status: string }) {
    const map: Record<string, string> = {
        available: 'bg-emerald-100 text-emerald-800',
        completed: 'bg-emerald-100 text-emerald-800',
        signed: 'bg-emerald-100 text-emerald-800',
        sold: 'bg-slate-200 text-slate-800',
        generated: 'bg-blue-100 text-blue-800',
        printed: 'bg-purple-100 text-purple-800',
        draft: 'bg-amber-100 text-amber-800',
        cancelled: 'bg-red-100 text-red-800',
        lost: 'bg-red-100 text-red-800',
        damaged: 'bg-orange-100 text-orange-800',
        melted: 'bg-zinc-100 text-zinc-800',
    };
    return <span className={`rounded-full px-2.5 py-1 text-xs font-medium ${map[status] ?? 'bg-muted text-muted-foreground'}`}>{status}</span>;
}

export function PageHeader({ title, actionHref, actionLabel }: { title: string; actionHref?: string; actionLabel?: string }) {
    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <h1 className="text-2xl font-semibold tracking-tight">{title}</h1>
            {actionHref && actionLabel ? <Button asChild><Link href={actionHref}>{actionLabel}</Link></Button> : null}
        </div>
    );
}

export function SearchBar({ defaultValue, placeholder = 'Search...' }: { defaultValue?: string; placeholder?: string }) {
    return <Input defaultValue={defaultValue} placeholder={placeholder} onKeyDown={(event) => { if (event.key === 'Enter') router.get(location.pathname, { search: event.currentTarget.value }, { preserveState: true }); }} />;
}
