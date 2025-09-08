import { Button } from '@/components/ui/button';
import { Head } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Input } from "@/components/ui/input";
import { useState } from "react";
import { ResultsList } from '@/components/ResultsList';
import { Bar } from '@/components/Bar';
import { Result } from '@/types';



export default function Home() {
    const [formInput, setFormInput] = useState('');
    const [formType, setFormType] = useState('people');
    const [searchTerm, setSearchTerm] = useState('');
    const [searchType, setSearchType] = useState('people');

    const normalizeResults = async (res: Response): Promise<Result[]> => {
        const json = await res.json();
        return json.result;
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
                <Bar text="SWStarter" />

                <div className="flex flex-col md:flex-row items-start justify-center md:gap-8 bg-[var(--background)] min-h-[calc(100vh-40px)] p-8">
                    <div className="w-full md:w-3/10 rounded bg-white p-8 shadow md:m-0">
                        <form className="space-y-6" onSubmit={handleSubmit}>
                            <div className="space-y-2">
                                <Label className="mb-4 text-base">What are you searching for?</Label>
                                <RadioGroup
                                    value={formType}
                                    onValueChange={handleTypeChange}
                                    className="flex flex-wrap gap-4"
                                >
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem
                                            value="people"
                                            id="people"
                                            className="border-[#0094ff] data-[state=checked]:bg-[#0094ff] [&_svg]:fill-white"
                                        />
                                        <Label htmlFor="people">People</Label>
                                    </div>
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem
                                            value="movies"
                                            id="movies"
                                            className="border-[#0094ff] data-[state=checked]:bg-[#0094ff] [&_svg]:fill-white"
                                        />
                                        <Label htmlFor="movies">Movies</Label>
                                    </div>
                                </RadioGroup>
                            </div>
                            <div className="space-y-2">
                                <Input
                                    id="search"
                                    placeholder={formType === 'people'
                                        ? "e.g. Chewbacca, Yoda, Boba Fett"
                                        : "e.g. A New Hope, Empire Strikes Back"
                                    }
                                    value={formInput}
                                    onChange={handleInputChange}
                                />
                            </div>
                            <Button className="w-full" type="submit" disabled={!formInput}>
                                Search
                            </Button>
                        </form>
                    </div>
                    <div className="w-full md:w-4/10 min-h-96 rounded bg-white p-8 shadow md:m-0 flex flex-col">
                        <h2 className="text-xl font-bold">Results</h2>
                        <hr className="my-2" />
                        {!searchTerm ? (
                            <div className="flex-1 flex items-center justify-center">
                                <p className="text-center font-bold text-[var(--pinkish-grey)]">There are zero matches.<br/>Use the form to search for People or Movies.</p>
                            </div>
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
