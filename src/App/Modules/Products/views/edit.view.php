{% extends "Common/views/base.view.php" %}

{% block title %}Edit Product{% endblock %}

{% block body %}

<h1>Edit Product</h1>

<p><a href="/products/{{product['id']}}/show">Cancel</a></p>

<form method="POST" action="/products/{{product['id']}}/update">

  {% include "Modules/Products/views/form.view.php" %}

</form>

{% endblock %}