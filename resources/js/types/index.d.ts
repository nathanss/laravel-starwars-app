export interface Auth {
    user: User;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Result {
    uid?: string;
    properties: {
        [key: string]: string;
    };
}

export interface Movie {
    title: string;
    episode_id: number;
    opening_crawl: string;
    director: string;
    producer: string;
    release_date: string;
}

export interface Person {
    name: string;
    birth_year: string;
    gender: string;
    eye_color: string;
    hair_color: string;
    height: string;
    mass: string;
    films: string[];
}
