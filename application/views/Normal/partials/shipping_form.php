<label for="first_name">First Name:</label>
<input type="text" name="first_name" value="<?= $shipping_data['first_name'] ?>"/>

<label for="last_name">Last Name:</label>
<input type="text" name="last_name" value="<?= $shipping_data['last_name'] ?>"/>

<label for="address1">Address:</label>
<textarea name="address1" ><?= $shipping_data['address1'] ?></textarea>

<label for="address">Address 2:</label>
<textarea name="address2" ><?= $shipping_data['address2'] ?></textarea>

<label for="city">City:</label>
<input type="text" name="city" value="<?= $shipping_data['city'] ?>">

<label for="state">State:</label>
<input type="text" name="state" value="<?= $shipping_data['state'] ?>">

<label for="zipcode">Zipcode:</label>
<input type="text" name="zipcode" value="<?= $shipping_data['zipcode'] ?>">

<input type="submit" message="Shipping information successfully updated!" value="Save">