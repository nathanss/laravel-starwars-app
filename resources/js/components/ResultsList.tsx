import { Button } from '@/components/ui/button';
import { Result } from '@/types';
import { Link } from '@inertiajs/react';


interface ResultsListProps {
    isLoading: boolean;
    results: Result[] | undefined;
    propertyKey: string;
    type: 'people' | 'movies';
}

export function ResultsList({ isLoading, results, propertyKey, type }: ResultsListProps) {
    if (isLoading) {
        return (
            <div className="flex flex-1 items-center justify-center">
                <p className="text-center font-bold text-[var(--pinkish-grey)]">Searching...</p>
            </div>
        );
    }

    if (!results || results.length === 0) {
        return (
            <div className="flex flex-1 items-center justify-center">
                <p className="text-center font-bold text-[var(--pinkish-grey)]">
                    There are zero matches.
                    <br />
                    Use the form to search for People or Movies.
                </p>
            </div>
        );
    }

    return (
        <div className="space-y-4">
            <div>
                {results.map((result, index) => (
                    <div key={index} className="flex items-center justify-between py-3 border-b border-gray-200">
                        <div className="font-bold">{result.properties[propertyKey]}</div>
                        <Link href={type === 'people' ? `/person/${result.uid}` : `/movie/${result.uid}`}>
                            <Button className="uppercase">
                                See details
                            </Button>
                        </Link>
                    </div>
                ))}
            </div>
        </div>
    );
}
