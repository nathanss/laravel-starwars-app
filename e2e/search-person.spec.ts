import { expect, test } from '@playwright/test';

test('can search for Chewbacca and view details', async ({ page }) => {
    await page.goto('http://localhost/');

    // Type Chewbacca in the search input and hit Enter
    await page.getByPlaceholder('e.g. Chewbacca, Yoda, Boba Fett').fill('Chewbacca');
    await page.keyboard.press('Enter');

    // Wait for search results and click the See details button
    await page.getByRole('button', { name: 'See details' }).click();

    // Verify we're on Chewbacca's details page
    await expect(page.locator('h2:has-text("Chewbacca")')).toBeVisible();

    await page.getByRole('link', { name: 'A New Hope' }).click();
    await expect(page.locator('h2', { hasText: /a new hope/i })).toBeVisible();
});
