import { Head, useForm } from '@inertiajs/react';
import { PageHeader, Surface, money } from '@/components/gold/shared';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const emptyItem = {
    item_name: '',
    item_type: '',
    gold_carat: '',
    weight_gram: 0,
    price_per_gram: 0,
    deduction_amount: 0,
    condition: '',
    description: '',
    product_photo: null,
};

export default function Create({ sellers }: any) {
    const form = useForm<any>({
        seller_id: '',
        seller: { name: '', nik: '', phone: '', address: '', notes: '' },
        transaction_date: new Date().toISOString().slice(0, 16),
        payment_method: 'cash',
        deduction_amount: 0,
        status: 'completed',
        notes: '',
        items: [{ ...emptyItem }],
    });

    const subtotal = form.data.items.reduce((sum: number, item: any) => {
        return (
            sum +
            Math.max(
                Number(item.weight_gram) * Number(item.price_per_gram) -
                    Number(item.deduction_amount || 0),
                0,
            )
        );
    }, 0);
    const total = Math.max(
        subtotal - Number(form.data.deduction_amount || 0),
        0,
    );

    const setItem = (idx: number, key: string, value: any) => {
        form.setData(
            'items',
            form.data.items.map((item: any, itemIdx: number) =>
                itemIdx === idx ? { ...item, [key]: value } : item,
            ),
        );
    };

    const removeItem = (idx: number) => {
        if (form.data.items.length === 1) {
            return;
        }

        form.setData(
            'items',
            form.data.items.filter(
                (_: any, itemIdx: number) => itemIdx !== idx,
            ),
        );
    };

    return (
        <>
            <Head title="Create Purchase" />
            <form
                className="mx-auto grid w-full max-w-[1480px] gap-6 p-4 md:p-6 xl:grid-cols-[1fr_360px]"
                onSubmit={(event) => {
                    event.preventDefault();
                    form.post('/purchases');
                }}
            >
                <div className="space-y-6 xl:col-span-2"><PageHeader eyebrow="Purchase workflow" title="Create Purchase" description="Catat seller, upload identitas, input barang emas, dan hitung total pembelian dalam alur kerja premium." /></div>

                <div className="space-y-6">
                <InstructionCard />

                {Object.keys(form.errors).length > 0 && (
                    <div className="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        Periksa kembali data yang ditandai. Nama seller wajib
                        diisi jika memilih New seller, dan minimal 1 barang
                        wajib lengkap.
                    </div>
                )}

                <Surface className="space-y-4">
                    <SectionHeader
                        title="1. Data Seller"
                        description="Pilih seller lama atau isi nama seller baru. Jika memilih seller lama, kolom nama seller baru boleh dikosongkan."
                    />
                    <div className="grid gap-4 md:grid-cols-2">
                        <Field
                            label="Seller Terdaftar"
                            help="Gunakan jika penjual sudah pernah dicatat."
                        >
                            <select
                                className="h-10 rounded-md border bg-background px-3 text-sm"
                                value={form.data.seller_id}
                                onChange={(event) =>
                                    form.setData(
                                        'seller_id',
                                        event.target.value,
                                    )
                                }
                            >
                                <option value="">
                                    New seller / seller baru
                                </option>
                                {sellers.map((seller: any) => (
                                    <option key={seller.id} value={seller.id}>
                                        {seller.name}{' '}
                                        {seller.nik ? `- ${seller.nik}` : ''}
                                    </option>
                                ))}
                            </select>
                        </Field>
                        <Field
                            label="Nama Seller Baru"
                            help="Wajib diisi jika tidak memilih seller terdaftar."
                        >
                            <Input
                                value={form.data.seller.name}
                                onChange={(event) =>
                                    form.setData('seller', {
                                        ...form.data.seller,
                                        name: event.target.value,
                                    })
                                }
                            />
                        </Field>
                        <Field
                            label="NIK Seller Baru"
                            help="Opsional, maksimal 30 karakter."
                        >
                            <Input
                                value={form.data.seller.nik}
                                onChange={(event) =>
                                    form.setData('seller', {
                                        ...form.data.seller,
                                        nik: event.target.value,
                                    })
                                }
                            />
                        </Field>
                        <Field
                            label="Nomor HP Seller Baru"
                            help="Opsional, untuk kontak ulang."
                        >
                            <Input
                                value={form.data.seller.phone}
                                onChange={(event) =>
                                    form.setData('seller', {
                                        ...form.data.seller,
                                        phone: event.target.value,
                                    })
                                }
                            />
                        </Field>
                    </div>
                </Surface>

                <Surface className="space-y-4">
                    <SectionHeader
                        title="2. Data Transaksi"
                        description="Tanggal transaksi dan metode pembayaran dipakai untuk nomor transaksi, laporan, dan dokumen."
                    />
                    <div className="grid gap-4 md:grid-cols-4">
                        <Field
                            label="Tanggal Transaksi"
                            help="Tanggal pembelian emas dari seller."
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
                            help="Pilih metode pembayaran toko ke seller."
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
                            label="Potongan Transaksi"
                            help="Potongan total setelah semua harga barang dijumlahkan."
                        >
                            <Input
                                type="number"
                                min="0"
                                value={form.data.deduction_amount}
                                onChange={(event) =>
                                    form.setData(
                                        'deduction_amount',
                                        Number(event.target.value),
                                    )
                                }
                            />
                        </Field>
                        <Field
                            label="Status Simpan"
                            help="Completed langsung membuat inventory. Draft belum masuk inventory."
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
                        title="3. Data Barang Emas"
                        description="Isi minimal 1 barang. Sistem menghitung estimated price = berat x harga/gram, lalu final price = estimated price - potongan barang."
                    />
                    <div className="space-y-4">
                        {form.data.items.map((item: any, idx: number) => {
                            const estimatedPrice =
                                Number(item.weight_gram) *
                                Number(item.price_per_gram);
                            const finalPrice = Math.max(
                                estimatedPrice -
                                    Number(item.deduction_amount || 0),
                                0,
                            );

                            return (
                                <div
                                    key={idx}
                                    className="space-y-4 rounded-2xl border border-border/70 bg-background/45 p-4 shadow-sm"
                                >
                                    <div className="flex items-center justify-between gap-3">
                                        <div>
                                            <h3 className="font-medium">
                                                Barang #{idx + 1}
                                            </h3>
                                            <p className="text-sm text-muted-foreground">
                                                Lengkapi nama, berat, dan harga
                                                per gram. Foto produk opsional.
                                            </p>
                                        </div>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            size="sm"
                                            disabled={
                                                form.data.items.length === 1
                                            }
                                            onClick={() => removeItem(idx)}
                                        >
                                            Remove
                                        </Button>
                                    </div>
                                    <div className="grid gap-4 md:grid-cols-4">
                                        <Field
                                            label="Nama Barang"
                                            help="Contoh: Cincin solitaire, kalung rantai."
                                        >
                                            <Input
                                                value={item.item_name}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'item_name',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Jenis Barang"
                                            help="Contoh: cincin, kalung, gelang, anting."
                                        >
                                            <Input
                                                value={item.item_type}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'item_type',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Karat Emas"
                                            help="Contoh: 18, 22, 24."
                                        >
                                            <Input
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                value={item.gold_carat}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'gold_carat',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Berat Gram"
                                            help="Wajib lebih besar dari 0."
                                        >
                                            <Input
                                                type="number"
                                                min="0"
                                                step="0.001"
                                                value={item.weight_gram}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'weight_gram',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Harga Per Gram"
                                            help="Harga beli toko per gram."
                                        >
                                            <Input
                                                type="number"
                                                min="0"
                                                value={item.price_per_gram}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'price_per_gram',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Potongan Barang"
                                            help="Potongan khusus untuk barang ini."
                                        >
                                            <Input
                                                type="number"
                                                min="0"
                                                value={item.deduction_amount}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'deduction_amount',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Kondisi Barang"
                                            help="Contoh: baik, gores ringan, rusak."
                                        >
                                            <Input
                                                value={item.condition}
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'condition',
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                        </Field>
                                        <Field
                                            label="Foto Produk"
                                            help="Opsional. Format jpg/png/webp maksimal 5MB."
                                        >
                                            <Input
                                                type="file"
                                                accept="image/png,image/jpeg,image/webp"
                                                onChange={(event) =>
                                                    setItem(
                                                        idx,
                                                        'product_photo',
                                                        event.target
                                                            .files?.[0] ?? null,
                                                    )
                                                }
                                            />
                                        </Field>
                                    </div>
                                     <div className="grid gap-3 rounded-xl bg-card/80 p-3 text-sm md:grid-cols-3">
                                        <div>
                                            <span className="text-muted-foreground">
                                                Estimated Price
                                            </span>
                                            <div className="font-semibold">
                                                {money(estimatedPrice)}
                                            </div>
                                        </div>
                                        <div>
                                            <span className="text-muted-foreground">
                                                Potongan Barang
                                            </span>
                                            <div className="font-semibold">
                                                {money(item.deduction_amount)}
                                            </div>
                                        </div>
                                        <div>
                                            <span className="text-muted-foreground">
                                                Final Price
                                            </span>
                                            <div className="font-semibold">
                                                {money(finalPrice)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                    <Button
                        type="button"
                        variant="secondary"
                        onClick={() =>
                            form.setData('items', [
                                ...form.data.items,
                                { ...emptyItem },
                            ])
                        }
                    >
                        Add Item
                    </Button>
                </Surface>
                </div>

                <aside className="space-y-4 xl:sticky xl:top-24 xl:self-start"><Surface className="space-y-4">
                    <SectionHeader
                        title="4. Ringkasan"
                        description="Pastikan total sudah benar sebelum menyimpan transaksi."
                    />
                    <div className="mt-4 grid gap-3 text-sm md:grid-cols-3">
                        <Summary
                            label="Subtotal Barang"
                            value={money(subtotal)}
                        />
                        <Summary
                            label="Potongan Transaksi"
                            value={money(form.data.deduction_amount)}
                        />
                        <Summary label="Total Pembelian" value={money(total)} />
                    </div>
                </Surface>

                <Surface className="flex flex-col gap-3">
                    <Button
                        type="submit"
                        disabled={form.processing}
                        onClick={() => form.setData('status', 'completed')}
                    >
                        Complete Transaction
                    </Button>
                    <Button
                        type="submit"
                        variant="secondary"
                        disabled={form.processing}
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
        <div className="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
            <h2 className="font-semibold">Instruksi pengisian</h2>
            <ol className="mt-2 list-decimal space-y-1 pl-5">
                <li>
                    Pilih seller terdaftar, atau kosongkan pilihan lalu isi nama
                    seller baru.
                </li>
                <li>
                    Isi tanggal transaksi, metode pembayaran, dan potongan
                    transaksi jika ada.
                </li>
                <li>
                    Tambahkan minimal satu barang emas, lalu isi berat gram dan
                    harga per gram.
                </li>
                <li>
                    Gunakan Complete Transaction jika barang langsung masuk
                    inventory.
                </li>
                <li>
                    Gunakan Save Draft jika data belum final dan belum boleh
                    masuk inventory.
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
