import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';
import { Bar } from '@/components/Bar';

interface Character {
    name: string;
    uid: string;
}

interface Movie {
    title: string;
    episode_id: number;
    opening_crawl: string;
    director: string;
    producer: string;
    release_date: string;
}

interface MovieProps {
    movie: Movie;
    characters: Character[];
}

export default function Movie({ movie, characters }: MovieProps) {
    if (!movie) {
        return <div>Movie not found</div>;
    }

    return (
        <>
            <Head title={`Movie - ${movie.title}`} />
            <div className="w-full">
                <Bar text="SWStarter" />
                <div className="flex min-h-screen items-start justify-center gap-8 bg-[var(--grey-background)] p-8">
                    <div className="w-full md:w-2/3 rounded bg-white p-8 shadow">
                        <h2 className="mb-8 text-2xl font-bold">{movie.title} (Episode {movie.episode_id})</h2>

                        <div className="mb-8 grid grid-cols-2 gap-8">
                            <div>
                                <h2 className="text-xl font-semibold">Opening Crawl</h2>
                                <hr className="my-2" />
                                <p className="whitespace-pre-line">{movie.opening_crawl}</p>

                            </div>
                            <div>
                                <h2 className="text-xl font-semibold">Characters</h2>
                                <hr className="my-2" />
                                <p>
                                    {characters.map((character, index) => (
                                        <>
                                            <Link
                                                key={character.uid}
                                                href={`/person/${character.uid}`}
                                                className="text-[var(--blue)] hover:underline"
                                            >
                                                {character.name}
                                            </Link>
                                            {index < characters.length - 1 && <span>, </span>}
                                        </>
                                    ))}
                                </p>
                            </div>
                        </div>

                        <Link href="/">
                            <Button className="mb-4 uppercase">
                                Back to search
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}
