// التحكم في التبويبات
const tabs = document.querySelectorAll(".tab-button");
const tabContents = document.querySelectorAll(".tab-content");

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");
        tabContents.forEach((content) => content.classList.add("hidden"));
        document.getElementById(tab.dataset.tab).classList.remove("hidden");
    });
});

// التحكم في الكمية والسعر
const decreaseBtn = document.getElementById("decrease");
const increaseBtn = document.getElementById("increase");
const quantitySpan = document.getElementById("quantity");
const priceElement = document.querySelector(".price");
const totalPriceSpan = document.getElementById("total-price");
const basePrice = parseFloat(priceElement.getAttribute("data-base-price"));
let quantity = parseInt(quantitySpan.textContent) || 1;

function updateTotalPrice() {
    const totalPrice = basePrice * quantity;
    totalPriceSpan.textContent = totalPrice.toFixed(2);
}

decreaseBtn.addEventListener("click", () => {
    if (quantity > 1) {
        quantity--;
        quantitySpan.textContent = quantity;
        updateTotalPrice();
    }
});

increaseBtn.addEventListener("click", () => {
    quantity++;
    quantitySpan.textContent = quantity;
    updateTotalPrice();
});

updateTotalPrice();

// إضافة إلى السلة
const addToCartButton = document.querySelector(".add-to-cart");
if (addToCartButton) {
    addToCartButton.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("تم النقر على زر أضف للسلة!");
        const inventoryId = addToCartButton.getAttribute("data-inventory-id");

        fetch(`/cart/add/${inventoryId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ quantity: quantity }),
        })
        .then((response) => {
            console.log("استجابة الخادم:", response);
            if (!response.ok) {
                return response.json().then((errorData) => {
                    throw new Error(errorData.message || "فشل في معالجة الطلب");
                });
            }
            return response.json();
        })
        .then((data) => {
            console.log("البيانات المرجعة:", data);
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "تم بنجاح!",
                    text: "تم إضافة المنتج إلى السلة بنجاح",
                    confirmButtonText: "موافق",
                    timer: 3000,
                    timerProgressBar: true,
                });
                // إطلاق حدث لتحديث العدد في الهيدر
                const event = new Event('cartUpdated');
                document.dispatchEvent(event);
            }
        })
        .catch((error) => {
            console.error("خطأ في الطلب:", error);
            Swal.fire({
                icon: "error",
                title: "خطأ!",
                text: error.message,
                confirmButtonText: "موافق",
            });
        });
    });
} else {
    console.error("زر أضف للسلة غير موجود!");
}
