Web Crawler
Hello there! 👋 Welcome to my Web Crawler project.

Overview
This project is a simple web crawler that allows you to crawl a website and store the extracted data in a JSON file. Additionally, it provides a search functionality to look for specific strings within the crawled data.

How to Use
1. Crawling
To crawl a website, follow these steps:

Enter the target website URL.
Specify the depth for crawling.
Click the "Crawl" button.
The crawled data will be saved to a file named crawler_output.json.

2. Searching
To search for specific strings within the crawled data:

Click here to go to the search page.
Enter the search string.
Click the "Search" button.
The search result, if found, will be displayed.

Project Structure
index.php: Main page for crawling a website.
search.php: Page for searching within the stored data.
crawler_output.json: File to store the crawled data.
Getting Started
Clone the repository:
bash
Copy code
git clone https://github.com/your-username/web-crawler.git
cd web-crawler
Upload the files to your web server (e.g., Apache, Nginx, etc.) or use a local server environment (e.g., XAMPP, WampServer).

Open index.php in your browser to start crawling.

For searching, click the provided link or go to search.php.

Known Issues
Partial string matching is case-insensitive.
Contribution
Feel free to contribute to this project by creating issues or submitting pull requests.

Happy crawling! 🕷️🕸️

