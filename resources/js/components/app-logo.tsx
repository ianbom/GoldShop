import AppLogoIcon from '@/components/app-logo-icon';

export default function AppLogo() {
    return (
        <>
            <div className="flex aspect-square size-9 items-center justify-center rounded-xl bg-sidebar-primary text-sidebar-primary-foreground shadow-[0_12px_30px_-16px_color-mix(in_oklab,var(--sidebar-primary)_90%,transparent)]">
                <AppLogoIcon className="size-5 fill-current text-white dark:text-black" />
            </div>
            <div className="ml-2 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-semibold tracking-[-0.02em]">
                    Gold Inventory
                </span>
                <span className="truncate text-[11px] font-medium text-sidebar-foreground/62">Store operations</span>
            </div>
        </>
    );
}
