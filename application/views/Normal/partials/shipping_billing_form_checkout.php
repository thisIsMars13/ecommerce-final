<h3>Shipping Information</h3>

<label for="first_name">First Name:</label>
<input type="text" name="shipping_first_name" value="<?= $shipping_data['first_name'] ?>"/>

<label for="last_name">Last Name:</label>
<input type="text" name="shipping_last_name" value="<?= $shipping_data['last_name'] ?>"/>

<label for="address1">Address:</label>
<textarea name="shipping_address1" ><?= $shipping_data['address1'] ?></textarea>

<label for="address">Address 2:</label>
<textarea name="shipping_address2" ><?= $shipping_data['address2'] ?></textarea>

<label for="city">City:</label>
<input type="text" name="shipping_city" value="<?= $shipping_data['city'] ?>">

<label for="state">State:</label>
<input type="text" name="shipping_state" value="<?= $shipping_data['state'] ?>">

<label for="zipcode">Zipcode:</label>
<input type="text" name="shipping_zipcode" value="<?= $shipping_data['zipcode'] ?>">

<h3>Billing Information</h3>

<label for="first_name">First Name:</label>
<input type="text" name="billing_first_name" value="<?= $billing_form['first_name'] ?>"/>

<label for="last_name">Last Name:</label>
<input type="text" name="billing_last_name" value="<?= $billing_form['last_name'] ?>"/>

<label for="address1">Address:</label>
<textarea name="billing_address1"><?= $billing_form['address1'] ?></textarea>

<label for="address">Address 2:</label>
<textarea name="billing_address2"><?= $billing_form['address2'] ?></textarea>

<label for="city">City:</label>
<input type="text" name="billing_city" value="<?= $billing_form['city'] ?>"/>

<label for="state">State:</label>
<input type="text" name="billing_state" value="<?= $billing_form['state'] ?>">

<label for="zipcode">Zipcode:</label>
<input type="text" name="billing_zipcode" value="<?= $billing_form['zipcode'] ?>"/>
<input type="submit" id="pay_button" value="Pay">
<input id="need_validate" type="hidden" name="validate" value="1">

