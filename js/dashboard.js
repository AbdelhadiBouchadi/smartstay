// Dashboard functionality
function cancelBooking(bookingId) {
  if (!confirm('Are you sure you want to cancel this booking?')) {
    return;
  }

  // Send AJAX request to cancel booking independently of Prototype.js library
  const xhr = new XMLHttpRequest();
  xhr.open('POST', './php/cancelBooking.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        location.reload();
      } else {
        alert('Failed to cancel booking: ' + response.message);
      }
    } else {
      alert('Failed to cancel booking. Please try again.');
    }
  };

  xhr.send('booking_id=' + bookingId);
}

function filterBookings() {
  const status = document.getElementById('statusFilter').value;
  console.log('Selected status:', status);

  // Send AJAX request to fetch bookings based on the selected status independently of Prototype.js library
  const xhr = new XMLHttpRequest();
  xhr.open('POST', './php/fetchBookings.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      const container = document.getElementById('bookingsContainer');
      container.innerHTML = '';

      if (response.bookings.length === 0) {
        container.innerHTML =
          '<p class="no-bookings">No bookings found for this filter.</p>';
        return;
      }

      response.bookings.forEach((booking) => {
        const card = document.createElement('div');
        card.className = 'booking-card';
        card.innerHTML = `
          <img src="${booking.image_url}" alt="${booking.room_name}">
          <div class="booking-info">
            <h3>${booking.room_name}</h3>
            <p>Check-in: ${new Date(booking.check_in).toLocaleDateString()}</p>
            <p>Check-out: ${new Date(
              booking.check_out
            ).toLocaleDateString()}</p>
            <p class="price">Total: $${parseFloat(booking.total_price).toFixed(
              2
            )}</p>
            <p class="status ${booking.bookingStatus}">${
          booking.bookingStatus.charAt(0).toUpperCase() +
          booking.bookingStatus.slice(1)
        }</p>
            ${
              booking.bookingStatus === 'pending'
                ? `<button class="btn-cancel" onclick="cancelBooking(${booking.id})">Cancel Booking</button>`
                : ''
            }
          </div>
        `;
        container.appendChild(card);
      });
    } else {
      alert('Failed to filter bookings.');
    }
  };

  xhr.send('status=' + encodeURIComponent(status));
}

// Load all bookings by default
window.onload = filterBookings;
