import puppeteer from 'puppeteer';

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--user-data-dir=C:\\Users\\MSi DESKTOP\\AppData\\Local\\Google\\Chrome for Testing\\User Data', '--profile-directory=Profile 1'],
    });
    const page = await browser.newPage();

    await page.goto('http://lara12.test/test', {
        waitUntil: 'domcontentloaded',
    });
    await new Promise((resolve) => setTimeout(resolve, 5000));
    // 4. Submit the form
    await Promise.all([
        page.click('button[id="submit"]'),
        page.waitForNavigation({ waitUntil: 'networkidle0' }), // waits for page after submit
    ]);

    await browser.close();
})();
