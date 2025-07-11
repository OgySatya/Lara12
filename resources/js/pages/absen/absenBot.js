import puppeteer from 'puppeteer';
const [, , nip, shift] = process.argv;

if (!nip || !shift) {
    console.error('Usage: node script.js <nip> <shift>');
    process.exit(1);
}

(async () => {
    const browser = await puppeteer.launch({
        headless: false,
        args: ['--user-data-dir=C:\\Users\\MSi DESKTOP\\AppData\\Local\\Google\\Chrome for Testing\\User Data', '--profile-directory=Profile 1'],
    });

    const page = await browser.newPage();
    await page.setViewport({ width: 640, height: 1024 });

    await page.goto('https://skemaraja.dephub.go.id/logout', { waitUntil: 'domcontentloaded' });

    await page.goto('https://skemaraja.dephub.go.id');
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // Wait for form to load
    await page.waitForSelector('form#theForm input[name="_token"]');

    // Fill in form
    await page.type('input[name="nip"]', nip);
    await page.type('input[name="password"]', nip);
    await page.select('select[name="status_wfh"]', '2');

    // Select shift (from argument)
    await new Promise((resolve) => setTimeout(resolve, 1000));
    await page.waitForSelector(`input[value="${shift}"]`, { visible: true });
    await page.click(`input[value="${shift}"]`);

    // Wait for and click submit
    // await page.waitForSelector('#btnSubmit:not([disabled])');
    // await Promise.all([page.click('#btnSubmit'), page.waitForNavigation({ waitUntil: 'networkidle0', timeout: 60000 })]);

    await browser.close();
})();
