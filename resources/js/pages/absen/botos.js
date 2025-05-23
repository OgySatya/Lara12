import puppeteer from 'puppeteer';

(async () => {
    const browser = await puppeteer.launch({
        headless: false,
        args: ['--user-data-dir=C:\\Users\\MSi DESKTOP\\AppData\\Local\\Google\\Chrome for Testing\\User Data', '--profile-directory=Profile 1'],
    });
    const page = await browser.newPage();

    await page.goto('http://localhost:8080/', {
        waitUntil: 'domcontentloaded',
    });
    await new Promise((resolve) => setTimeout(resolve, 5000));
    // 4. Submit the form
    await Promise.all([
        await page.click('a[href="http://localhost:8080/login"]'),
        page.waitForNavigation({ waitUntil: 'networkidle0' }), // waits for page after submit
    ]);
})();
