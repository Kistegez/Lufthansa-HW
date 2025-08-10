# Lufthansa Backend Application

A Symfony-based REST API backend application built with **Domain Driven Design (DDD)** principles for scalable user management. Features comprehensive user operations, validation, and support for multiple response formats.

## Architecture

This application follows **Domain Driven Design (DDD)** principles with a clean architecture:

```

DDD Layers:

- Domain Layer: Core business logic, entities, services
- Infrastructure Layer: Database repositories
- Presentation Layer: REST API controllers, request/response handling

Features

- Domain Driven Design: Clean architecture with proper separation of concerns
- REST API Endpoints: Complete CRUD operations for user management
- Data Validation: Comprehensive input validation using Symfony Validator
- Password Security: Secure password hashing using Symfony Security component
- Multiple Response Formats: Support for both JSON and YAML response formats
- Database Integration: MySQL database with Doctrine ORM and embedded value objects
- Docker Support: Complete containerization with Docker and Docker Compose
- Comprehensive Testing: Domain tests, use case tests, and API integration tests
- Production Ready: Optimized for production deployment with enterprise patterns

```

## API Endpoints

### 1. Create User
**POST** `/api/users`

**Example request Body (JSON):**
```json
{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john.doe@example.com",
    "password": "securepassword123"
}
```

**Response (201 Created):**
```json
[]
```

### 2. Get All Users
**GET** `/api/users`

**Response (200 OK):**
```json
{
    "users": [
        {
            "id": 1,
            "firstName": "John",
            "lastName": "Doe",
            "email": "john.doe@example.com",
            "fullName": "John Doe",
            "createdAt": "2024-01-01 12:00:00"
        }
    ]
}
```

### 3. Get Single User
**GET** `/api/users/{id}`

**Response (200 OK):**
```json
{
    "id": 1,
    "firstName": "John",
    "lastName": "Doe",
    "email": "john.doe@example.com",
    "fullName": "John Doe",
    "createdAt": "2024-01-01 12:00:00"
}
```

## Response Formats

### JSON (Default)
All endpoints return JSON by default.

### YAML
To get YAML responses, use one of these methods:

1. **Query Parameter**: Add `?format=yaml` to any endpoint
2. **Accept Header**: Set `Accept: application/yaml` or `Accept: text/yaml`

## Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- Docker & Docker Compose

### Installation

#### Option 1: One-Command Docker Setup (Recommended)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Kistegez/Lufthansa-HW.git
   cd akos-tegez-lufthansa-hw
   ```

2. **Start everything with Docker:**
   ```bash
   docker-compose up --build
   ```

   This single command will:
   - Build the application container
   - Start MySQL database
   - Wait for database to be ready
   - Run database migrations automatically
   - Start the Symfony development server
   - Make the API available at `http://localhost:8000`

#### Option 2: Manual Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Kistegez/Lufthansa-HW.git
   cd akos-tegez-lufthansa-hw
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Start the MySQL database:**
   ```bash
   docker-compose up -d database
   ```

4. **Run database migrations:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Start the development server:**
   ```bash
   php -S localhost:8000 -t public
   ```

## Testing the API Endpoints

### Using cURL

**Create a user:**
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "firstName": "Jane",
    "lastName": "Smith",
    "email": "jane.smith@example.com",
    "password": "mypassword123"
  }'
```

**Get all users (JSON):**
```bash
curl http://localhost:8000/api/users
```

**Get all users (YAML):**
```bash
curl http://localhost:8000/api/users?format=yaml
```

**Get single user:**
```bash
curl http://localhost:8000/api/users/1
```

## The project includes a test suite

**Run all tests:**
```bash
php bin/phpunit
```

**Run tests with detailed output:**
```bash
php bin/phpunit --testdox
```

**Run specific test class:**
```bash
# Entity unit tests
php bin/phpunit tests/Entity/UserTest.php

# Repository tests
php bin/phpunit tests/Repository/UserRepositoryTest.php
```

## Technical Implementation

- **Framework**: Symfony 7.3
- **ORM**: Doctrine ORM 3.5
- **Database**: MySQL 8.0 
- **Security**: Symfony Security Component with password hashing
- **Serialization**: Symfony Serializer Component
- **Validation**: Symfony Validator Component
- **Testing**: PHPUnit
- **Containerization**: Docker with MySQL service 
