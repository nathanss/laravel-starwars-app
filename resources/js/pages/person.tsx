import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface PersonProps {
    person: any;
}

export default function Person({ person }: PersonProps) {

    if (!person) {
        return <div>Person not found</div>;
    }

    return (
        <>
            <Head title={`Person - ${person.name}`} />
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

                        <h1 className="text-2xl font-bold mb-4">{person.name}</h1>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <h2 className="font-semibold">Height</h2>
                                <p>{person.height} cm</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Mass</h2>
                                <p>{person.mass} kg</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Hair Color</h2>
                                <p>{person.hair_color}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Eye Color</h2>
                                <p>{person.eye_color}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Birth Year</h2>
                                <p>{person.birth_year}</p>
                            </div>
                            <div>
                                <h2 className="font-semibold">Gender</h2>
                                <p>{person.gender}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
