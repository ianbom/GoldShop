import { Head, useForm } from '@inertiajs/react';
import { PageHeader, Surface, money } from '@/components/gold/shared';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

export default function Create({ inventory }: any) {
    const form = useForm<any>({
        buyer_name: '',
        buyer_phone: '',
        transaction_date: new Date().toISOString().slice(0, 16),
        payment_method: 'cash',
        discount_amount: 0,
        status: 'completed',
        notes: '',
        items: [],
    });

    const addItem = (id: string) => {
        const item = inventory.find(
            (inventoryItem: any) => String(inventoryItem.id) === id,
        );

        if (
            !item ||
            form.data.items.some(
                (selected: any) => selected.inventory_item_id === item.id,
            )
        ) {
            return;
        }

        form.setData('items', [
            ...form.data.items,
            {
                inventory_item_id: item.id,
                sku: item.sku,
                item_name: item.item_name,
                gold_carat: item.gold_carat,
                weight_gram: item.weight_gram,
                selling_price: item.selling_price ?? 0,
                discount_amount: 0,
            },
        ]);
    };

    const setItem = (idx: number, key: string, value: any) => {
        form.setData(
            'items',
            form.data.items.map((item: any, itemIdx: number) =>
                itemIdx === idx ? { ...item, [key]: value } : item,
            ),
        );
    };

    const removeItem = (idx: number) => {
        form.setData(
            'items',
            form.data.items.filter(
                (_: any, itemIdx: number) => itemIdx !== idx,
            ),
        );
    };

    const subtotal = form.data.items.reduce((sum: number, item: any) => {
        return (
            sum +
            Math.max(
                Number(item.selling_price) - Number(item.discount_amount || 0),
                0,
            )
        );
    }, 0);
    const total = Math.max(
        subtotal - Number(form.data.discount_amount || 0),
        0,
    );

    return (
        <>
            <Head title="Create Sale" />
            <form
                className="mx-auto grid w-full max-w-[1480px] gap-6 p-4 md:p-6 xl:grid-cols-[1fr_360px]"
                onSubmit={(event) => {
                    event.preventDefault();
                    form.post('/sales');
                }}
            >
                <div className="space-y-6 xl:col-span-2"><PageHeader eyebrow="Sales workflow" title="Create Sale" description="Pilih inventory tersedia, atur harga jual, diskon, dan selesaikan transaksi penjualan dengan ringkasan otomatis." /></div>

                <div className="space-y-6"><InstructionCard />

                {Object.keys(form.errors).length > 0 && (
                    <div className="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        Periksa kembali data penjualan. Minimal 1 barang wajib
                        dipilih dan harga jual tidak boleh negatif.
                    </div>
                )}

                <Surface className="space-y-4">
                    <SectionHeader
                        title="1. Data Pembeli"
                        description="Isi identitas pembeli sederhana untuk tercatat pada transaksi dan invoice penjualan."
                    />
                    <div className="grid gap-4 md:grid-cols-2">
                        <Field
                            label="Nama Pembeli"
                            help="Opsional, tetapi disarankan untuk invoice."
                        >
                            <Input
                                value={form.data.buyer_name}
                                onChange={(event) =>
                                    form.setData(
                                        'buyer_name',
                                        event.target.value,
                                    )
                                }
                            />
                        </Field>
                        <Field
                            label="Nomor HP Pembeli"
                            help="Opsional, untuk kontak jika ada koreksi transaksi."
                        >
                            <Input
                                value={form.data.buyer_phone}
                                onChange={(event) =>
                                    form.setData(
                                        'buyer_phone',
                                        event.target.value,
                                    )
                                }
                            />
                        </Field>
                    </div>
                </Surface>

                <Surface className="space-y-4">
                    <SectionHeader
                        title="2. Data Transaksi"
                        description="Tanggal dan metode pembayaran dipakai untuk laporan serta dokumen penjualan."
                    />
                    <div className="grid gap-4 md:grid-cols-4">
                        <Field
                            label="Tanggal Transaksi"
                            help="Tanggal barang dijual kepada pembeli."
                        >
                            <Input
                                type="datetime-local"
                                value={form.data.transaction_date}
                                onChange={(event) =>
                                    form.setData(
                                        'transaction_date',
                                        event.target.value,
                                    )
                                }
                            />
                        </Field>
                        <Field
                            label="Metode Pembayaran"
                            help="Pilih cara pembayaran dari pembeli."
                        >
                            <select
                                className="h-10 rounded-md border bg-background px-3 text-sm"
                                value={form.data.payment_method}
                                onChange={(event) =>
                                    form.setData(
                                        'payment_method',
                                        event.target.value,
                                    )
                                }
                            >
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="qris">QRIS</option>
                                <option value="debit">Debit</option>
                                <option value="other">Other</option>
                            </select>
                        </Field>
                        <Field
                            label="Diskon Transaksi"
                            help="Diskon total setelah semua barang dijumlahkan."
                        >
                            <Input
                                type="number"
                                min="0"
                                value={form.data.discount_amount}
                                onChange={(event) =>
                                    form.setData(
                                        'discount_amount',
                                        Number(event.target.value),
                                    )
                                }
                            />
                        </Field>
                        <Field
                            label="Status Simpan"
                            help="Completed langsung mengubah barang menjadi sold. Draft belum mengubah stok."
                        >
                            <select
                                className="h-10 rounded-md border bg-background px-3 text-sm"
                                value={form.data.status}
                                onChange={(event) =>
                                    form.setData('status', event.target.value)
                                }
                            >
                                <option value="completed">Completed</option>
                                <option value="draft">Draft</option>
                            </select>
                        </Field>
                    </div>
                </Surface>

                <Surface className="space-y-4">
                    <SectionHeader
                        title="3. Pilih Barang Inventory"
                        description="Hanya barang berstatus available yang muncul. Barang yang sudah dipilih tidak akan ditambahkan dua kali."
                    />
                    <Field
                        label="Cari / Pilih Barang"
                        help="Pilih berdasarkan SKU, nama barang, karat, berat, dan harga jual."
                    >
                        <select
                            className="h-10 rounded-md border bg-background px-3 text-sm"
                            value=""
                            onChange={(event) => addItem(event.target.value)}
                        >
                            <option value="">Select inventory</option>
                            {inventory.map((item: any) => (
                                <option key={item.id} value={item.id}>
                                    {item.sku} - {item.item_name} -{' '}
                                    {item.gold_carat}K - {item.weight_gram}gr -{' '}
                                    {money(item.selling_price)}
                                </option>
                            ))}
                        </select>
                    </Field>

                    {form.data.items.length === 0 ? (
                        <div className="rounded-lg border border-dashed p-6 text-center text-sm text-muted-foreground">
                            Belum ada barang dipilih. Pilih barang inventory
                            untuk mulai transaksi.
                        </div>
                    ) : (
                        <div className="space-y-4">
                            {form.data.items.map((item: any, idx: number) => {
                                const finalPrice = Math.max(
                                    Number(item.selling_price) -
                                        Number(item.discount_amount || 0),
                                    0,
                                );

                                return (
                                    <div
                                        key={item.inventory_item_id}
                                         className="space-y-4 rounded-2xl border border-border/70 bg-background/45 p-4 shadow-sm"
                                    >
                                        <div className="flex items-center justify-between gap-3">
                                            <div>
                                                <h3 className="font-medium">
                                                    {item.sku} -{' '}
                                                    {item.item_name}
                                                </h3>
                                                <p className="text-sm text-muted-foreground">
                                                    {item.gold_carat}K,{' '}
                                                    {item.weight_gram} gram.
                                                    Pastikan harga jual dan
                                                    diskon sudah benar.
                                                </p>
                                            </div>
                                            <Button
                                                type="button"
                                                variant="outline"
                                                size="sm"
                                                onClick={() => removeItem(idx)}
                                            >
                                                Remove
                                            </Button>
                                        </div>
                                        <div className="grid gap-4 md:grid-cols-3">
                                            <Field
                                                label="Harga Jual"
                                                help="Harga jual barang ini kepada pembeli."
                                            >
                                                <Input
                                                    type="number"
                                                    min="0"
                                                    value={item.selling_price}
                                                    onChange={(event) =>
                                                        setItem(
                                                            idx,
                                                            'selling_price',
                                                            event.target.value,
                                                        )
                                                    }
                                                />
                                            </Field>
                                            <Field
                                                label="Diskon Barang"
                                                help="Diskon khusus untuk barang ini."
                                            >
                                                <Input
                                                    type="number"
                                                    min="0"
                                                    value={item.discount_amount}
                                                    onChange={(event) =>
                                                        setItem(
                                                            idx,
                                                            'discount_amount',
                                                            event.target.value,
                                                        )
                                                    }
                                                />
                                            </Field>
                                            <div className="rounded-md bg-background p-3 text-sm">
                                                <div className="text-muted-foreground">
                                                    Final Price
                                                </div>
                                                <div className="text-lg font-semibold">
                                                    {money(finalPrice)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </Surface></div>

                <aside className="space-y-4 xl:sticky xl:top-24 xl:self-start"><Surface className="space-y-4">
                    <SectionHeader
                        title="4. Ringkasan"
                        description="Pastikan total pembayaran sudah benar sebelum menyimpan transaksi."
                    />
                    <div className="mt-4 grid gap-3 text-sm md:grid-cols-3">
                        <Summary
                            label="Subtotal Barang"
                            value={money(subtotal)}
                        />
                        <Summary
                            label="Diskon Transaksi"
                            value={money(form.data.discount_amount)}
                        />
                        <Summary label="Total Penjualan" value={money(total)} />
                    </div>
                </Surface>

                <Surface className="flex flex-col gap-3">
                    <Button
                        type="submit"
                        disabled={
                            form.processing || form.data.items.length === 0
                        }
                        onClick={() => form.setData('status', 'completed')}
                    >
                        Complete Sale
                    </Button>
                    <Button
                        type="submit"
                        variant="secondary"
                        disabled={
                            form.processing || form.data.items.length === 0
                        }
                        onClick={() => form.setData('status', 'draft')}
                    >
                        Save Draft
                    </Button>
                </Surface></aside>
            </form>
        </>
    );
}

function InstructionCard() {
    return (
        <div className="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
            <h2 className="font-semibold">Instruksi pengisian</h2>
            <ol className="mt-2 list-decimal space-y-1 pl-5">
                <li>Isi nama dan nomor HP pembeli jika tersedia.</li>
                <li>Pilih tanggal transaksi dan metode pembayaran.</li>
                <li>
                    Pilih barang dari inventory. Hanya barang available yang
                    bisa dipilih.
                </li>
                <li>Ubah harga jual atau diskon barang jika diperlukan.</li>
                <li>
                    Gunakan Complete Sale untuk menandai barang menjadi sold.
                </li>
                <li>
                    Gunakan Save Draft jika transaksi belum final dan stok belum
                    boleh berubah.
                </li>
            </ol>
        </div>
    );
}

function SectionHeader({
    title,
    description,
}: {
    title: string;
    description: string;
}) {
    return (
        <div>
            <h2 className="text-lg font-semibold">{title}</h2>
            <p className="text-sm text-muted-foreground">{description}</p>
        </div>
    );
}

function Field({
    label,
    help,
    children,
}: {
    label: string;
    help?: string;
    children: React.ReactNode;
}) {
    return (
        <label className="space-y-2">
            <Label>{label}</Label>
            {children}
            {help ? (
                <p className="text-xs text-muted-foreground">{help}</p>
            ) : null}
        </label>
    );
}

function Summary({ label, value }: { label: string; value: string }) {
    return (
        <div className="rounded-md bg-muted/40 p-3">
            <div className="text-muted-foreground">{label}</div>
            <div className="text-lg font-semibold">{value}</div>
        </div>
    );
}
