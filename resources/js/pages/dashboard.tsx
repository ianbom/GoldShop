import { Head, Link } from '@inertiajs/react';
import { MetricCard, PageHeader, PageShell, StatusBadge, Surface, money } from '@/components/gold/shared';
import { Button } from '@/components/ui/button';
import { Package, Receipt, ShoppingBag, TrendingUp } from 'lucide-react';

export default function Dashboard({ stats, recentPurchases = [], recentSales = [], recentInventory = [] }: any) {
    const cards = [['Inventory tersedia', stats?.availableItems, 'Siap dijual'], ['Inventory terjual', stats?.soldItems, 'Barang keluar'], ['Transaksi pembelian', stats?.purchaseTransactions, 'Akuisisi seller'], ['Transaksi penjualan', stats?.salesTransactions, 'Checkout selesai'], ['Nilai pembelian', money(stats?.purchaseValue), 'Modal tercatat'], ['Nilai penjualan', money(stats?.salesValue), 'Revenue tercatat'], ['Estimasi profit', money(stats?.estimatedProfit), 'Selisih jual-beli']];
    return <>
        <Head title="Dashboard" />
        <PageShell>
            <PageHeader eyebrow="Operations overview" title="Gold store command center" description="Pantau stok, transaksi pembelian, penjualan, nilai modal, dan estimasi profit dari satu layar kerja.">
                <Button asChild><Link href="/purchases/create"><Receipt /> Create Purchase</Link></Button><Button asChild variant="secondary"><Link href="/sales/create"><ShoppingBag /> Create Sale</Link></Button><Button asChild variant="outline"><Link href="/inventory"><Package /> Inventory</Link></Button>
            </PageHeader>
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">{cards.map(([label, value, hint]) => <MetricCard key={label} label={String(label)} value={value ?? 0} hint={String(hint)} />)}</div>
            <Surface className="grid gap-5 lg:grid-cols-[1.4fr_0.8fr]">
                <div>
                    <div className="mb-4 flex items-center gap-3"><div className="rounded-xl bg-primary/12 p-2 text-primary"><TrendingUp className="size-5" /></div><div><h2 className="text-lg font-semibold">Executive snapshot</h2><p className="text-sm text-muted-foreground">Ringkasan nilai operasional hari ini.</p></div></div>
                    <div className="grid gap-3 sm:grid-cols-3"><MetricCard label="Purchase value" value={money(stats?.purchaseValue)} /><MetricCard label="Sales value" value={money(stats?.salesValue)} /><MetricCard label="Estimated profit" value={money(stats?.estimatedProfit)} /></div>
                </div>
                <div className="rounded-2xl bg-gradient-to-br from-primary/14 to-accent/35 p-5"><p className="text-xs font-semibold uppercase tracking-[0.16em] text-primary">Quick actions</p><div className="mt-4 grid gap-2"><Button asChild><Link href="/purchases/create">Record seller purchase</Link></Button><Button asChild variant="secondary"><Link href="/sales/create">Complete customer sale</Link></Button><Button asChild variant="outline"><Link href="/reports/purchases">Open reports</Link></Button></div></div>
            </Surface>
            <div className="grid gap-4 lg:grid-cols-3"><Mini title="Recent purchases" rows={recentPurchases} number="purchase_number" /><Mini title="Recent sales" rows={recentSales} number="sales_number" /><Mini title="Recent inventory" rows={recentInventory} number="sku" /></div>
        </PageShell>
    </>;
}
function Mini({ title, rows, number }: any) { return <Surface><h2 className="text-base font-semibold">{title}</h2><div className="mt-4 space-y-2">{rows.length ? rows.map((r: any) => <div key={r.id} className="flex items-center justify-between rounded-xl border border-border/70 bg-background/45 px-3 py-2.5 text-sm"><span className="font-medium">{r[number]}</span><StatusBadge status={r.status} /></div>) : <div className="rounded-xl border border-dashed p-5 text-center text-sm text-muted-foreground">No records yet</div>}</div></Surface>; }
