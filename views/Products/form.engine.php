<label for="name">Name</label>
<input type="text" id="name" name="name" value="{{product['name']}}">

<?php if (isset($errors['name'])) { ?>
  <p>{{errors['name']}}</p>
<?php } ?>

<label for="description">Desctiprion</label>
<textarea type="text" id="description" name="description">{{product['description']}}</textarea>

<button type="submit">Save</button>