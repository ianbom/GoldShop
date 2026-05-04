import { Head, useForm } from '@inertiajs/react';
import { PageHeader } from '@/components/gold/shared';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

export default function SellerForm({ seller }: any) {
    const form = useForm({ name: seller?.name ?? '', nik: seller?.nik ?? '', phone: seller?.phone ?? '', address: seller?.address ?? '', notes: seller?.notes ?? '', ktp_photo: null as File | null, _method: seller ? 'put' : undefined });
    const submit = (e: React.FormEvent) => { e.preventDefault(); form.post(seller ? `/sellers/${seller.id}` : '/sellers'); };
    return <><Head title={seller ? 'Edit Seller' : 'Create Seller'} /><form onSubmit={submit} className="space-y-4 p-4"><PageHeader title={seller ? 'Edit Seller' : 'Create Seller'} /><Field label="Name"><Input value={form.data.name} onChange={e => form.setData('name', e.target.value)} /></Field><Field label="NIK"><Input value={form.data.nik} onChange={e => form.setData('nik', e.target.value)} /></Field><Field label="Phone"><Input value={form.data.phone} onChange={e => form.setData('phone', e.target.value)} /></Field><Field label="Address"><textarea className="min-h-24 w-full rounded-md border bg-background p-2" value={form.data.address} onChange={e => form.setData('address', e.target.value)} /></Field><Field label="KTP Photo"><Input type="file" onChange={e => form.setData('ktp_photo', e.target.files?.[0] ?? null)} /></Field><Field label="Notes"><textarea className="min-h-24 w-full rounded-md border bg-background p-2" value={form.data.notes} onChange={e => form.setData('notes', e.target.value)} /></Field><Button disabled={form.processing}>Save</Button></form></>;
}
function Field({ label, children }: any) { return <div className="max-w-xl space-y-2"><Label>{label}</Label>{children}</div>; }
