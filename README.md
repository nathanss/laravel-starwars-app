# Laravel Star Wars App

## Requirements

- Docker (Docker Desktop on macOS/Windows, Docker Engine on Linux)
- Docker Compose
- Git

## Setup

1. Clone the repository

2. Copy the environment file
```bash
cp .env.example .env
```

3. Install dependencies using Laravel Sail
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

4. Start the Docker containers:
```bash
./vendor/bin/sail up
```

5. Install node dependencies
```bash
./vendor/bin/sail npm install
```

6. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

## Running the Application

You need to run the following commands in separate terminal windows:

1. Start the Docker containers:
```bash
./vendor/bin/sail up
```

2. Start the Vite development server for frontend assets:
```bash
./vendor/bin/sail npm run dev
```

3. Start the Laravel queue worker:
```bash
./vendor/bin/sail artisan queue:work
```

4. Start the Laravel scheduler:
```bash
./vendor/bin/sail artisan schedule:work
```

## Additional Commands

- Run unit tests:
```bash
./vendor/bin/sail artisan test
```

- Run E2E tests:
```bash
./vendor/bin/sail run npx playwright install chromium # run only once
./vendor/bin/sail npm run test:e2e
```

## Development

The application uses Laravel Sail as its Docker development environment. Laravel Sail provides a great Docker-based development experience without requiring prior Docker knowledge.
