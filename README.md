# Performance Graph Analysis Tool

This is a web application build with Laravel and VueJS designed to analyze performance graph images of a website. The tool leverages an AI model to generate insightful summaries and trends based on the uploaded images, providing a detailed analysis of site performance over time.

---

## Features

-   **Image Upload**: Users can upload multiple images through an intuitive drag-and-drop interface using FilePond.
-   **Image Processing**: Uploaded images are validated, stored, and processed to prepare them for analysis.
-   **AI-Powered Analysis**: Integrated with Gemini AI to analyze graph images and generate a comprehensive site performance report.
-   **Detailed Reports**: Summaries include trends, insights, and performance metrics based on the provided graphs.

---

## Installation

### Prerequisites

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   A web server (e.g., Apache, Nginx)
-   Laravel Framework
-   Gemini AI API key (optional for local testing)

### Steps

1. **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd <project-folder>
    ```
2. **Add env variables**
    ```bash
    GEMINI_API_KEY="<your-gemini-api-key>"
    GEMINI_BASE_URL="https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent"
    ```
3. **Install dependencies**
   run the following to install dependencies

    ```bash
     composer install
    ```

    ```bash
    npm install
    ```

    ```bash
    cp .env.example .env
    ```

4. **Serve project**

    ```bash
    php artisan serve
    ```

    in a different terminal window

    ```bash
    npm run dev
    ```
