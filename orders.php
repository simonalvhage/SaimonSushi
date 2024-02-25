<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inkommande beställningar</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="">
  <div>
    <h1 class="mt-4">Inkommande beställningar</h1>
    <div id="orderList" class="list-group">
      <!-- Inkommande beställningar läggs till här -->
    </div>
  </div>
</div>
<style>
  .list-group-item {
    max-width: 600px; /* justera bredden efter behov */
    margin-bottom: 10px;
  }
</style>

<script>
  // Funktion för att uppdatera listan var 5:e sekund
  function updateOrderList() {
    // Hämta data från servern
    fetch('get_orders.php')
      .then(response => response.json())
      .then(data => {
        // Rensa befintliga beställningar i listan
        document.getElementById('orderList').innerHTML = '';

        // Lägg till varje beställning i listan
        data.forEach(order => {
          var orderDetails = order.dishes.split(', ').map((dish, index) => `${order.quantities.split(', ')[index]}st ${dish}`).join('<br>');
          var orderItem = `
            <div class="list-group-item">
              <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 24px;"><strong>Bord ${order.table_number}</strong></div>
                <div style="flex-grow: 1; padding-left: 20px;">
                  <p><strong>Beställningar:</strong><br>${orderDetails}</p>
                  <p><small>Tid för beställning: ${order.order_time}</small></p>
                </div>
                <button class="btn btn-outline-danger delete-btn" data-order-id="${order.order_id}">✕</button>
              </div>
            </div>
          `;
          document.getElementById('orderList').innerHTML += orderItem;
        });
      });
  }

  // Uppdatera listan direkt när sidan laddas
  updateOrderList();

  // Uppdatera listan var 5:e sekund
  setInterval(updateOrderList, 5000);

  // Lyssna på klick för att ta bort beställning
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-btn')) {
      var orderId = event.target.dataset.orderId;
      fetch(`delete_orders.php?order_id=${orderId}`, { method: 'GET' })
        .then(response => {
          if (response.ok) {
            updateOrderList(); // Uppdatera listan efter att beställningen har tagits bort
          }
        });
    }
  });
</script>

</body>
</html>
