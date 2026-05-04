import { Head } from '@inertiajs/react';
import { PageHeader, StatusBadge } from '@/components/gold/shared';
export default function Show({ document }: any) { return <><Head title={document.document_number} /><div className="space-y-4 p-4"><PageHeader title={document.document_number} /><StatusBadge status={document.status} /><div>{document.document_type}</div><a href={document.pdf_url} target="_blank" className="underline">Open document</a></div></>; }
