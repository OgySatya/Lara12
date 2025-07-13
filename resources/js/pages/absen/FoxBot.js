import { firefox } from 'playwright'; // use chromium / webkit if preferred

const [, , nip, shift] = process.argv;

(async () => {
  const browser = await firefox.launch({ headless: false }); // change to true for headless mode
  const context = await browser.newContext(); // optionally: use context.storageState() to persist login
  const page = await context.newPage();

  // Logout to reset session
  await page.goto('https://skemaraja.dephub.go.id/logout', { waitUntil: 'domcontentloaded' });

  // Go to main page
  await page.goto('https://skemaraja.dephub.go.id');
  await page.waitForTimeout(1000); // wait 1 second

  // Wait for the form to load
  await page.waitForSelector('form#theForm input[name="_token"]');

  // Fill out the form
  await page.fill('input[name="nip"]', nip);
  await page.fill('input[name="password"]', nip);
  await page.selectOption('select[name="status_wfh"]', '2');

  // Select shift (based on CLI argument)
  await page.waitForSelector(`input[value="${shift}"]`, { state: 'visible' });
  await page.click(`input[value="${shift}"]`);

  // OPTIONAL: Click submit
  // await page.click('#btnSubmit');
  // await page.waitForNavigation({ waitUntil: 'networkidle' });

  await browser.close();
})();
