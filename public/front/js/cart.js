// document.addEventListener('DOMContentLoaded', () => {
//     // تحديث الكمية وحذف العناصر
//     document.querySelectorAll('.cart-item').forEach(item => {
//         const cartId = item.getAttribute('data-id');
//         const quantityElement = item.querySelector('.quantity-value');
//         const priceElement = item.querySelector('.price');
//         const basePrice = parseFloat(item.getAttribute('data-base-price'));

//         item.querySelector('.increase').addEventListener('click', () => {
//             let quantity = parseInt(quantityElement.textContent);
//             quantity++;
//             updateQuantity(cartId, quantity);
//         });

//         item.querySelector('.decrease').addEventListener('click', () => {
//             let quantity = parseInt(quantityElement.textContent);
//             if (quantity > 1) {
//                 quantity--;
//                 updateQuantity(cartId, quantity);
//             } else {
//                 removeItem(cartId);
//             }
//         });

//         item.querySelector('.remove').addEventListener('click', () => {
//             removeItem(cartId);
//         });
//     });

//     // عرض الـ Prescription Modal
//     const orderNowButton = document.getElementById('order-now');
//     const prescriptionModal = document.getElementById('prescription-modal');
//     const confirmationModal = document.getElementById('confirmation-modal');
//     if (orderNowButton && prescriptionModal) {
//         orderNowButton.addEventListener('click', () => {
//             prescriptionModal.style.display = 'flex';
//         });
//     }

//     // إرسال الروشتة بـ AJAX
//     const prescriptionForm = document.getElementById('prescription-form');
//     if (prescriptionForm) {
//         prescriptionForm.addEventListener('submit', (e) => {
//             e.preventDefault();
//             const formData = new FormData(prescriptionForm);

//             fetch(prescriptionForm.action, {
//                 method: 'POST',
//                 headers: {
//                     'X-Requested-With': 'XMLHttpRequest',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                 },
//                 body: formData,
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         prescriptionModal.style.display = 'none';
//                         confirmationModal.style.display = 'flex';
//                         document.querySelector('.cart-items').innerHTML = ''; // تصفير السلة
//                         updateTotal();
//                         checkEmptyCart();
//                     } else {
//                         alert(data.message || 'حدث خطأ أثناء تقديم الطلب');
//                     }
//                 })
//                 .catch(error => console.error('Error submitting order:', error));
//         });
//     }

//     // إغلاق الـ Confirmation Modal عند الضغط على الرابط
//     if (confirmationModal) {
//         confirmationModal.querySelector('a').addEventListener('click', () => {
//             modal-content.style.display = 'hidden';
//         });
//     }

//     // تحديث الإجمالي
//     function updateTotal() {
//         let subtotal = 0;
//         document.querySelectorAll('.cart-item').forEach(item => {
//             const quantity = parseInt(item.querySelector('.quantity-value').textContent);
//             const price = parseFloat(item.getAttribute('data-base-price'));
//             subtotal += quantity * price;
//         });

//         const shipping = parseFloat(document.querySelector('.shipping').textContent);
//         const total = subtotal + shipping;

//         document.querySelector('.subtotal').textContent = subtotal.toFixed(2);
//         document.querySelector('.total').textContent = total.toFixed(2);
//     }

//     // التحقق من السلة الفارغة
//     function checkEmptyCart() {
//         const cartItems = document.querySelectorAll('.cart-item');
//         const salaemp = document.querySelector('.salaemp');
//         const cartContainer = document.querySelector('.cart-container');
//         if (cartItems.length === 0 && cartContainer && salaemp) {
//             cartContainer.style.display = 'none';
//             salaemp.style.display = 'flex';
//         }
//     }

//     function updateQuantity(cartId, quantity) {
//         fetch(`/cart/update/${cartId}`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-Requested-With': 'XMLHttpRequest',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//             },
//             body: JSON.stringify({ quantity: quantity })
//         })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
//                     if (quantity < 1) {
//                         item.remove();
//                     } else {
//                         item.querySelector('.quantity-value').textContent = quantity;
//                         item.querySelector('.price').textContent = (quantity * parseFloat(item.getAttribute('data-base-price'))).toFixed(2) + ' ₪';
//                     }
//                     updateTotal();
//                     checkEmptyCart();
//                     document.dispatchEvent(new Event('cartUpdated'));
//                 }
//             })
//             .catch(error => console.error('Error updating quantity:', error));
//     }

//     function removeItem(cartId) {
//         fetch(`/cart/remove/${cartId}`, {
//             method: 'DELETE',
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//             },
//         })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
//                     if (item) {
//                         item.remove();
//                         updateTotal();
//                         checkEmptyCart();
//                         document.dispatchEvent(new Event('cartUpdated'));
//                     }
//                 }
//             })
//             .catch(error => console.error('Error removing item:', error));
//     }

