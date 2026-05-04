import { Head, Link } from '@inertiajs/react';
import { PageHeader, StatusBadge, money } from '@/components/gold/shared';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

export default function Dashboard({ stats, recentPurchases = [], recentSales = [], recentInventory = [] }: any) {
    const cards = [
        ['Barang tersedia', stats?.availableItems], ['Barang terjual', stats?.soldItems], ['Transaksi pembelian', stats?.purchaseTransactions], ['Transaksi penjualan', stats?.salesTransactions], ['Nilai pembelian', money(stats?.purchaseValue)], ['Nilai penjualan', money(stats?.salesValue)], ['Estimasi profit', money(stats?.estimatedProfit)],
    ];
    return <>
        <Head title="Dashboard" />
        <div className="space-y-6 p-4">
            <PageHeader title="Dashboard" />
            <div className="flex flex-wrap gap-2"><Button asChild><Link href="/purchases/create">Create Purchase</Link></Button><Button asChild variant="secondary"><Link href="/sales/create">Create Sale</Link></Button><Button asChild variant="outline"><Link href="/inventory">View Inventory</Link></Button></div>
            <div className="grid gap-4 md:grid-cols-4">{cards.map(([label, value]) => <Card key={label}><CardHeader className="pb-2"><CardTitle className="text-sm text-muted-foreground">{label}</CardTitle></CardHeader><CardContent className="text-2xl font-semibold">{value ?? 0}</CardContent></Card>)}</div>
            <div className="grid gap-4 lg:grid-cols-3"><Mini title="Recent Purchases" rows={recentPurchases} number="purchase_number" /><Mini title="Recent Sales" rows={recentSales} number="sales_number" /><Mini title="Recent Inventory" rows={recentInventory} number="sku" /></div>
        </div>
    </>;
}
function Mini({ title, rows, number }: any) { return <Card><CardHeader><CardTitle>{title}</CardTitle></CardHeader><CardContent className="space-y-3">{rows.map((r: any) => <div key={r.id} className="flex items-center justify-between border-b pb-2 text-sm"><span>{r[number]}</span><StatusBadge status={r.status} /></div>)}</CardContent></Card>; }
