import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

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
                <h1 className="w-full h-[25px] mb-[15px] text-2xl font-bold text-center">
                    SWStarter
                </h1>
                <div className="flex min-h-screen items-start justify-center gap-[15px] bg-[#ededed] p-4">
                    <div className="w-2/3 rounded bg-white p-6 shadow">
                        <h1 className="mb-4 text-2xl font-bold">{movie.title} (Episode {movie.episode_id})</h1>

                        <div className="mb-8 grid grid-cols-2 gap-8">
                            <div>
                                <h2 className="text-xl font-semibold">Opening Crawl</h2>
                                <hr className="my-3" />
                                <p className="whitespace-pre-line">{movie.opening_crawl}</p>

                            </div>
                            <div>
                                <h2 className="text-xl font-semibold">Characters</h2>
                                <hr className="my-3" />
                                <p>
                                    {characters.map((character, index) => (
                                        <>
                                            <Link
                                                key={character.uid}
                                                href={`/person/${character.uid}`}
                                                className="text-blue-600 hover:text-blue-800 hover:underline"
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
                            <Button className="mb-4">
                                BACK TO SEARCH
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}
