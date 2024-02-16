# Laravel Sanctum Authentication System with Tags and Posts API

<h3 align="center">Features</h3>

## Authentication System with Sanctum

- User registration with name, phone number, and password.
- User login with authentication token.
- Generation and logging of a random 6-digit verification code for each user.
- Endpoint for verifying the code sent to the user.
- Only verified accounts can login.

## Tags API Resource

- Authenticated users can view, store, update, and delete tags.
- Tags have unique names.

## Posts API Resource

- Authenticated users can view, store, update, and delete their posts.
- Authenticated users can view their deleted posts and restore them.
- Posts include title, body, cover image, pinned status, and one or more tags.
- Pinned posts appear first for every user.
- Data validation for storing and updating posts.

### Scheduled Jobs

- A daily job force-deletes softly-deleted posts older than 30 days.
- A job runs every six hours making an HTTP request to an external endpoint.

## Stats API Endpoint

- Endpoint that returns:
  - Number of all users.
  - Number of all posts.
  - Number of users with 0 posts.
- Results are cached and updated with every update to the related models (User and Post).

<h3 align="center">Setup</h3>

To set up the project locally, follow these steps:

1. Clone the repository.
2. Install dependencies with `composer install`.
3. Set up your environment variables in the `.env` file, including database configuration and Sanctum settings.
4. Run migrations and seeders with `php artisan migrate --seed`.
5. Serve the application with `php artisan serve`.
   
<h4 align="center">Accessing the API Collection</h4>

- Navigate to the root folder of the Laravel project.
- Look for the API collection file named `api.postman_collection` or similarly named file.
- Import this collection into your preferred API development environment (e.g., Postman, Insomnia) to explore the available endpoints and their functionalities.

## API Endpoints

- `/register`: User registration endpoint.
- `/login`: User login endpoint.
- `/tags`: Tags API resource endpoints.
- `/posts`: Posts API resource endpoints.
- `/stats`: Stats API endpoint.

## Dependencies

- Laravel Framework 10.x
- Laravel Sanctum
- SQLite Database
- PHP HTTP Client (for making HTTP requests to external endpoint)

## Notes

- Ensure that the necessary cron jobs are set up for running scheduled tasks.
- Verify that the caching mechanism is properly configured for the `/stats` endpoint.

Feel free to explore and customize the project according to your needs. If you have any questions or feedback, please don't hesitate to reach out!
