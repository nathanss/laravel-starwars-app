import { Button } from '@/components/ui/button';
import { Head, Link } from '@inertiajs/react';

interface Film {
    title: string;
    uid: string;
    url: string;
}

interface Person {
    name: string;
    birth_year: string;
    gender: string;
    eye_color: string;
    hair_color: string;
    height: string;
    mass: string;
    films: string[];
}

interface PersonProps {
    person: Person;
    films: Film[];
}

export default function Person({ person, films }: PersonProps) {
    if (!person) {
        return <div>Person not found</div>;
    }

    return (
        <>
            <Head title={`Person - ${person.name}`} />
            <div className="w-full">
                <h1 className="w-full h-[25px] mb-[15px] text-2xl font-bold text-center">
                    SWStarter
                </h1>
                <div className="flex min-h-screen items-start justify-center gap-[15px] bg-[#ededed] p-4">
                    <div className="w-2/3 rounded bg-white p-6 shadow">
                        <h1 className="mb-4 text-2xl font-bold">{person.name}</h1>

                        <div className="mb-8 grid grid-cols-2 gap-8">
                            <div>
                                <h2 className="text-xl font-semibold">Details</h2>
                                <hr className="my-3" />
                                <div className="flex flex-col gap-2">
                                    <p>
                                        <span className="font-medium">Birth Year:</span> {person.birth_year}
                                    </p>
                                    <p>
                                        <span className="font-medium">Gender:</span> {person.gender}
                                    </p>
                                    <p>
                                        <span className="font-medium">Eye Color:</span> {person.eye_color}
                                    </p>
                                    <p>
                                        <span className="font-medium">Hair Color:</span> {person.hair_color}
                                    </p>
                                    <p>
                                        <span className="font-medium">Height:</span> {person.height}
                                    </p>
                                    <p>
                                        <span className="font-medium">Mass:</span> {person.mass}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <h2 className="text-xl font-semibold">Movies</h2>
                                <hr className="my-3" />
                                <p>
                                    {films.map((film, index) => (
                                        <>
                                            <Link
                                                key={film.uid}
                                                href={`/movie/${film.uid}`}
                                                className="text-blue-600 hover:text-blue-800 hover:underline"
                                            >
                                                {film.title}
                                            </Link>
                                            {index < films.length - 1 && <span>, </span>}
                                        </>
                                    ))}
                                </p>
                            </div>
                        </div>
                        <Link href="/">
                            <Button className="mb-4">BACK TO SEARCH</Button>
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}
