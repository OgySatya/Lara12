import puppeteer from 'puppeteer';
const [, , nip, password, shift] = process.argv;

(async () => {
    // const browser = await puppeteer.launch({
    //     headless: false,
    //     // userDataDir: 'C:\\Users\\MSi DESKTOP\\AppData\\Local\\Google\\Chrome for Testing\\User Data',
    //     // userDataDir: 'C:\\Users\\Rapht\\AppData\\Local\\Google\\Chrome for Testing\\User Data',
    //     // args: ['--no-sandbox', '--disable-setuid-sandbox', '--profile-directory=Profile 1'],
    // });

    const browser = await puppeteer.launch({
        headless: false,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--profile-directory=Profile 1',
        ],
    });
    const page = await browser.newPage();

    await page.goto('https://skemaraja.dephub.go.id/logout', { waitUntil: 'domcontentloaded' });

    await page.goto('https://skemaraja.dephub.go.id');
    await new Promise((resolve) => setTimeout(resolve, 1000));

    const firstSpan = await page.$eval('span', (el) => el.innerText.trim());
    if (firstSpan !== 'SKEMA') {
        await page.reload({ waitUntil: ['networkidle0', 'domcontentloaded'] });
    }
    // Wait for form to load
    await page.waitForSelector('form#theForm input[name="_token"]');

    // Fill in form
    await page.type('input[name="nip"]', nip);
    await page.type('input[name="password"]', password);
    await page.select('select[name="status_wfh"]', '2');

    // Select shift (from argument)

    await page.waitForSelector(`input[value="${shift}"]`, { visible: true });
    await page.click(`input[value="${shift}"]`);
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // // Wait for and click submit
    // await page.waitForSelector('#btnSubmit:not([disabled])');
    // try {
    //     await Promise.all([page.click('#btnSubmit'), page.waitForNavigation({ waitUntil: 'networkidle0', timeout: 60000 })]);
    // } catch (error) {
    //     await page.reload({ waitUntil: ['networkidle0', 'domcontentloaded'] });
    // }

    // let name;

    // try {
    //     // Try to find and get the first <h1> text
    //     name = await page.$eval('p', (el) => el.innerText.trim());
    //     if (name !== 'Untuk keamanan yang lebih baik, mohon segera lakukan perubahan password. klik disini untuk ganti password.') {
    //         await page.reload({ waitUntil: ['networkidle0', 'domcontentloaded'] });
    //     }
    // } catch (error) {
    //     await page.reload({ waitUntil: ['networkidle0', 'domcontentloaded'] });

    //     await page.waitForTimeout(2000);
    //     name = await page.$eval('p', (el) => el.innerText.trim());
    // }
    // if (name !== 'Untuk keamanan yang lebih baik, mohon segera lakukan perubahan password. klik disini untuk ganti password.') {
    //     await page.reload({ waitUntil: ['networkidle0', 'domcontentloaded'] });
    // }

    // const profile = await page.$eval('.profile-username', (el) => el.innerText.trim());
    // console.log(`Absen Berhasil: ${profile}`);

    // await browser.close();
})();
