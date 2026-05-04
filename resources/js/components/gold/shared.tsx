import { Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Search, UploadCloud } from 'lucide-react';
import { cn } from '@/lib/utils';
import type React from 'react';

export function money(value: number | string | null | undefined) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(Number(value ?? 0));
}

export function StatusBadge({ status }: { status: string }) {
    const map: Record<string, string> = {
        available: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        completed: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        signed: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        sold: 'border-slate-200 bg-slate-100 text-slate-700',
        generated: 'border-sky-200 bg-sky-50 text-sky-700',
        printed: 'border-violet-200 bg-violet-50 text-violet-700',
        draft: 'border-amber-200 bg-amber-50 text-amber-800',
        cancelled: 'border-red-200 bg-red-50 text-red-700',
        lost: 'border-red-200 bg-red-50 text-red-700',
        damaged: 'border-orange-200 bg-orange-50 text-orange-700',
        melted: 'border-zinc-200 bg-zinc-100 text-zinc-700',
    };
    return <span className={`inline-flex items-center rounded-md border px-2.5 py-1 text-xs font-semibold capitalize tracking-[-0.01em] ${map[status] ?? 'border-border bg-muted text-muted-foreground'}`}>{status}</span>;
}

export function PageHeader({ title, eyebrow, description, actionHref, actionLabel, children }: { title: string; eyebrow?: string; description?: string; actionHref?: string; actionLabel?: string; children?: React.ReactNode }) {
    return (
        <div className="relative overflow-hidden rounded-2xl border border-white/70 bg-card/86 p-5 shadow-[0_22px_70px_-42px_rgba(87,62,20,0.55)] backdrop-blur md:p-6">
            <div className="pointer-events-none absolute right-0 top-0 h-32 w-32 rounded-full bg-primary/10 blur-3xl" />
            <div className="relative flex flex-wrap items-center justify-between gap-4">
                <div className="max-w-3xl space-y-1">
                    {eyebrow ? <p className="text-xs font-semibold uppercase tracking-[0.18em] text-primary">{eyebrow}</p> : null}
                    <h1 className="text-2xl font-semibold tracking-tight text-foreground md:text-3xl">{title}</h1>
                    {description ? <p className="max-w-2xl text-sm leading-6 text-muted-foreground">{description}</p> : null}
                </div>
                <div className="flex flex-wrap items-center gap-2">
                    {children}
                    {actionHref && actionLabel ? <Button asChild><Link href={actionHref}>{actionLabel}</Link></Button> : null}
                </div>
            </div>
        </div>
    );
}

export function SearchBar({ defaultValue, placeholder = 'Search...' }: { defaultValue?: string; placeholder?: string }) {
    return <div className="relative"><Search className="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" /><Input className="pl-9" defaultValue={defaultValue} placeholder={placeholder} onKeyDown={(event) => { if (event.key === 'Enter') router.get(location.pathname, { search: event.currentTarget.value }, { preserveState: true }); }} /></div>;
}

export function PageShell({ children, className }: { children: React.ReactNode; className?: string }) {
    return <main className={cn('mx-auto w-full max-w-[1480px] space-y-6 p-4 md:p-6', className)}>{children}</main>;
}

export function Surface({ children, className }: { children: React.ReactNode; className?: string }) {
    return <section className={cn('rounded-2xl border border-white/70 bg-card/88 p-4 shadow-[0_18px_55px_-40px_rgba(87,62,20,0.5)] backdrop-blur md:p-5', className)}>{children}</section>;
}

export function DataTable({ children, className }: { children: React.ReactNode; className?: string }) {
    return <div className={cn('overflow-hidden rounded-2xl border border-border/70 bg-card/90 shadow-[0_18px_55px_-42px_rgba(87,62,20,0.45)]', className)}><div className="overflow-x-auto"><table className="w-full text-sm [&_th]:bg-muted/55 [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:text-xs [&_th]:font-semibold [&_th]:uppercase [&_th]:tracking-[0.12em] [&_th]:text-muted-foreground [&_td]:border-t [&_td]:border-border/70 [&_td]:px-4 [&_td]:py-3.5 [&_tbody_tr]:transition-colors [&_tbody_tr:hover]:bg-accent/25">{children}</table></div></div>;
}

export function MetricCard({ label, value, hint }: { label: string; value: React.ReactNode; hint?: string }) {
    return <div className="rounded-2xl border border-white/70 bg-card/90 p-4 shadow-[0_18px_55px_-42px_rgba(87,62,20,0.45)]"><p className="text-xs font-semibold uppercase tracking-[0.13em] text-muted-foreground">{label}</p><div className="mt-2 text-2xl font-semibold tracking-tight text-foreground">{value}</div>{hint ? <p className="mt-2 text-xs text-muted-foreground">{hint}</p> : null}</div>;
}

export function UploadBox({ label, hint }: { label: string; hint?: string }) {
    return <div className="flex min-h-28 flex-col items-center justify-center rounded-xl border border-dashed border-primary/35 bg-accent/20 p-4 text-center"><UploadCloud className="mb-2 size-5 text-primary" /><p className="text-sm font-semibold">{label}</p>{hint ? <p className="mt-1 text-xs text-muted-foreground">{hint}</p> : null}</div>;
}
