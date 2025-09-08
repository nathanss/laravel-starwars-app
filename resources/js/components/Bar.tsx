interface BarProps {
    text: string;
}

export function Bar({ text }: BarProps) {
    return (
        <h1 className="w-full p-4 text-2xl font-bold text-center text-[var(--emerald)] bg-[var(--white)]">
            {text}
        </h1>
    );
}
