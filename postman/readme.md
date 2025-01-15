# API Documentation

## Authentication

To access protected endpoints, you need to:

1. Login to get your authentication token
2. Use the token in the Authorization header as a Bearer token

### Login
```http
POST /login
```

Request body:
```json
{
    "email": "your.email@example.com",
    "password": "your_password"
}
```

Response:
```json
{
    "token": "your_authentication_token"
}
```

## Endpoints

### Tasks (Protected Routes)

All Task endpoints require authentication. Include the token in the Authorization header:
```http
Authorization: Bearer your_authentication_token
```

#### List all tasks
```http
GET /task
```

#### Get task by ID
```http
GET /task/{id}
```

#### Create task
```http
POST /task
```
Request body:
```json
{
    "title": "Task title",
    "description": "Task description",
    "category_id": 1
}
```

#### Update task
```http
PUT /task/{id}
```
Request body:
```json
{
    "title": "Updated title",
    "description": "Updated description",
    "category_id": 1
}
```

#### Delete task
```http
DELETE /task/{id}
```

### Categories

#### List all categories
```http
GET /categoria
```

#### Get category by ID
```http
GET /categoria/{id}
```

#### Create category
```http
POST /categoria
```
Request body:
```json
{
    "name": "Category name"
}
```

#### Update category
```http
PUT /categoria/{id}
```
Request body:
```json
{
    "name": "Updated name"
}
```

#### Delete category
```http
DELETE /categoria/{id}
```

### Users

#### List all users
```http
GET /users
```

#### Get user by ID
```http
GET /users/{id}
```

#### Create user
```http
POST /users
```
Request body:
```json
{
    "name": "User name",
    "email": "user@example.com",
    "password": "password",
    "genero_id": 1
}
```

#### Update user
```http
PUT /users/{id}
```
Request body:
```json
{
    "name": "Updated name",
    "email": "updated@example.com",
    "password": "new_password",
    "genero_id": 1
}
```

#### Delete user
```http
DELETE /users/{id}
```

### Logout
```http
POST /logout/{user_id}
```

## Error Handling

The API returns appropriate HTTP status codes:

- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 500: Internal Server Error

## Example Usage

1. First, create a user:
```http
POST /users
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secure_password",
    "genero_id": 1
}
```

2. Login to get your token:
```http
POST /login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "secure_password"
}
```

3. Use the token to create a task:
```http
POST /task
Authorization: Bearer your_token
Content-Type: application/json

{
    "title": "My First Task",
    "description": "Task description",
    "category_id": 1
}
```
