import { Head } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface PersonProps {
    id: string;
}

export default function Person({ id }: PersonProps) {
    const { data: person, isLoading } = useQuery({
        queryKey: ['person', id],
        queryFn: () => fetch(`/api/star-wars/people/${id}`).then(res => res.json()).then(res => res.result)
    });

    if (isLoading) {
        return <div>Loading...</div>;
    }

    if (!person) {
        return <div>Person not found</div>;
    }

    return (
        <>
            <Head title={`Person - ${person.properties.name}`} />
            <div className="w-full">
                <div className="flex items-start justify-center gap-[15px] bg-[#ededed] min-h-screen p-4">
                    <div className="w-2/3 rounded bg-white p-6 shadow">
                        <Button
                            variant="outline"
                            onClick={() => router.visit('/')}
                            className="mb-4"
                        >
                            ← Back to Search
                        </Button>

                        <h1 className="text-2xl font-bold mb-4">{person.properties.name}</h1>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <h2 className="font-semibold">Height</h2>
                                <p>{person.properties.height} cm</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Mass</h2>
                                <p>{person.properties.mass} kg</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Hair Color</h2>
                                <p>{person.properties.hair_color}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Eye Color</h2>
                                <p>{person.properties.eye_color}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Birth Year</h2>
                                <p>{person.properties.birth_year}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Gender</h2>
                                <p>{person.properties.gender}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
