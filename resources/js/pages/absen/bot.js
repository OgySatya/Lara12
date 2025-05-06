import puppeteer from 'puppeteer';
const [, , nip, shift] = process.argv;

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--user-data-dir=C:\\Users\\MSi DESKTOP\\AppData\\Local\\Google\\Chrome for Testing\\User Data', '--profile-directory=Profile 1'],
    });
    const page = await browser.newPage();

    // 1. Go to login page
    await page.goto('https://skemaraja.dephub.go.id/logout', {
        waitUntil: 'domcontentloaded',
    });
    await new Promise((resolve) => setTimeout(resolve, 5000));
    await page.goto('https://skemaraja.dephub.go.id', {
        waitUntil: 'domcontentloaded',
    });
    // 2. Wait for form and CSRF token to be available
    await page.waitForSelector('form#theForm input[name="_token"]');

    // 3. Fill in the form fields
    await page.type('input[name="nip"]', nip);
    await page.type('input[name="password"]', nip);
    await page.select('select[name="status_wfh"]', '2');
    await page.click(`input[name="shift"][value="${shift}"]`);

    await Promise.all([page.click('button[id="btnSubmit"]'), page.waitForNavigation({ waitUntil: 'networkidle0' })]);

    const h5s = await page.$$('h5');
    const H5 = await h5s[1].evaluate((el) => el.textContent?.trim());

    if (H5 === 'Form Resiko') {
        await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle0' })]);
        await page.type('input[name="p1_suhu"]', '36');
        await page.click('input[name="p1"][value="0"]');
        await page.click('input[name="p2a"][value="0"]');
        await page.click('input[name="p2b"][value="0"]');
        await page.click('input[name="p2c"][value="0"]');
        await page.click('input[name="p3"][value="0"]');
        await page.click('input[name="p4"][value="0"]');
        await page.click('input[name="p5"][value="0"]');
        await page.click('input[name="p6"][value="0"]');
        await page.click('input[name="p7"][value="0"]');
        await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle0' })]);
    }
    if (H5 === 'Form Gejala') {
        await page.type('input[name="p1_suhu"]', '36');
        await page.click('input[name="p1"][value="0"]');
        await page.click('input[name="p2a"][value="0"]');
        await page.click('input[name="p2b"][value="0"]');
        await page.click('input[name="p2c"][value="0"]');
        await page.click('input[name="p3"][value="0"]');
        await page.click('input[name="p4"][value="0"]');
        await page.click('input[name="p5"][value="0"]');
        await page.click('input[name="p6"][value="0"]');
        await page.click('input[name="p7"][value="0"]');
        await Promise.all([page.click('button[type="submit"]'), page.waitForNavigation({ waitUntil: 'networkidle0' })]);
    }

    await browser.close();
})();
