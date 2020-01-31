## 🚀 Environment setup

### 🐳 Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/marydn/star-wars`
3. Move to the project folder: `cd star-wars`

### 🛠️ Environment configuration

### 🌍 Application execution

1. Start the project: `make build`
   
    This will install PHP dependencies and bring up the project Docker containers with Docker Compose.

2. Check everything's up: `docker-composer ps`

    It should show nginx and php services up.

3. Go to `http:://localhost:8000`


### Some Docker commands

- Bringing up the project using Docker: `make`
- Bringing down the project: `make destroy`
- Rebuild Docker images forcing latest versions and ignoring cache: `make rebuild`

### ✅ Tests execution

1. Install PHP dependencies if you haven't done so: `make deps`
2. Execute PHP Unit tests: `make test`

## 🤔 Project explanation

```bash
$ tree -L 4 src

src

```

