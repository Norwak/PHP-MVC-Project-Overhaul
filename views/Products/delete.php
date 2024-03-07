<h1>Delete Product</h1>

<p><a href="/products/<?=$product["id"]?>/show">Cancel</a></p>

<form method="POST" action="/products/<?=$product["id"]?>/remove">

  <p>Delete this product?</p>
  <button type="submit">Yes</button>

</form>