import { Button } from '@/components/ui/button';
import { Head } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Input } from "@/components/ui/input";
import { useState } from "react";
import { ResultsList } from '@/components/ResultsList';



export default function Home() {
    const [formInput, setFormInput] = useState('');
    const [formType, setFormType] = useState('people');
    const [searchTerm, setSearchTerm] = useState('');
    const [searchType, setSearchType] = useState('people');

    const normalizeResults = async (res: Response) => {
        const json = await res.json();
        return json.result || json.results;
    }

    const { data: peopleData, isLoading: isPeopleLoading } = useQuery({
        enabled: searchType === 'people' && searchTerm.length > 0,
        queryKey: ['people', searchTerm],
        queryFn: () => fetch(`/api/star-wars/people?name=${encodeURIComponent(searchTerm)}`).then(normalizeResults)
    });

    const { data: moviesData, isLoading: isMoviesLoading } = useQuery({
        enabled: searchType === 'movies' && searchTerm.length > 0,
        queryKey: ['films', searchTerm],
        queryFn: () => fetch(`/api/star-wars/films?title=${encodeURIComponent(searchTerm)}`).then(normalizeResults)
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setSearchTerm(formInput);
        setSearchType(formType);
    };

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFormInput(e.target.value);
        setSearchTerm(''); // Reset search results
    };

    const handleTypeChange = (value: string) => {
        setFormType(value);
        setSearchTerm(''); // Reset search results
    };

    return (
        <>
            <Head title="SWStarter" />
            <div className="w-full">
                <h1 className="w-full h-[25px] mb-[15px] text-2xl font-bold text-center">
                    SWStarter
                </h1>

                <div className="flex items-start justify-center gap-[15px] bg-[#ededed] min-h-[calc(100vh-40px)]">
                    <div className="w-1/2 rounded bg-white p-4 shadow m-4">
                        <form className="space-y-6" onSubmit={handleSubmit}>
                            <div className="space-y-2">
                                <Label>What are you searching for?</Label>
                                <RadioGroup
                                    value={formType}
                                    onValueChange={handleTypeChange}
                                    className="flex space-x-4"
                                >
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="people" id="people" />
                                        <Label htmlFor="people">People</Label>
                                    </div>
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="movies" id="movies" />
                                        <Label htmlFor="movies">Movies</Label>
                                    </div>
                                </RadioGroup>
                            </div>
                            <div className="space-y-2">
                                <Input id="search" placeholder="e.g. Chewbacca, Yoda, Boba Fett" value={formInput} onChange={handleInputChange} />
                            </div>
                            <Button type="submit" disabled={!formInput} className="w-full">
                                Search
                            </Button>
                        </form>
                    </div>
                    <div className="w-1/2 rounded bg-white p-4 shadow m-4">
                        {!searchTerm ? (
                            <div>Use the form to search for People or Movies.</div>
                        ) : searchType === 'people' ? (
                            <ResultsList
                                isLoading={isPeopleLoading}
                                results={peopleData}
                                propertyKey="name"
                                type="people"
                            />
                        ) : (
                            <ResultsList
                                isLoading={isMoviesLoading}
                                results={moviesData}
                                propertyKey="title"
                                type="movies"
                            />
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}
