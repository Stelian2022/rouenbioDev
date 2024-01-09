 // Supposons que vous avez une variable 'cartQuantity' qui contient la quantité actuelle dans le panier
 var cartQuantity = 0; // Initialisez à la valeur actuelle du panier

 // Fonction pour mettre à jour la quantité dans le badge
 function updateCartQuantityBadge() {
     var cartQuantityBadge = document.getElementById('cart-quantity-badge');
     cartQuantityBadge.textContent = cartQuantity.toString();
 }

 // Exemple d'ajout d'un produit au panier (à adapter à votre propre logique)
 function addToCart() {
     cartQuantity += 1; // Augmentez la quantité lorsque vous ajoutez un produit au panier
     updateCartQuantityBadge(); // Mettez à jour la quantité dans le badge
 }

 // Exemple de suppression d'un produit du panier (à adapter à votre propre logique)
 function removeFromCart() {
     if (cartQuantity > 0) {
         cartQuantity -= 1; // Diminuez la quantité lorsque vous retirez un produit du panier
         updateCartQuantityBadge(); // Mettez à jour la quantité dans le badge
     }
 }

 // Appelez la fonction updateCartQuantityBadge une fois au début pour initialiser la quantité
 updateCartQuantityBadge();