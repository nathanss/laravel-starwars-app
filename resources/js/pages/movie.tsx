import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

interface MovieProps {
    movie: any;
}

export default function Movie({ movie }: MovieProps) {

    if (!movie) {
        return <div>Movie not found</div>;
    }

    return (
        <>
            <Head title={`Movie - ${movie.title}`} />
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

                        <h1 className="text-2xl font-bold mb-4">{movie.title}</h1>

                        <div className="space-y-4">
                            <div>
                                <h2 className="font-semibold">Episode</h2>
                                <p>Episode {movie.episode_id}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Director</h2>
                                <p>{movie.director}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Producer</h2>
                                <p>{movie.producer}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Release Date</h2>
                                <p>{movie.release_date}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Opening Crawl</h2>
                                <p className="whitespace-pre-line">{movie.opening_crawl}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
