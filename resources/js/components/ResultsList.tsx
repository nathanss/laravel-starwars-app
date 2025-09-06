import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

interface Result {
    uid?: string;
    properties: {
        [key: string]: string;
    };
}

interface ResultsListProps {
    isLoading: boolean;
    results: Result[] | undefined;
    propertyKey: string;
    type: 'people' | 'movies';
}

export function ResultsList({ isLoading, results, propertyKey, type }: ResultsListProps) {
    if (isLoading) {
        return <div>Searching...</div>;
    }

    if (!results || results.length === 0) {
        return (
            <div>
                There are zero matches.<br/>
                Use the form to search for People or Movies.
            </div>
        );
    }

    return (
        <div className="space-y-4">
            <div className="font-medium">Results</div>
            <div className="divide-y">
                {results.map((result, index) => (
                    <div key={index} className="flex items-center justify-between py-3">
                        <div className="font-medium">{result.properties[propertyKey]}</div>
                        <Link
                            href={type === 'people' ? `/person/${result.uid}` : `/movie/${result.uid}`}
                        >
                            <Button
                                variant="outline"
                                size="sm"
                            >
                                See Details
                            </Button>
                        </Link>
                    </div>
                ))}
            </div>
        </div>
    );
}
