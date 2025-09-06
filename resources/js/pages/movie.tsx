import { Head } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

interface MovieProps {
    id: string;
}

export default function Movie({ id }: MovieProps) {
    const { data: movie, isLoading } = useQuery({
        queryKey: ['movie', id],
        queryFn: () => fetch(`/api/star-wars/films/${id}`).then(res => res.json()).then(res => res.result)
    });

    if (isLoading) {
        return <div>Loading...</div>;
    }

    if (!movie) {
        return <div>Movie not found</div>;
    }

    return (
        <>
            <Head title={`Movie - ${movie.properties.title}`} />
            <div className="w-full">
                <div className="flex items-start justify-center gap-[15px] bg-[#ededed] min-h-screen p-4">
                    <div className="w-2/3 rounded bg-white p-6 shadow">
                        <Link href="/">
                            <Button
                                variant="outline"
                                className="mb-4"
                            >
                                ← Back to Search
                            </Button>
                        </Link>

                        <h1 className="text-2xl font-bold mb-4">{movie.properties.title}</h1>

                        <div className="space-y-4">
                            <div>
                                <h2 className="font-semibold">Episode</h2>
                                <p>Episode {movie.properties.episode_id}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Director</h2>
                                <p>{movie.properties.director}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Producer</h2>
                                <p>{movie.properties.producer}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Release Date</h2>
                                <p>{movie.properties.release_date}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Opening Crawl</h2>
                                <p className="whitespace-pre-line">{movie.properties.opening_crawl}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
