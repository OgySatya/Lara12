import puppeteer from 'puppeteer';

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        userDataDir: 'C:\\Users\\Rapht\\AppData\\Local\\Google\\Chrome for Testing\\User Data',
        args: ['--profile-directory=Profile 1'], // Use Profile 1 here
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
