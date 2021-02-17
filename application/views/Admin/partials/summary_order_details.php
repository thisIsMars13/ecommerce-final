<h3>Order ID: <?= $data[0]['id'] ?></h3>

<strong>Customer Shipping Info:</strong>
<p>Name: <?= $data[0]['shipping_first_name'] . ' ' . $data[0]['shipping_last_name']?></p>
<p>Address: <?= $data[0]['shipping_add1'] ?></p>
<p>City: <?= $data[0]['shipping_city'] ?></p>
<p>State: <?= $data[0]['shipping_state'] ?></p>
<p>Zip: <?= $data[0]['shipping_zipcode'] ?></p> 

<strong>Customer Billing Info:</strong>
<p>Name: <?= $data[0]['billing_first_name']. ' ' . $data[0]['billing_last_name'] ?></p>
<p>Address: <?= $data[0]['billing_add1'] ?></p>
<p>City: <?= $data[0]['billing_city'] ?></p>
<p>State: <?= $data[0]['billing_state'] ?></p>
<p>Zip: <?= $data[0]['billing_zipcode'] ?></p>      