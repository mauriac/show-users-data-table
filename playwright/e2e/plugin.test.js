const { chromium } = require('playwright');
const { test } = require('@playwright/test');

test('basic', async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.goto('http://localhost:8000/wp-admin/install.php');
  
  // Add your installation and login steps here);

  // Check if the plugin is activated
  const pluginSelector =
  'tr[data-slug="wp-staging-dev/wp-staging-pro.php"] .activate a';
  const isActivated = (await page.$(pluginSelector)) === null;

  console.log(isActivated ? "Plugin is activated" : "Plugin is not activated");

  // Sample test: Check if the WordPress site is up
  await page.goto('http://localhost:8000');
  await page.screenshot({ path: 'screenshot.png' });
  await browser.close();
});
