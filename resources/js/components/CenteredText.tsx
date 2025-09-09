export function CenteredText({children}: {children: React.ReactNode}) {
    return (
        <div className="flex flex-1 items-center justify-center">
            <p className="text-center font-bold text-[var(--pinkish-grey)]">
                {children}
            </p>
        </div>
    );
}
