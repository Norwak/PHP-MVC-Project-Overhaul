{% extends "base.engine.php" %}

{% block title %}Edit Product{% endblock %}

{% block body %}

<h1>Edit Product</h1>

<p><a href="/products/{{product['id']}}/show">Cancel</a></p>

<form method="POST" action="/products/{{product['id']}}/update">

  {% include "Products/form.engine.php" %}

</form>

{% endblock %}