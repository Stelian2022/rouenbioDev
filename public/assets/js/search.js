// const searchInput = document.getElementById('searchInput');
// searchInput.addEventListener('input', performSearch);

// function performSearch() {
//     const query = searchInput.value.trim();

//     fetch('/search', {  
//         method: 'POST',
//         body: JSON.stringify({ query: query }),
//         headers: {
//             'Content-Type': 'application/json',
//         },
//     })
//     .then(response => response.json())
//     .then(data => {
//         updateSearchResults(data);
//         console.dir(data); // Log the response data
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// }

// function updateSearchResults(data) {
//     const searchResults = document.getElementById('searchResults');
//     searchResults.innerHTML = '';

//     data.forEach(produits => {
//         const li = document.createElement('li');
//         li.textContent = produits.nom_produit;
//         searchResults.appendChild(li);
//     });
// }
