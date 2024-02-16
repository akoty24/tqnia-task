<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Sanctum Authentication System with Tags and Posts API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3, h5 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li::before {
            content: "•";
            margin-right: 10px;
            color: #007bff;
        }

        code {
            background-color: #f8f9fa;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laravel Sanctum Authentication System with Tags and Posts API</h1>

        <h3>Features</h3>

        <h4>Authentication System with Sanctum</h4>
        <ul>
            <li>User registration with name, phone number, and password.</li>
            <li>User login with authentication token.</li>
            <li>Generation and logging of a random 6-digit verification code for each user.</li>
            <li>Endpoint for verifying the code sent to the user.</li>
            <li>Only verified accounts can login.</li>
        </ul>

        <h4>Tags API Resource</h4>
        <ul>
            <li>Authenticated users can view, store, update, and delete tags.</li>
            <li>Tags have unique names.</li>
        </ul>

        <h4>Posts API Resource</h4>
        <ul>
            <li>Authenticated users can view, store, update, and delete their posts.</li>
            <li>Authenticated users can view their deleted posts and restore them.</li>
            <li>Posts include title, body, cover image, pinned status, and one or more tags.</li>
            <li>Pinned posts appear first for every user.</li>
            <li>Data validation for storing and updating posts.</li>
        </ul>

        <h4>Scheduled Jobs</h4>
        <ul>
            <li>A daily job force-deletes softly-deleted posts older than 30 days.</li>
            <li>A job runs every six hours making an HTTP request to an external endpoint.</li>
        </ul>

        <h4>Stats API Endpoint</h4>
        <ul>
            <li>Endpoint that returns:
                <ul>
                    <li>Number of all users.</li>
                    <li>Number of all posts.</li>
                    <li>Number of users with 0 posts.</li>
                </ul>
            </li>
            <li>Results are cached and updated with every update to the related models (User and Post).</li>
        </ul>

        <h3>Setup</h3>
        <ol>
            <li>Clone the repository.</li>
            <li>Install dependencies with <code>composer install</code>.</li>
            <li>Set up your environment variables in the <code>.env</code> file, including database configuration and Sanctum settings.</li>
            <li>Run migrations and seeders with <code>php artisan migrate --seed</code>.</li>
            <li>Serve the application with <code>php artisan serve</code>.</li>
        </ol>

        <h5>Accessing the API Collection</h5>
        <ul>
            <li>Navigate to the root folder of the Laravel project.</li>
            <li>Look for the API collection file named <code>api.postman_collection</code> or similarly named file.</li>
            <li>Import this collection into your preferred API development environment (e.g., Postman, Insomnia) to explore the available endpoints and their functionalities.</li>
        </ul>

        <h3>API Endpoints</h3>
        <ul>
            <li>/register: User registration endpoint.</li>
            <li>/login: User login endpoint.</li>
            <li>/tags: Tags API resource endpoints.</li>
            <li>/posts: Posts API resource endpoints.</li>
            <li>/stats: Stats API endpoint.</li>
        </ul>

        <h3>Dependencies</h3>
        <ul>
            <li>Laravel Framework 10.x</li>
            <li>Laravel Sanctum</li>
            <li>SQLite Database</li>
            <li>PHP HTTP Client (for making HTTP requests to external endpoint)</li>
        </ul>

        <h3>Notes</h3>
        <ul>
            <li>Ensure that the necessary cron jobs are set up for running scheduled tasks.</li>
            <li>Verify that the caching mechanism is properly configured for the <code>/stats</code> endpoint.</li>
        </ul>

        <p>Feel free to explore and customize the project according to your needs. If you have any questions or feedback, please don't hesitate to reach out!</p>
    </div>
</body>
</html>
