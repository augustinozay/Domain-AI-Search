# Domain-AI-Search
This PHP application uses the Google Gemini AI API to generate domain name suggestions. 


# PHP Domain Name Generator using Google Gemini API

This project is a PHP-based web application that leverages the Google Gemini AI API to generate domain name suggestions. It uses a set of predefined examples to guide the AI in creating relevant and creative domain names based on user input.

## Features

*   **User-Friendly Interface:** A simple HTML form allows users to enter a prompt describing their desired domain name (e.g., "a website for coffee lovers").
*   **AI-Powered Suggestions:** The application uses the Google Gemini API to generate relevant domain names based on the provided user prompt and a set of pre-defined examples to learn from.
*   **cURL for API Interaction:** Utilizes PHP's `cURL` library for making requests to the Google Gemini API.
*   **Secure API Key Management:** Uses cPanel environment variables to securely store and access the Google Gemini API key.
*   **Easy to Deploy:** Designed to be easily deployable on cPanel hosting environments.
* **Combined Context:** Uses pre-defined example prompts and user prompt in a single request to `generateContent` method to let Gemini API learn from context.

## Setup Instructions

Follow these steps to set up and deploy the domain name generator:

1.  **Prerequisites:**
    *   A cPanel hosting account.
    *   A valid Google Gemini API key (get one at [https://aistudio.google.com/](https://aistudio.google.com/)).
    *   PHP 7.4 or higher with the `curl` and `json` extensions enabled.
2.  **Set Environment Variable:**
    *   In your cPanel, navigate to the "Environment Variables" section.
    *   Add a new variable named `GEMINI_API_TOKEN` and set its value to your Google Gemini API key.
3.  **Download Files:**
     * Download the `domain.php` file.
    * Create `composer.json` file with following content:
        ```json
        {
            "require": {
                "google/apiclient": "^2.15",
                "mongodb/mongodb": "^1.17"
            }
        }
        ```
     * Install dependencies using `composer install` command.
     * Upload the `domain.php` file and `vendor` directory into your web server's document root directory (`public_html` or similar).
4.  **Set File Permissions:**
    *   Set file permissions for `domain.php` to `644`.
    *   Set permissions for the `vendor` directory to `755`.
    *    Set permissions for files inside the `vendor` folder to `644`.
5.  **Access:** Open your web browser and go to your domain's URL followed by `/domain.php` (e.g., `yourdomain.com/domain.php`).

## Usage

1.  **Enter Prompt:** In the form, enter a text prompt that describes your desired domain name (e.g., "A website about travel in Asia").
2.  **Generate:** Click the "Generate Domain Names" button.
3.  **View Results:** The generated domain name suggestions will appear below the form.

## Code Overview

The main application logic is in `domain.php`:

*   **`generateDomainName()` Function:**
    *   Retrieves the API key from environment variables.
    *   Defines API request parameters.
    *   Creates a `fullPrompt` by combining pre-defined examples and user prompt to be sent to Gemini API
    *   Uses `curl` to send a POST request to the Gemini API's `generateContent` endpoint, providing the API key via the  `x-goog-api-key` header.
    *   Parses the JSON response and extracts the domain name suggestions.
*   **HTML Form:** Provides a simple form for user input and displays results.

## Important Considerations

*   **API Key:** Protect your API key. Store it securely using environment variables and avoid committing it to public repositories.
*  **No Chat Session:** This application uses the `generateContent` method which does not support a chat session, so the model will not remember previous turns. A true chat session would require handling of `startChat` method with each prompt sent as `sendMessage` which is not part of this implementation.
*  **Combined Context:** This application sends all prompts in one single request, instead of remembering previous turns, which might affect performance or context understanding of the Gemini AI API.
*   **Error Handling:** The code has basic error checking. Enhance error handling to manage API errors gracefully.
*   **Rate Limits:** Be aware of Google Gemini API's rate limits.

## Contributing

Feel free to fork this repository, make changes, and submit pull requests.

## License

This project is Open source under the Zaya Ts (.mn Registry).
Contact: ankhzaya [AT] gmail [DOT] com
