## 🚀 Environment setup using Docker

### 🐳 Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `$ git clone https://github.com/marydn/star-wars`
3. Move to the project folder: `$ cd star-wars`

### 🛠️ Environment configuration

1. By default, Redis TTL is set to 300 seconds. 
    
   To override this parameter: 
    
    ```bash
    $ touch .env.local
    $ echo 'REDIS_TTL=XXX' >> .env.local # where XXX is the desired int value
    ```

### 🌍 Application execution

1. Start the project: `$ make build`
   
    This will install PHP dependencies and bring up the project Docker containers with Docker Compose.

2. Check everything's up: `$ docker-composer ps`

    It should show nginx and php services up.

3. Go to `http:://localhost:8000` in your browser

### Some Docker commands

- Bringing up the project using Docker: `$ make`
- Bringing down the project: `$ make destroy`
- Rebuild Docker images forcing latest versions and ignoring cache: `$ make rebuild`

### ✅ Tests execution

1. Install PHP dependencies if you haven't done so: `$ make deps`
2. Execute PHP Unit tests: `$ make test`

## 🤔 Project explanation

It's a simple form that let you query an endpoint and print the result into a table using XMLHttRequest.
Every request made is cached in Redis using a Middleware (`src/Service/Middleware/CachedMiddleware.php`)

```bash
$ tree -L 4 src
src
├── Controller
│   ├── HomeController.php
│   └── JsonController.php
├── Public
│   ├── js
│   │   └── entry.js # This is for webpack
│   └── vue
│       └── ApiFetcher.vue # Javascript component for front
└── Service
    ├── ApiConsumer.php # Service to wrap third-party requests
    ├── Middleware
    │   └── CachedMiddleware.php # Middleware that allows to call a cache wrapper per API call
    ├── Normalizer
    │   └── GuzzleResponseNormalizer.php # Normalize Guzzle Response Objects to save and retrieve to/from Redis
    └── RedisCache.php # Some methods to handle Redis transactions
```