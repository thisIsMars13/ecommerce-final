<label for="first_name">First Name:</label>
<input type="text" name="first_name" value="<?= $billing_form['first_name'] ?>"/>

<label for="last_name">Last Name:</label>
<input type="text" name="last_name" value="<?= $billing_form['last_name'] ?>"/>

<label for="address1">Address:</label>
<textarea name="address1"><?= $billing_form['address1'] ?></textarea>

<label for="address">Address 2:</label>
<textarea name="address2"><?= $billing_form['address2'] ?></textarea>

<label for="city">City:</label>
<input type="text" name="city" value="<?= $billing_form['city'] ?>"/>

<label for="state">State:</label>
<input type="text" name="state" value="<?= $billing_form['state'] ?>">

<label for="zipcode">Zipcode:</label>
<input type="text" name="zipcode" value="<?= $billing_form['zipcode'] ?>"/>

<input type="submit" message="Billing information successfully updated!" value="Save"/>