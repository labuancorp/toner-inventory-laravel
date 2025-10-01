from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    try:
        # Go to the login page and take a screenshot
        page.goto("http://127.0.0.1:8000/login", wait_until="networkidle")

        # Save the page source for debugging
        with open("jules-scratch/verification/login_page_source.html", "w") as f:
            f.write(page.content())

        page.screenshot(path="jules-scratch/verification/final_attempt.png")

    finally:
        browser.close()

with sync_playwright() as playwright:
    run(playwright)