document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.pagination-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const page = this.getAttribute('data-page');
            const productList = document.getElementById('product-list');

            fetch(`/shopMVC2/productController/allProducts/${page}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                productList.innerHTML = data;
            })
            .catch(error => console.error('Error fetching data:', error));
        });
    });
});
