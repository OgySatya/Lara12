import puppeteer from 'puppeteer';
const [, , nip, shift] = process.argv;

(async () => {

const browser = await puppeteer.launch({
  headless: false,
  userDataDir: 'C:\\Users\\Rapht\\AppData\\Local\\Google\\Chrome for Testing\\User Data',
  args: [
    '--no-sandbox',
    '--disable-setuid-sandbox',
    '--profile-directory=Profile 1',
  ]
});

    const page = await browser.newPage();

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
    
    await page.waitForSelector(`input[value="${shift}"]`, { visible: true });
    await page.click(`input[value="${shift}"]`);
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // Wait for and click submit
    // await page.waitForSelector('#btnSubmit:not([disabled])');
    // await Promise.all([page.click('#btnSubmit'), page.waitForNavigation({ waitUntil: 'networkidle0', timeout: 60000 })]);

    await browser.close();
})();
