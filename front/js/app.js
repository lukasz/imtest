'use strict'

const apiUrl = "http://localhost:5000";

window.addEventListener('load', async function () {
    const root = document.querySelector('.root');
    const response = await fetch(`${apiUrl}/recipes`);
    const recipes = await response.json();

    root.innerHTML = `<h1>Correctly Fetched ${Object.keys(recipes).length} Recipes</h1>`;
})