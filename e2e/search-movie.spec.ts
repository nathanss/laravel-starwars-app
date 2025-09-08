import { expect, test } from '@playwright/test';

test('can search for movie, view details and navigate to a related character', async ({ page }) => {
    await page.goto('http://localhost/');

    // Select Movies radio button
    await page.getByLabel('Movies').click();

    // Type movie title in the search input and hit Enter
    await page.getByPlaceholder('e.g. A New Hope, Empire Strikes Back').fill('Empire Strikes Back');
    await page.keyboard.press('Enter');

    // Wait for search results and click the See details button
    await page.getByRole('button', { name: 'See details' }).click();

    // Verify we're on the movie's details page
    await expect(page.locator('h2', { hasText: /empire strikes back/i })).toBeVisible();

    await page.getByRole('link', { name: 'Luke Skywalker' }).click();
    await expect(page.locator('h2', { hasText: /luke skywalker/i })).toBeVisible();
});
