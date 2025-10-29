(function(){
  const STORAGE_KEY = 'cond_cart';
  let selectedService = null;

  const getCart = () => JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
  const setCart = (items) => localStorage.setItem(STORAGE_KEY, JSON.stringify(items));

  // العناصر داخل المودال
  const modalName = document.getElementById('modalName');
  const modalPrice = document.getElementById('modalPrice');
  const modalThumb = document.getElementById('modalThumb');
  const modalQty = document.getElementById('modalQty');
  const confirmBtn = document.getElementById('confirmBooking');
  const bookingModalEl = document.getElementById('bookingModal');

  // تأكد من وجود المودال قبل إنشاء كائن Bootstrap
  const bookingModal = bookingModalEl ? new bootstrap.Modal(bookingModalEl) : null;

  // Fetch لجلب المنتجات
  const requestOptions = {
    method: "GET",
    redirect: "follow"
  };

  fetch("http://localhost/Page-master/Page-master/getProduct.php", requestOptions)
    .then((response) => response.json()) // تأكد من تحويل الاستجابة إلى JSON
    .then((products) => {
      console.log(products);
      // يمكنك معالجة البيانات هنا، مثل عرضها في واجهة المستخدم
    })
    .catch((error) => console.error('Error fetching products:', error));

  // عند الضغط على "احجز الآن"
  document.querySelectorAll('.overlay-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const name = btn.dataset.name;
      const price = btn.dataset.price;
      const thumb = btn.dataset.thumb;
      const id = btn.dataset.id;

      selectedService = { id, name, price: Number(price), thumb };

      // عرض البيانات في المودال
      if (modalName) modalName.textContent = name;
      if (modalPrice) modalPrice.textContent = `${price} ر.س`;
      if (modalThumb) modalThumb.src = thumb;
      if (modalQty) modalQty.value = 1;

      if (bookingModal) bookingModal.show();
    });
  });

  // عند تأكيد الحجز
  if (confirmBtn) {
    confirmBtn.addEventListener('click', () => {
      if (!selectedService) return;
      const qty = Number(modalQty.value) || 1;
      const cart = getCart();

      const existing = cart.find(item => item.id === selectedService.id);
      if (existing) {
        existing.qty += qty;
      } else {
        cart.push({ ...selectedService, qty });
      }

      setCart(cart);
      if (bookingModal) bookingModal.hide();
      alert('✅ تمت إضافة الخدمة إلى السلة بنجاح!');
    });
  }
})();

var myCenter = new google.maps.LatLng(51.308742, -0.320850);
function initialize() {
  var mapProp = {
    center: myCenter,
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("map"), mapProp);

  var marker = new google.maps.Marker({
    position: myCenter,
  });
  marker.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);