//     checkEmptyCart();
// });


document.addEventListener('DOMContentLoaded', () => {
    // تحديث الكمية وحذف العناصر
    document.querySelectorAll('.cart-item').forEach(item => {
        const cartId = item.getAttribute('data-id');
        const quantityElement = item.querySelector('.quantity-value');
        const priceElement = item.querySelector('.price');
        const basePrice = parseFloat(item.getAttribute('data-base-price'));

        item.querySelector('.increase').addEventListener('click', () => {
            let quantity = parseInt(quantityElement.textContent);
            quantity++;
            updateQuantity(cartId, quantity);
        });

        item.querySelector('.decrease').addEventListener('click', () => {
            let quantity = parseInt(quantityElement.textContent);
            if (quantity > 1) {
                quantity--;
                updateQuantity(cartId, quantity);
            } else {
                removeItem(cartId);
            }
        });

        item.querySelector('.remove').addEventListener('click', () => {
            removeItem(cartId);
        });
    });

    // عرض الـ Prescription Modal
    const orderNowButton = document.getElementById('order-now');
    const prescriptionModal = document.getElementById('prescription-modal');
    const confirmationModal = document.getElementById('confirmation-modal');

    if (orderNowButton && prescriptionModal) {
        orderNowButton.addEventListener('click', () => {
            prescriptionModal.style.display = 'flex';
        });
    }

    // إغلاق الـ prescription modal لما يضغط على الخلفية
    if (prescriptionModal) {
        prescriptionModal.addEventListener('click', (e) => {
            if (e.target === prescriptionModal) {
                prescriptionModal.style.display = 'none';
            }
        });
    }

    // إرسال الروشتة بـ AJAX
    const prescriptionForm = document.getElementById('prescription-form');
    if (prescriptionForm) {
        prescriptionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(prescriptionForm);

            fetch(prescriptionForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        prescriptionModal.style.display = 'none';
                        confirmationModal.style.display = 'flex';
                        confirmationModal.querySelector('h3').textContent = 'تم تقديم طلباتك بنجاح!';
                        document.querySelector('.cart-items').innerHTML = ''; // تصفير السلة
                        updateTotal();
                        checkEmptyCart();
                    } else {
                        alert(data.message || 'حدث خطأ أثناء تقديم الطلب');
                    }
                })
                .catch(error => console.error('Error submitting order:', error));
        });
    }

    // إغلاق الـ Confirmation Modal لما يضغط على الخلفية
    if (confirmationModal) {
        confirmationModal.addEventListener('click', (e) => {
            if (e.target === confirmationModal) {
                confirmationModal.style.display = 'none';
                checkEmptyCart(); // التأكد من ظهور رسالة السلة الفارغة
            }
        });

        // إغلاق الـ Confirmation Modal لما يضغط على الرابط
        confirmationModal.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault(); // منع الانتقال للرابط
            confirmationModal.style.display = 'none';
            checkEmptyCart(); // التأكد من ظهور رسالة السلة الفارغة
        });
    }

    // تحديث الإجمالي
    function updateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-value').textContent);
            const price = parseFloat(item.getAttribute('data-base-price'));
            subtotal += quantity * price;
        });

        const shipping = parseFloat(document.querySelector('.shipping').textContent) || 0;
        const total = subtotal + shipping;

        document.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        document.querySelector('.total').textContent = total.toFixed(2);
    }

    // التحقق من السلة الفارغة
    function checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        const salaemp = document.querySelector('.salaemp');
        const cartContainer = document.querySelector('.cart-container');

        console.log('Cart items:', cartItems.length); // للتصحيح
        console.log('Salaemp:', salaemp);
        console.log('Cart container:', cartContainer);

        if (cartItems.length === 0 && cartContainer && salaemp) {
            cartContainer.style.display = 'none';
            salaemp.style.display = 'flex';
        } else {
            cartContainer.style.display = 'flex';
            salaemp.style.display = 'none';
        }
    }

    function updateQuantity(cartId, quantity) {
        fetch(`/cart/update/${cartId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ quantity: quantity })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
                    if (quantity < 1) {
                        item.remove();
                    } else {
                        item.querySelector('.quantity-value').textContent = quantity;
                        item.querySelector('.price').textContent = (quantity * parseFloat(item.getAttribute('data-base-price'))).toFixed(2) + ' ₪';
                    }
                    updateTotal();
                    checkEmptyCart();
                    document.dispatchEvent(new Event('cartUpdated'));
                }
            })
            .catch(error => console.error('Error updating quantity:', error));
    }

    function removeItem(cartId) {
        fetch(`/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
                    if (item) {
                        item.remove();
                        updateTotal();
                        checkEmptyCart();
                        document.dispatchEvent(new Event('cartUpdated'));
                    }
                }
            })
            .catch(error => console.error('Error removing item:', error));
    }

    checkEmptyCart();
});