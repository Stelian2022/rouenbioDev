$(document).ready(function() {
    // Augmenter la quantité
    $('.increase-quantity').on('click', function() {
        var quantityInput = $(this).closest('.input-group').find('.quantity-input');
        var currentQuantity = parseInt(quantityInput.val());
        quantityInput.val(currentQuantity + 1);
    });

    // Diminuer la quantité
    $('.decrease-quantity').on('click', function() {
        var quantityInput = $(this).closest('.input-group').find('.quantity-input');
        var currentQuantity = parseInt(quantityInput.val());
        if (currentQuantity > 0) {
            quantityInput.val(currentQuantity - 1);
        }
    });

    // Ajouter au panier
    $('.add-to-cart-btn').on('click', function() {
        var productId = $(this).data('product-id');
        var quantity = $(this).closest('.input-group').find('.quantity-input').val();

        // Envoyer les données au serveur (par exemple, via une requête AJAX)
        // Ici, vous devez implémenter une logique pour ajouter le produit au panier côté serveur
        // En fonction de votre application, cela peut varier.
        $.ajax({
            url: '/ajouter-au-panier',  // Remplacez par l'URL appropriée pour ajouter au panier
            method: 'POST',
            data: {
                productId: productId,
                quantity: quantity
            },
            success: function(response) {
                // Gérer la réponse du serveur (par exemple, afficher un message de succès)
                console.log(response);
            },
            error: function(error) {
                // Gérer les erreurs
                console.error(error);
            }
        });
    });
});