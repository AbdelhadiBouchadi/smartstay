// Booking form functionality
document.addEventListener('DOMContentLoaded', function () {
  const checkInInput = document.getElementById('check_in');
  const checkOutInput = document.getElementById('check_out');
  const pricePreview = document.getElementById('price-preview');
  const roomPrice = parseFloat(
    document.querySelector('.price').textContent.replace('$', '')
  );

  function updatePricePreview() {
    const checkIn = new Date(checkInInput.value);
    const checkOut = new Date(checkOutInput.value);

    if (checkIn && checkOut && checkOut > checkIn) {
      const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
      const totalPrice = nights * roomPrice;
      pricePreview.textContent = `Total for ${nights} nights would be: $${totalPrice.toFixed(
        2
      )}`;
    } else {
      pricePreview.textContent = '';
    }
  }

  checkInInput.addEventListener('change', function () {
    const nextDay = new Date(this.value);
    nextDay.setDate(nextDay.getDate() + 1);
    checkOutInput.min = nextDay.toISOString().split('T')[0];
    updatePricePreview();
  });

  checkOutInput.addEventListener('change', updatePricePreview);
});

function validateBooking() {
  const checkIn = new Date(document.getElementById('check_in').value);
  const checkOut = new Date(document.getElementById('check_out').value);

  if (!checkIn || !checkOut) {
    alert('Please select both check-in and check-out dates');
    return false;
  }

  if (checkOut <= checkIn) {
    alert('Check-out date must be after check-in date');
    return false;
  }

  return true;
}
